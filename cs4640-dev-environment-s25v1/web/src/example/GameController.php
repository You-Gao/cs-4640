
<?php

class GameController {

  private $db;
  private $input;
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
    var_dump($this->input);
    $command = "welcome";
    if (isset($this->input["command"])){
      $command = $this->input["command"];
    }     

    switch($command) {
      case "login": 
        $this->login();
        break;
      case "signup":
        $this->signup();
        break;
      case "character_creation":
        $this->showCharacter();
        break;
      case "make_character":
        $this->makeCharacter();
        break;
      case "user_search":
        $this->getUserSearch();
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
   * Parameters: $_GET["name"] (string)
   * Returns: JSON array of users that match the search string
   * ^ figure out how to send as a JSON response instead of HTML
   */
  public function getUserSearch() {
    if (!isset($_GET["name"])) {
      echo json_encode([]);
      return;
    }
    $search = $_GET["name"];
    $results = $this->db->query("select * from sprint3_users where username like $1;", "%$search%");
    echo json_encode($results);
    return;
  }

  /**
   * Use Regex to check if variable is numeric
   * Parameters: $var (string)
   */
  public function isNumeric($var) {
    return preg_match("/^[0-9]+$/", $var);
  }


  /**
   * Show the character page
   */
  public function showCharacter($message = "") {
    include_once("html/character_creation.php");
    return;
  }

  /**
   * Make a new character and redirect to the game page
   * Parameters: $_POST["name"], $_POST["hat_id"], $_POST["shirt_id"], $_POST["pant_id"], $_POST["shoes_id"]
   * Returns: Redirect to the game page
   */
  public function makeCharacter() {

    // Form validation
    $results = $this->db->query("select * from sprint3_characters where name = $1;", $_POST["name"]);
    if (!empty($results)) {
      $this->showCharacter("Character name already exists. Please choose a different name.");
      return;
    }
    elseif (!isset($_POST["name"]) || $_POST["name"] == null || $_POST["name"] == "") {
      $this->showCharacter("Please enter a character name.");
      return;
    }

    // Storring the character in the database
    if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null && $this->isNumeric($_SESSION["user_id"])) {
      $results = $this->db->query("insert into sprint3_characters (user_id, name, exp, atk, def, hp, monsters_killed, quest_id, hat_id, shirt_id, pant_id, shoes_id) values (null, $1, 0, 0, 0, 0, 0, 0, $2, $3, $4, $5);",
        $_POST["name"],
        $_POST["hat_id"],
        $_POST["shirt_id"],
        $_POST["pant_id"],
        $_POST["shoe_id"]);
    }
    else {
      $results = $this->db->query("insert into sprint3_characters (user_id, name, exp, atk, def, hp, monsters_killed, quest_id, hat_id, shirt_id, pant_id, shoes_id) values ($1, $2, 0, 0, 0, 0, 0, 0, $3, $4, $5, $6);",
        $_SESSION["user_id"],
        $_POST["name"],
        $_POST["hat_id"],
        $_POST["shirt_id"],
        $_POST["pant_id"],
        $_POST["shoe_id"]);
    }
    $_SESSION["character_id"] = $this->db->getLastInsertId("sprint3_characters_seq");

    header("Location: ?command=game");
    return;
  }

  /**
   * Show the signup page
   * Parameters: $message (optional), $_POST["name"], $_POST["password"], $_POST["email"]
   * Returns: HTML for the signup page or redirect to the welcome page
   */
  public function signup($message = "") {

    // Form validation
    if (isset($_POST) && !empty($_POST["name"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
      $email = $this->db->query("select * from sprint3_users where email = $1;", $_POST["email"]);
      $name = $this->db->query("select * from sprint3_users where username = $1;", $_POST["name"]);
      if (!empty($email)) {
        $message = "Email already exists. Please choose a different email.";
      } elseif (!empty($name)) {
        $message = "Name already exists. Please choose a different name.";
      } else {
        $result = $this->db->query("insert into sprint3_users (username, email, password) values ($1, $2, $3);",
          $_POST["name"],
          $_POST["email"],
          password_hash($_POST["password"], PASSWORD_DEFAULT));
        $_SESSION["user_id"] = $this->db->getLastInsertId("sprint3_users_seq");
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["email"] = $_POST["email"];
        header("Location: ?command=welcome");
        return;
      }
    }
    include_once("html/sign-up.php");

    return;
  }

  /**
   * Show the welcome page
   * Parameters: $message (optional)
   * Returns: HTML for the welcome page 
   * ^ converting to php, but setting up general structure
   */
  public function showWelcome($message = "") {
    include_once("html/index.html");
    return;
  }
}