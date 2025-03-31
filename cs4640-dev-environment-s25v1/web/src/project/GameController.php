
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
      case "signup":
        $this->signup();
        break;
      case "forest":
        $this->forest();
        break;
      case "plains":
        $this->plains();
        break;
      case "mountains":
        $this->mountains();
        break;
      case "boss":
        $this->boss();
        break;
      case "friends":
        $this->showFriends();
        break;
      case "inventory":
        $this->showInventory();
        break;
      case "equip":
        $this->equip();
        break;
      case "settings":
        $this->showSettings();
        break;
      case "creation":
        $this->showCreation();
        break;
      case "create":
        $this->createCharater();
        break;
      case "heal":
        $this->heal();
        break;
      case "attack":
        $this->attack();
        break;
      case "addF":
        $this->addFriend();
        break;
      case "searchF":
        $this->searchFriend();
        break;
      case "acceptF":
        $this->acceptFriend();
        break;
      case "home":
        $this->showHome();
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
    if (isset($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
      // TODO: check that email looks right!
      $results = $this->db->query("select * from sprint3_users where email = $1;", $_POST["email"]);

      if (empty($results)) {
        // create the user account
        $message = "<p class='alert alert-danger'>Sign up to create an account</p>"; 
      } else {
        // check that the user's password is correct
        $hashed_password = $results[0]["password"];
        $correct = password_verify($_POST["password"], $hashed_password);
        if ($correct) {
          // Success!
          $_SESSION["user_id"] = $results[0]["id"];
          $_SESSION["name"] = $results[0]["username"];
          $_SESSION["email"] = $_POST["email"];
          // call showQuestion OR ...
          // redirect with a header to the question screen
          if (isset($_COOKIE["charater_ids"]) && !empty($_COOKIE["charater_ids"])){
            for ($x = 0; $x < count($_COOKIE["charater_ids"]); $x++) {
              $this->db->query("update sprint3_characters set user_id = $1 where charater_id = $2;", $_SESSION["user_id"], $_COOKIE["charater_ids"][$x]);
            }
            unset($_COOKIE["charater_id"]);
          }
          header("Location: ?command=home");
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
        if (isset($_COOKIE["charater_ids"]) && !empty($_COOKIE["charater_ids"])){
            for ($x = 0; $x < count($_COOKIE["charater_ids"]); $x++) {
              $this->db->query("update sprint3_characters set user_id = $1 where charater_id = $2;", $_SESSION["user_id"], $_COOKIE["charater_ids"][$x]);
            }
            unset($_COOKIE["charater_id"]);
            header("Location: ?command=home");
            return;
        }
        else{
        header("Location: ?command=creation");
        return;
        }
      }
    }
    include_once("templates/sign-up.php");

    return;
  }    

  public function showWelcome($message = "") {
      include_once("templates/home.php");
      return;
  }

    public function showHome($message = "") {
      $characters = $this->db->query("select name, id from sprint3_characters where user_id = $1;", $_SESSION["user_id"]);
      $character_ids = [];
      $character_names = [];
      for ($x = 0; $x <= count($characters); $x++) {
        $character_ids[] = $characters[$x]["id"];
        $character_names[] = $characters[$x]["name"];
      }
      include_once("templates/home_logged_in.php")
      return;
  }

  public function forest(){
    $_SESSION["moster_hp"] = 5;
    $_SESSION["moster_atk"] = 2;
    $_SESSION["moster_def"] = 1;
    header("Location: ?command=game");
    return;
  }

  public function plains(){
    $_SESSION["moster_hp"] = 20;
    $_SESSION["moster_atk"] = 2;
    $_SESSION["moster_def"] = 1;
    header("Location: ?command=game");
    return;
  }

  public function mountians(){
    $_SESSION["moster_hp"] = 50;
    $_SESSION["moster_atk"] = 2;
    $_SESSION["moster_def"] = 1;
    header("Location: ?command=game");
    return;
  }
  
  public function boss(){
    $_SESSION["moster_hp"] = 100;
    $_SESSION["moster_atk"] = 2;
    $_SESSION["moster_def"] = 1;
    header("Location: ?command=game");
    return;
  }

  public function showGame($message = ""){
    if (isset($_POST) && isset($_POST["character_id"]) && !empty($_POST["character_id"])){
      $_SESSION["character_id"] = $_POST["character_id"];
    }
    if (isset($_POST) && isset($_POST["location"]) && !empty($_POST["location"])){
      $location = $_POST["location"];
      $_SESSION["location"] = $_POST["location"];
    }
    elseif(isset($_SESSION["location"]) && !empty($_SESSION["location"])){
      $location = $_SESSION["location"];
    }
    else{
      $_SESSION["location"] = "main";
      $location = "main";
    }
    
    $results = $this->db->query("select * from sprint3_characters where character_id = $1;", $_SESSION["character_id"]);
    $character_name = $results[0]["name"];
    $exp = $results[0]["exp"];
    $atk = $results[0]["atk"];
    $def = $results[0]["def"];
    if(isset($_SESSION["hp"]) && !empty($_SESSION["hp"])){
      $hp = $_SESSION["hp"];
    }
    else{
      $hp = $results[0]["hp"];
    }
    if($_SESSION["location"] === "plains" || $_SESSION["location"] === "forest" || $_SESSION["location"] === "mountians" || $_SESSION["location"] === "boss" ){
      $monster_hp = $_SESSION["monster_hp"];
      $monster_atk = $_SESSION["monster_atk"];
      $monster_def = $_SESSION["monster_def"];
    }
    $max_hp = $results[0]["hp"];
    $stat_points = $results[0]["stat_points"];
    $quest_id = $results[0]["quest_id"];
    $hat_id = $results[0]["hat_id"];
    $shirt_id = $results[0]["shirt_id"];
    $pants_id = $results[0]["pants_id"];
    $shoes_id = $results[0]["shoes_id"];
    include_once("templates/game.php");
    return;
  }

  public function showFreinds($message = ""){
    include_once("templates/friends.php");
    return;
  }

  public function showCreation($message = ""){
    include_once("templates/character_creation.php");
    return;
  }

  public function showInventory(){
    $items = $this->db->query("select * from sprint3_character_items where character_id = $1;", $_SESSION["character_id"]);
    include_once("templates/inventory.php");
    return;
  }

  public function showSettings(){
    include_once("templates/settings.php");
    return;
  }

  public function logout(){
    session_destroy();
    session_start();
  }

  public function createCharater(){
    // Form validation
    $results = $this->db->query("select * from sprint3_characters where name = $1;", $_POST["name"]);
    if (!empty($results)) {
      $this->showCreation("Character name already exists. Please choose a different name.");
      return;
    }
    elseif (!isset($_POST["name"]) || $_POST["name"] == null || $_POST["name"] == "") {
      $this->showCreation("Please enter a character name.");
      return;
    }

    // Storing the character in the database
    if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null && $this->isNumeric($_SESSION["user_id"])) {
      $results = $this->db->query("insert into sprint3_characters (user_id, name, exp, atk, def, hp, monsters_killed, quest_id, hat_id, shirt_id, pant_id, shoes_id) values (null, $1, 0, 0, 0, 0, 0, 0, $2, $3, $4, $5);",
        $_POST["name"],
        $_POST["hat_id"],
        $_POST["shirt_id"],
        $_POST["pant_id"],
        $_POST["shoe_id"]);
        if(isset($_COOKIE["charater_ids"]) && !empty($_COOKIE["charater_ids"])){
          $_COOKIE["character_ids"][] = $this->db->getLastInsertId("sprint3_characters_seq");
          setcookie(“character_ids”, $_COOKIE["character_ids"], time() + 604800);
        }
        else{
          setcookie(“character_ids”, [$this->db->getLastInsertId("sprint3_characters_seq")], time() + 604800);
        }
    }
    else {
      $results = $this->db->query("insert into sprint3_characters (user_id, name, exp, atk, def, hp, stat_points, monsters_killed, quest_id, hat_id, shirt_id, pant_id, shoes_id) values ($1, $2, 0, 0, 0, 0, 0, 0, 0, $3, $4, $5, $6);",
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

  public function equip(){
    
  }

  public function attack(){
    
  }

  public function heal(){
    $results = $this->db->query("select hp from sprint3_characters where id = $1;", $_SESSION["character_id"]);
    $_SESSION["health"] = $results[0]["hp"];
    header("Location: ?command=game");
    return;
  }

  public function addFriend(){
    
  }

  // Endpoint: ?command=searchF&name=some_name
  public function searchFriend(){
    if (!isset($_GET["name"])) {
      echo json_encode([]); // figuring out how to return a JSON response
      return;
    }
    $search = $_GET["name"];
    $results = $this->db->query("select * from sprint3_users where username like $1;", "%$search%");
    echo json_encode($results);
    return;
  }

  public function acceptFreind(){
    
  }

  public function isNumeric($var) {
    return preg_match("/^[0-9]+$/", $var);
  }    
}
