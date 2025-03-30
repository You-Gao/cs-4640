
<?php

class GameController {

  private $db;

  private $errorMessage = "";

  /**
   * Constructor
   */
  public function __construct($input) {
    // Start the session!
    session_start();
    $this->db = new Database();
    $this->input = $input;
  }

  /**
   * Run the server
   * 
   * Given the input (usually $_GET), then it will determine
   * which command to execute based on the given "command"
   * parameter.  Default is the welcome page.
   */
  public function run() {
    // Get the command
    $command = "welcome";
    if (isset($this->input["command"]) && (
      $this->input["command"] == "login" || isset($_SESSION["name"])))
      $command = $this->input["command"];

    switch($command) {
      case "login": 
        $this->login();
        break;
      case "answer":
        $this->answerQuestion();
        break;
      case "scramble":
        $this->scramble();
        break;
      case "new":
        $this->newQuestion();
        break;
      case "gameover":
        $this->showGameover();
        break;
      case "question":
        $this->showQuestion();
        break;
      case "logout": 
        $this->logout(); // notice no break 
      case "welcome":
      default:
        $this->showWelcome();
        break;
    }
  }

  public function login() {
    if (isset($_POST["fullname"]) && isset($_POST["email"]) &&
      isset($_POST["password"]) && !empty($_POST["password"]) &&
      !empty($_POST["fullname"]) && !empty($_POST["email"])) {
      // TODO: check that email looks right!

      $results = $this->db->query("select * from hw6_users where email = $1;", $_POST["email"]);

      if (empty($results)) {
        // create the user account
        $result = $this->db->query("insert into hw6_users 
          (name, email, password, max_score, total_score, average_score, games_won, games_played, win_percent) 
          values ($1, $2, $3, 0,0,0,0,0,0);",
          $_POST["fullname"], $_POST["email"], 
          password_hash($_POST["password"], PASSWORD_DEFAULT));
        
        $_SESSION["name"] = $_POST["fullname"];
        $_SESSION["email"] = $_POST["email"];
        
        header("Location: ?command=new");
        return;
      } else {
        // check that the user's password is correct
        $hashed_password = $results[0]["password"];
        $correct = password_verify($_POST["password"], $hashed_password);
        if ($correct) {
          // Success!
          $_SESSION["name"] = $_POST["fullname"];
          $_SESSION["email"] = $_POST["email"];
          // call showQuestion OR ...
          // redirect with a header to the question screen
          header("Location: ?command=new");
          return;
        } else {
         $message = "<p class='alert alert-danger'>Incorrect password!</p>"; 
        }
      }
      $this->showWelcome($message);
      return;
    }

    $this->showWelcome("Name or email missing");
  }

  public function newQuestion() {
    //get new question
    $userid = $this->db->query("select id, name from hw6_users where email = $1;", $_SESSION["email"])[0]["id"];
    $results = $this->db->query("select word, id from hw6_words 
    where length = 7 and not exists(select * from hw6_userwords where user_id = $1 and word_id = hw6_words.id)
    order by random() limit 1;", $userid);
    $this->db->query("insert into hw6_userwords (user_id, word_id) values ($1, $2);", $userid, $results[0]["id"]);
    $_SESSION["word"] = $results[0]["word"];
    $_SESSION["guesses"] = [];
    $_SESSION["invalid"] = 0;
    $_SESSION["score"] = 0;
    $letters = str_split($results[0]["word"]);
    shuffle($letters);
    $_SESSION["letters"] = $letters;
    header("Location: ?command=question");
    return;
  }



  /**
   * Logout function.  We **need** to clear the session somehow.
   * When the user wants to start over, we should allow them to
   * reset the game.  I'll call it logout, so this function destroys
   * the session and immediately starts a new one.
   */
  public function logout() {
    // Destroy the session
    session_destroy();
    session_start();
  }

  /**
   * Retrieve users from the database and match them to the search string
   * Parameters: $_POST["search"]
   * Returns: JSON array of users that match the search string
   */
  public function user_search() {
    $search = $_POST["search"];
    $results = $this->db->query("select * from sprint3_users where name like $1;", "%$search%");
    echo json_encode($results);
  }

  /**
   * Show the welcome page
   * Parameters: $message (optional)
   * Returns: HTML for the welcome page 
   * ^ converting to php, but setting up general structure
   */
  public function showWelcome($message = "") {
    include_once("html/index.html");
  }
}