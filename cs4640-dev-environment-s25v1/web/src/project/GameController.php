
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
    if (isset($this->input["command"]))
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
      case "allocate_stats":
        $this->allocate_stats();
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
              $this->db->query("update sprint3_characters set user_id = $1 where id = $2;", $_SESSION["user_id"], $_COOKIE["charater_ids"][$x]);
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
    include_once("templates/sign_up.php");

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
      include_once("templates/home_logged_in.php");
      return;
  }

  public function forest(){
    $_SESSION["moster_hp"] = 5;
    $_SESSION["moster_atk"] = 2;
    $_SESSION["moster_def"] = 1;
    $_SESSION["monster_exp"] = 2;
    $_SESSION["moster_name"] = "Tree";
    unset($_SESSION["damage_dealt"]);
    unset($_SESSION["damage_taken"]);
    header("Location: ?command=game");
    return;
  }

  public function plains(){
    $_SESSION["moster_hp"] = 20;
    $_SESSION["moster_atk"] = 2;
    $_SESSION["moster_def"] = 1;
    $_SESSION["monster_exp"] = 10;
    $_SESSION["moster_name"] = "Ox";
    unset($_SESSION["damage_dealt"]);
    unset($_SESSION["damage_taken"]);
    header("Location: ?command=game");
    return;
  }

  public function mountians(){
    $_SESSION["moster_hp"] = 50;
    $_SESSION["moster_atk"] = 2;
    $_SESSION["moster_def"] = 1;
    $_SESSION["monster_exp"] = 100;
    $_SESSION["moster_name"] = "Big Rock";
    unset($_SESSION["damage_dealt"]);
    unset($_SESSION["damage_taken"]);
    header("Location: ?command=game");
    return;
  }
  
  public function boss(){
    $_SESSION["moster_hp"] = 100;
    $_SESSION["moster_atk"] = 2;
    $_SESSION["moster_def"] = 1;
    $_SESSION["moster_name"] = "Boss";
    $_SESSION["monster_exp"] = 1000;
    unset($_SESSION["damage_dealt"]);
    unset($_SESSION["damage_taken"]);
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
    
    $results = $this->db->query("select * from sprint3_characters where id = $1;", $_SESSION["character_id"]);
    $items = $this->db->query("select * from sprint3_items where id = (select item_id from sprint3_character_items where char_id = $1 and equiped = 1);", $_SESSION["character_id"]);
    $character_name = $results[0]["name"];
    $exp = $results[0]["exp"];
    $atk = $results[0]["atk"];
    $def = $results[0]["def"];
    $max_hp = $results[0]["hp"];
    for ($x = 0; $x < count($items); $x++) {
      $max_hp += $items[$x]["hp"];
      $atk += $items[$x]["atk"];
      $def += $items[$x]["def"];
    }
    if(isset($_SESSION["hp"]) && !empty($_SESSION["hp"])){
      $hp = $_SESSION["hp"];
    }
    else{
      $hp = $results[0]["hp"];
      for ($x = 0; $x < count($items); $x++) {
        $hp += $items[$x]["hp"];
      }
    }
    if(isset($_SESSION["damage_dealt"]) && !empty($_SESSION["damage_dealt"])){
      $damage_dealt = $_SESSION["damage_dealt"]; 
    }
    if(isset($_SESSION["damage_taken"]) && !empty($_SESSION["damage_taken"])){
      $damage_dealt = $_SESSION["damage_taken"]; 
    }
    if($_SESSION["location"] === "plains" || $_SESSION["location"] === "forest" || $_SESSION["location"] === "mountians" || $_SESSION["location"] === "boss" ){
      $monster_hp = $_SESSION["monster_hp"];
      $monster_atk = $_SESSION["monster_atk"];
      $monster_def = $_SESSION["monster_def"];
      $monster_name = $_SESSION["monster_name"];
    }
    elseif($_SESSION["location"] === "won"){
      $monster_name = $_SESSION["monster_name"];
      $recived_items = $_SESSION["recived"];
      $exp_gain = $_SESSION["exp_gain"];
      $levelup = $_SESSION["level_up"];
    }
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
    $items = $this->db->query("select * from sprint3_items where id = (select item_id from sprint3_character_items where char_id = $1);", $_SESSION["character_id"]);
    $item_info = $this->db->query("select * from sprint3_character_items where char_id = $1;", $_SESSION["character_id"]);
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
      $results = $this->db->query("insert into sprint3_characters (user_id, name, exp, atk, def, hp, stat_points, monsters_killed, quest_id, hat_id, shirt_id, pant_id, shoes_id) values (null, $1, 0, 0, 0, 0, 0, 0, 0, $2, $3, $4, $5);",
        $_POST["name"],
        $_POST["hat_id"],
        $_POST["shirt_id"],
        $_POST["pant_id"],
        $_POST["shoe_id"]);

        echo json_encode($results);
      
        if(isset($_COOKIE["character_ids"]) && !empty($_COOKIE["character_ids"])){
          $existing_ids = json_decode($_COOKIE["character_ids"], true);
          $existing_ids[] = $this->db->getLastInsertId("sprint3_characters_seq");
          setcookie("character_ids", json_encode($existing_ids), time() + 604800);
        }
        else{
          $character_ids = [$this->db->getLastInsertId("sprint3_characters_seq")];
          var_dump($character_ids);
          setcookie("character_ids", json_encode($character_ids), time() + 604800);
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

    return;
  }

  public function equip(){
    if(isset($_POST) && isset($_POST["item_id"]) && !empty($_POST["item_id"])){
      $equiped =  $this->db->query("select equiped from sprint3_character_items where item_id = $1 and char_id = $2;", $_POST["item_id"], $_SESSION["character_id"]);
      if ($equiped == 1){
        $this->db->query("update sprint3_character_items set equiped = 0 where item_id = $1 and char_id = $2;", $_POST["item_id"], $_SESSION["character_id"]);
      }
      else{
        $item = $this->db->query("select * from sprint3_items where id = $1;", $_POST["item_id"]);
        $this->db->query("update sprint3_character_items set equiped = 1 where item_id = $1 and char_id = $2;", $_POST["item_id"], $_SESSION["character_id"]);
        $results = $this->db->query("select item_id from sprint3_character_items where item_id = $1 and sprint3_items.type = $2;", $_POST["item_id"], $item[0]["type"]);
        if(!empty($results)){
          $this->db->query("update sprint3_character_items set equiped = 0 where item_id = $1 and char_id = $2;", $results[0]["id"], $_SESSION["character_id"]);
          //make sure hp does not become more then max
          $items = $this->db->query("select * from sprint3_items where id = (select item_id from sprint3_character_items where char_id = $1 and equiped = 1);", $_SESSION["character_id"]);
          $results = $this->db->query("select hp from sprint3_characters where id = $1;", $_SESSION["character_id"]);
          $hp = $results[0]["hp"];
          for ($x = 0; $x < count($items); $x++) {
              $hp += $items[$x]["hp"];
          }
          if($_SESSION["hp"] > $hp){
            $_SESSION["hp"] = $hp;
          }
        }
      }
    }
    header("Location: ?command=inventory");
    return;
  }

  public function attack(){
    $results = $this->db->query("select * from sprint3_characters where id = $1;", $_SESSION["character_id"]);
    $items = $this->db->query("select * from sprint3_items where id = (select item_id from sprint3_character_items where char_id = $1 and equiped = 1);", $_SESSION["character_id"]);
    $exp = $results[0]["exp"];
    $atk = $results[0]["atk"];
    $def = $results[0]["def"];
    $stat_points == $results[0]["stat_points"];
    for ($x = 0; $x < count($items); $x++) {
      $atk += $items[$x]["atk"];
      $def += $items[$x]["def"];
    }
    $_SESSION["damage_dealt"] = max(0,$atk-$_SESSION["monster_def"]);
    $_SESSION["damage_taken"] = max(0,$_SESSION["monster_atk"]-$def);
    $_SESSION["monster_hp"] -= $_SESSION["damage_dealt"];
    if($_SESSION["monster_hp"] <= 0){
      $_SESSION["location"] = "won";
      //give items and experience
      $_SESSION["exp_gain"] = $_SESSION["monster_exp"];
      $levelpoints = array(10,30,75,180,400,1000,1000000000000);
      $start = count($levelpoints);
      $end = 0;
      for ($x = 0; $x < count($levelpoints); $x++) {
        if($exp <= $levelpoints[$x]){
          $end = $x;
        }
        if($exp + $_SESSION["exp_gain"] <= $levelpoints[$x]){
          $start = $x;
        }
      }
      $_SESSION["level_up"] = $start - $end;
      if($_SESSION["level_up"] > 0){
        $this->db->query("update sprint3_character set stat_points = $1 where id = $2;", $stat_points+$_SESSION["level_up"], $_SESSION["character_id"]);
      }
      if($_SESSION["monster_name"] === "Tree"){
        $item_id = rand(0,4);        
      }
      else{//add item set for each monster later
        $item_id = rand(0,4);  
      }
      $_SESSION["recived"] = $this->db->query("select * from sprint3_items where id = $1;", $item_id);
      $results = $this->db->query("select item_count from sprint3_charcter_items where char_id = $1 and item_id = $2;", $_SESSION["character_id"], $item_id);
      if(empty($results)){
        $this->db->query("insert into sprint3_charcter_items (char_id, item_id, item_count, equiped) values ($1, $2, 1, 0);", $_SESSION["character_id"], $item_id);
      }
      else{
        $this->db->query("update sprint3_charcter_items set item_count = $1 where char_id = $2 and item_id = $3;", results[0]["item_count"] + 1, $_SESSION["character_id"], $item_id);
      }
      header("Location: ?command=game");
      return;
    }
    $_SESSION["hp"] -= $_SESSION["damage_taken"];
    if($_SESSION["hp"] <= 0){
      $_SESSION["location"] = "town";
      $this->heal();
    }
    header("Location: ?command=game");
    return;
  }

  public function allocate_stats(){
    if(isset($_POST) && isset($_POST["stat"]) && !empty($_POST["stat"])){
      $results = $this->db->query("select stat_points, hp, def, atk from sprint3_characters where id = $1;", $_SESSION["character_id"]);
      if(results[0]["stat_points"] > 0){
        switch($_POST["stat"]) {
          case "hp":
            $this->db->query("update sprint3_characters set stat_points = $1, hp = $2  where id = $3;", results[0]["stat_points"]-1, results[0]["hp"]+5, $_SESSION["character_id"]);
            $_SESSION["hp"] += 5;
            break;
          case "def":
            $this->db->query("update sprint3_characters set stat_points = $1, def = $2  where id = $3;", results[0]["stat_points"]-1, results[0]["def"]+1, $_SESSION["character_id"]);
            break;
          case "atk":
            $this->db->query("update sprint3_characters set stat_points = $1, atk = $2  where id = $3;", results[0]["stat_points"]-1, results[0]["atk"]+3, $_SESSION["character_id"]);
            break;
        }
      }
    }
    header("Location: ?command=game");
    return;
    
  }

  public function heal(){
    $items = $this->db->query("select * from sprint3_items where id = (select item_id from sprint3_character_items where char_id = $1 and equiped = 1);", $_SESSION["character_id"]);
    $results = $this->db->query("select hp from sprint3_characters where id = $1;", $_SESSION["character_id"]);
    $_SESSION["hp"] = $results[0]["hp"];
    for ($x = 0; $x < count($items); $x++) {
         $_SESSION["hp"] += $items[$x]["hp"];
    }
    header("Location: ?command=game");
    return;
  }

  public function addFriend(){
    
  }

  // Endpoint: ?command=searchF&name=some_name
  public function searchFriend(){
    header("Content-Type: application/json");
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
