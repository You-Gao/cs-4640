
<?php

class AnagramsGameController {

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

  public function showGameover() {
    //get stats from database
    $results = $this->db->query("select max_score, total_score, average_score, games_won, games_played, win_percent
     from hw6_users where email = $1;", $_SESSION["email"]);
    if($_SESSION["score"] > $results[0]["max_score"]){
      $highscore = $_SESSION["score"];
    }
    else{
      $highscore = $results[0]["max_score"];
    }
    $totalscore = $_SESSION["score"] + $results[0]["total_score"];
    if (in_array($_SESSION["word"],$_SESSION["guesses"])){
      $won = $results[0]["games_won"] + 1;
    }
    else{
      $won = $results[0]["games_won"];
    }
    $played = $results[0]["games_played"] + 1;
    $winper = ((int)($won/$played*10000))/100;
    $avgscore = (int)($totalscore/$played+0.5);
    //update database
    $this->db->query("update hw6_users set max_score = $1, total_score = $2, average_score  = $3, 
    games_won  = $4, games_played  = $5, win_percent  = $6 where email = $7;", $highscore, $totalscore, $avgscore, 
    $won, $played, $winper, $_SESSION["email"]);

    $name = $_SESSION["name"];
    $email = $_SESSION["email"];
    $word = $_SESSION["word"];
    $score = $_SESSION["score"];
    $guesses = $_SESSION["guesses"];
    $invalid = $_SESSION["invalid"];
    include("/students/kpb8hp/students/kpb8hp/private/anagramsdb/templates/gameover.php");
  }

  public function scramble() {
    $letters = $_SESSION["letters"];
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
   * Load questions from a file, store them as an array
   * in the current object.
   */

  /**
   * Show a question to the user.  This function loads a
   * template PHP file and displays it to the user based on
   * properties of this object.
   */
  public function showQuestion($message = "") {
    $results = $this->db->query("select max_score, total_score, average_score, games_won, games_played, win_percent
    from hw6_users where email = $1;", $_SESSION["email"]);
    $highscore = $results[0]["max_score"];
    $totalscore = $results[0]["total_score"];
    $won = $results[0]["games_won"];
    $played = $results[0]["games_played"];
    $winper = $results[0]["win_percent"];
    $avgscore = $results[0]["average_score"];
    $guesses = $_SESSION["guesses"];
    $score = $_SESSION["score"]; // score variable, make the template easier to read
    $name = $_SESSION["name"]; // name variable, make the template easier to read
    $email = $_SESSION["email"];
    $letters = $_SESSION["letters"];
    include("/students/kpb8hp/students/kpb8hp/private/anagramsdb/templates/question.php");
  }
  
  public function showWelcome($message = "") {
    include("/students/kpb8hp/students/kpb8hp/private/anagramsdb/templates/welcome.php");
  }

  /**
   * Check the user's answer to a question.
   */
  public function answerQuestion() {
    $message = "";
    if (isset($_POST["answer"])) {
      $answer = strtolower(trim($_POST["answer"]));
      $answerLetters = str_split($answer);
      $results = $this->db->query("select word, length from hw6_words where word = $1;", $answer);
      if(strlen($answer) === 7){
        if((!empty($results)) && $this->letterCheck($answerLetters)){
          $_SESSION["guesses"][] = $answer;
          $_SESSION["word"] = $answer;
          header("Location: ?command=gameover");
          return;
        }
        else{
          $message = "<div class=\"alert alert-danger\" role=\"alert\">
          Invalid Word.
          </div>";
          $_SESSION["invalid"] += 1;
        }
      }
      elseif (strlen($answer) > 7 || strlen($answer) < 1){
        $message = "<div class=\"alert alert-danger\" role=\"alert\">
        Invalid Word.
        </div>";
        $_SESSION["invalid"] += 1;
      }
      else{
        if ((!empty($results)) && $this->letterCheck($answerLetters)){
          if (in_array($answer, $_SESSION["guesses"])){
            $message = "<div class=\"alert alert-danger\" role=\"alert\">
            Already guessed.
            </div>";
          }
          else{
            $_SESSION["guesses"][] = $answer;
            switch(strlen($answer)){
              case 1:
                $_SESSION["score"] += 1;
                break;
              case 2:
                $_SESSION["score"] += 2;
                break;
              case 3:
                $_SESSION["score"] += 4;
                break;
              case 4:
                $_SESSION["score"] += 8;
                break;
              case 5:
                $_SESSION["score"] += 15;
                break;
              case 6:
                $_SESSION["score"] += 30;
                break;
            }
          }
        }
        else{
          $message = "<div class=\"alert alert-danger\" role=\"alert\">
          Invalid Word.
          </div>";
          $_SESSION["invalid"] += 1;
        }
      }
    }
    $this->showQuestion($message);
  }

  function letterCheck($letters) {
    $copy = $letters;
    $correctLetters = $_SESSION["letters"];
    for ($x = 0; $x <  count($copy); $x++) {
      if (! in_array($copy[$x],$correctLetters)){
        return false;
      }
      else{
        unset($correctLetters[array_search($copy[$x],$correctLetters)]);
      }
    }
    return true;
  }
}