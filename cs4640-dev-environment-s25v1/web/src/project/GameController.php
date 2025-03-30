
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
      case "game":
        $this->showGame();
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

  public function showWelcome($message = "") {
    
  }

  public function showGame($message = ""){
    
  }

  public function showFreinds($message = ""){
    
  }

  public function showCreation($message = ""){
    
  }

  public function showInventory(){
    
  }

  public function showSettings(){
    
  }

  public function logout(){
    
  }

  public function createCharater(){
    
  }

  public function equip(){
    
  }

  public function attack(){
    
  }

  public function heal(){
    
  }

  public function addFriend(){
    
  }

  public function searchFriend(){
    
  }

  public function acceptFreind(){
    
  }

}
