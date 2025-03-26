<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$word_bank_path = '/opt/src/word_bank.json';
$words7_path = '/opt/src/words7.txt';
$high_scores_path = '/opt/src/high_scores.json';

// $word_bank_path = '/var/www/html/homework/word_bank.json';
// $words7_path = '/var/www/html/homework/words7.txt';
// $high_scores_path = '/djx3rn/hw5/high_scores.json';

/*
some quick documentation

variables used in $_SESSION
    letters: array of letters
    guesses: array of guesses
    words_remaining: number of words remaining
    word: the word to guess
    name: name of player
    user_name: display name of player
    email: email of player
    score: score of player
*/
class Config {
    public static $db = [
        "host" => "db",
        "port" => 5432,
        "user" => "localuser",
        "pass" => "cs4640LocalUser!",
        "database" => "example"
    ];
}

class Database {
    private $dbConnector;

    /**
     * Constructor
     *
     * Connects to PostgresSQL
     */
    public function __construct() {
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["pass"];
        $port = Config::$db["port"];

        $this->dbConnector = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");
    }

    /**
     * Query
     *
     * Makes a query to posgres and returns an array of the results.
     * The query must include placeholders for each of the additional
     * parameters provided.
     */
    public function query($query, ...$params) {
        $res = pg_query_params($this->dbConnector, $query, $params);

        if ($res === false) {
            echo pg_last_error($this->dbConnector);
            return false;
        }

        return pg_fetch_all($res);
    }
//  if (isset($_POST["name"])) {
//                 $_SESSION["name"] = $_POST["name"];
//             }
//             if (isset($_POST["user_name"])) {
//                 $_SESSION["user_name"] = $_POST["user_name"];
//             }
//             if (isset($_POST["email"])) {
//                 $_SESSION["email"] = $_POST["email"];
//             }
//             if (isset($_POST["password"])) {
//                 $_SESSION["password"] = $_POST["password"];
//             }

    public function checkUser($email) {
        $query = "SELECT * FROM users WHERE email = $1";
        $res = $this->query($query, $email);
        return count($res) > 0;
    }

    public function checkPassword($email, $password) {
        $query = "SELECT password FROM users WHERE email = $1";
        $res = $this->query($query, $email);
        return password_verify($password, $res[0]["password"]);
    }

    public function getUserID($email) {
        $query = "SELECT id FROM users WHERE email = $1";
        $res = $this->query($query, $email);
        return $res[0]["id"];
    }

    public function storeUserWords($user_id, $word) {
        $query = "INSERT INTO userwords (user_id, word_id) VALUES ($1, $2)";
        $res = $this->query($query, $user_id, $word);
    }

    public function createUser($name, $user_name, $email, $password) {
        $query = "INSERT INTO users (name, email, password, display, score) VALUES ($1, $2, $3, $4, $5)";
        $res = $this->query($query, $name, $email, $this->hashPassword($password), $user_name, 0);
    }

    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

class AnagramsGameController {

    private $db;

    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Database(new Config());
    }


    public function dispatchCommand($command = null) {
        // var_dump($_SESSION);
        if (empty($_SESSION)){
            $this->handleWelcome();
            return;
        }
        switch ($command) {
            case 'welcome':
                $this->handleWelcome();
                break;
            case 'game':
                $this->handleGame();
                break;
            case 'game_over':
                $this->handleGameOver();
                break;
            case 'default':
            default:
                $this->handleDefault();
                break;
        }
    }

    private function storeUserSession() {
        if (isset($_POST["name"])) {
            $_SESSION["name"] = $_POST["name"];
        }
        if (isset($_POST["user_name"])) {
            $_SESSION["user_name"] = $_POST["user_name"];
        }
        if (isset($_POST["email"])) {
            $_SESSION["email"] = $_POST["email"];
        }
    }

    private function handleWelcome() {
        if (!empty($_POST) && isset($_POST["name"]) && isset($_POST["user_name"]) && isset($_POST["email"]) && isset($_POST["password"])) {
            if ($this->db->checkUser($_POST["email"])) {
                if ($this->db->checkPassword($_POST["email"], $_POST["password"])) {
                    $_SESSION["user_id"] = $this->db->getUserID($_POST["email"]);
                    $this->storeUserSession();
                    $this->setupGame();
                    $this->getGamePage();
                }
                else {
                    $this->getWelcomePage("incorrect password");
                }
                return;
            }
            $this->db->createUser($_POST["name"], $_POST["user_name"], $_POST["email"], $_POST["password"]);
            $this->storeUserSession();
            $_SESSION["user_id"] = $this->db->getUserID($_POST["email"]);
            $this->setupGame();
            $this->getGamePage();
            return;
        }
        $this->getWelcomePage();
    }

    private function handleDefault() {
        if (isset($_POST["logout"])) {
            $this->saveScores();
            session_unset();
            session_destroy();
        }
        if (isset($_SESSION["letters"])) {
            $this->getGamePage();
        } else {
            $this->getWelcomePage();
        }
    }

    private function handleGame() {
        // var_dump($_POST);
        if (!empty($_POST)) {
            if (isset($_POST["play_again"])) {
                $this->setupNewGame();
                $this->getGamePage();
                return;
            }

            if (isset($_POST["shuffle"])) {
                $this->shuffleWord();
                $this->getGamePage();
                return;
            }
            if ((isset($_POST["guess"]) && !is_null($_POST["guess"]))) {
                // var_dump($_POST);
                $guess = $_POST["guess"];
                if ($guess === ''){
                    $this->getGamePage();
                    return;
                }
                // echo $guess;
                if ($guess === $_SESSION["word"]) {
                    $this->saveScores();
                    $this->getGameOverPage();
                    return;
                }
                if ($this->checkGuess($guess)) {
                    $this->getGamePage(TRUE);
                    return;
                }
                else {
                    $message = "already guessed!";
                    if (((strlen($_POST["guess"] === 7) &&  !($guess === $_SESSION["word"])))){
                        $message = "try a better 7 letter";
                        return $this->getGamePage(FALSE, $message);
                    }
                    if (!($this->checkGuessInWord($guess))) {
                        $message = "letter not in guess";
                        return $this->getGamePage(FALSE, $message);
                    }
                    // echo "guess: $guess";
                    if (!($this->CheckGuessInBank($guess))) {
                        $message = "letter not in bank";
                        return $this->getGamePage(FALSE, $message);
                    }
                    // check if the guess is already made
                    $this->getGamePage(FALSE, $message);
                    return;
                }
            }
        }
        // this line is actually never reached
        $this->getGamePage();
    }

    private function saveScores(){
        // if unset return, which occurs when the user gives up and gets sent to log-out
        if (!isset($_SESSION["score_id"])) {
            return;
        }
        $this->db->query("INSERT INTO userstats (user_id, stat_id, word_id) VALUES ($1, $2, $3)", $_SESSION["user_id"], $_SESSION["score_id"], $_SESSION["word_id"]);
    }

    private function handleGameOver() {
        if (isset($_POST["give_up"])) {
            $this->saveScores();
        }

        $query = "SELECT * FROM userstats LEFT JOIN stats ON userstats.stat_id = stats.id LEFT JOIN word ON userstats.word_id = word.id WHERE userstats.user_id = $1";
        $all_games = $this->db->query($query, $_SESSION["user_id"]);
        $this->getGameOverPage($all_games);
    }

    private function getWelcomePage($alert = NULL) {
        include 'hw5/welcome.php';
    }

    private function getGamePage($correct_guess = NULL, $alert = NULL) {
        include 'hw5/game.php';
    }

    private function getGameOverPage($games = NULL) {
        include 'hw5/gameover.php';
    }

    private function shuffleWord() {
        $letters = $_SESSION["letters"];
        shuffle($letters);
        $_SESSION["letters"] = $letters;
    }

    private function setWordsRemaining() {
        global $word_bank_path;
        $word_bank = file_get_contents($word_bank_path);
        $word_bank = json_decode($word_bank, true);
        $words_remaining = 0;
        for ($i = 1; $i < 7; $i++) {
            $word_bank_i = $word_bank[1];
            foreach ($word_bank_i as $word) {
                // echo $word;
                if ($this->checkGuessInWord($word)) {
                    $words_remaining += 1;
                }
            }
        }
        $_SESSION["words_remaining"] = $words_remaining;
        $this->db->query("UPDATE stats SET words_remaining = $1 WHERE id = $2", $words_remaining, $_SESSION["score_id"]);
    }


    private function setupGame() {
        global $words7_path;

        $this->db->query("INSERT INTO stats (score) VALUES (0)");
        // grabs the most recent score id
        $_SESSION["score_id"] = $this->db->query("SELECT id FROM stats ORDER BY id DESC LIMIT 1")[0]["id"];

        $words = file($words7_path);
        $existing_words = $this->db->query("SELECT word_id FROM userwords WHERE user_id = $1", $_SESSION["user_id"]);
        $words = array_filter($words, function ($word) use ($existing_words) {
            $word = trim($word);
            foreach ($existing_words as $existing_word) {
                if ($word === $existing_word["word_id"]) {
                    return FALSE;
                }
            }
            return TRUE;
        });
        $word = $words[array_rand($words)];
        $word = strtoupper(trim($word));
        
        $this->db->query("INSERT INTO word (word) VALUES ($1)", $word);
        $this->db->storeUserWords($_SESSION["user_id"], $this->db->query("SELECT id FROM word WHERE word = $1", $word)[0]["id"]);
        $_SESSION["word"] = strtoupper(trim($word));
        $_SESSION["word_id"] = $this->db->query("SELECT id FROM word WHERE word = $1", $word)[0]["id"];

        $word = str_shuffle($word);
        $letters = str_split($word);
        $_SESSION["letters"] = $letters;
        $_SESSION["guesses"] = isset($_SESSION["guesses"]) ? $_SESSION["guesses"] : [];
        $_SESSION["score"] = isset($_SESSION["score"]) ? $_SESSION["score"] : 0;
        $this->setWordsRemaining();
    }

    private function setupNewGame() {
        $this->setupGame();
        $_SESSION["guesses"] = [];
        $_SESSION["score"] = 0;
        $this->setWordsRemaining();
    }

    private function checkGuessInWord($guess) {
        $letters = $_SESSION["letters"];
        $guess = str_split($guess);
        $letters_copy = $letters;
        foreach ($guess as $letter) {
            $letter = strtoupper($letter);
            $key = array_search($letter, $letters_copy);
            if ($key === FALSE) {
                return FALSE;
            }
            unset($letters_copy[$key]);
        }
        return TRUE;
    }

    private function CheckGuessInBank($guess) {
        global $word_bank_path;
        $word_bank = file_get_contents($word_bank_path);
        $word_bank = json_decode($word_bank, true);
        $guess = strtolower($guess);
        $guess_len = strlen($guess);
        $word_bank = $word_bank[$guess_len];
        if (in_array($guess, $word_bank)) {
            return TRUE;
        }
        return FALSE;
    }

    private function checkGuessinGuesses($guess) {
        $guess = strtolower($guess);
        return in_array($guess, $_SESSION["guesses"]);
    }

    private function checkGuess($guess) {
        global $word_bank_path;
        global $words7_path;

        if ($guess === 'undefined') {
            return FALSE;
        }
        if ($this->checkGuessinGuesses($guess)) {
            // echo "guess already made";
            return FALSE;
        }
        if (!($this->checkGuessInWord($guess))) {
            // echo "guess not in word";
            return FALSE;
        }
        if (strlen($guess) == 7) {
            $words = file($words7_path);
            return in_array($guess, $words);
        }
        $scores_arr = [1 => 1, 2 => 2, 3 => 4, 4 => 5, 5 => 11, 6 => 11];
        $word_bank = file_get_contents($word_bank_path);
        $word_bank = json_decode($word_bank, true);
        $guess = strtolower($guess);
        // echo "guess: $guess";
        // echo "len: " . strlen($guess);
        if (in_array($guess, $word_bank[strlen($guess)])) {
            // echo "correct guess";
            $_SESSION["guesses"][] = $guess;
            $_SESSION["score"] += $scores_arr[strlen($guess)];
            $this->db->query("UPDATE stats SET score = $1 WHERE id = $2", $_SESSION["score"], $_SESSION["score_id"]);
            $_SESSION["words_remaining"] = $_SESSION["words_remaining"] - 1;
            return TRUE;
        }
        return FALSE;
    }

}

$command = isset($_GET["command"]) ? $_GET["command"] : "default";
// echo "<p>$command</p>";

$post = !empty($_POST) ? $_POST : null;
// echo "<p>post vars</p>";
// var_dump($post);

// echo "<p>session vars</p>";
// var_dump($_SESSION);

$controller = new AnagramsGameController();
$controller->dispatchCommand($command);
?>
