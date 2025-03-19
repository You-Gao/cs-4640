<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

class AnagramsGameController {
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

    private function handleWelcome() {
        if (!empty($_POST) && isset($_POST["name"]) && isset($_POST["user_name"]) && isset($_POST["email"])) {
            if (isset($_POST["name"])) {
                $_SESSION["name"] = $_POST["name"];
            }
            if (isset($_POST["user_name"])) {
                $_SESSION["user_name"] = $_POST["user_name"];
            }
            if (isset($_POST["email"])) {
                $_SESSION["email"] = $_POST["email"];
            }
            $this->setupGame();
            $this->getGamePage();
            return;
        }
        $this->getWelcomePage();
    }

    private function handleDefault() {
        if (isset($_POST["logout"])) {
            session_destroy();
        }
        if (isset($_SESSION["letters"])) {
            $this->getGamePage();
        } else {
            $this->getWelcomePage();
        }
    }

    private function handleGame() {
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
        $high_scores = json_decode(file_get_contents('/opt/src/high_scores.json'), true);
        $high_scores[] = ["name" => $_SESSION["user_name"], "score" => $_SESSION["score"], "words_remaining" => $_SESSION["words_remaining"], "word" => $_SESSION["word"]];
        usort($high_scores, function($a, $b) {
            return $b["score"] - $a["score"];
        });
        $high_scores = array_slice($high_scores, 0, 10);
        file_put_contents('/opt/src/high_scores.json', json_encode($high_scores));
    }

    private function handleGameOver() {
        if (isset($_POST["give_up"])) {
            $this->saveScores();
        }
        $this->getGameOverPage();
    }

    private function getWelcomePage() {
        include 'hw5/welcome.php';
    }

    private function getGamePage($correct_guess = NULL, $alert = NULL) {
        include 'hw5/game.php';
    }

    private function getGameOverPage() {
        include 'hw5/gameover.php';
    }

    private function shuffleWord() {
        $letters = $_SESSION["letters"];
        shuffle($letters);
        $_SESSION["letters"] = $letters;
    }

    private function setWordsRemaining() {
        $word_bank = file_get_contents('/opt/src/word_bank.json');
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
    }


    private function setupGame() {
        $words = file('/opt/src/words7.txt');
        $word = $words[array_rand($words)];
        $_SESSION["word"] = strtoupper(trim($word));
        $word = strtoupper(trim($word));
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
        $word_bank = file_get_contents('/opt/src/word_bank.json');
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
            $words = file('/opt/src/words7.txt');
            return in_array($guess, $words);
        }
        $scores_arr = [1 => 1, 2 => 2, 3 => 4, 4 => 5, 5 => 11, 6 => 11];
        $word_bank = file_get_contents('/opt/src/word_bank.json');
        $word_bank = json_decode($word_bank, true);
        $guess = strtolower($guess);
        // echo "guess: $guess";
        // echo "len: " . strlen($guess);
        if (in_array($guess, $word_bank[strlen($guess)])) {
            // echo "correct guess";
            $_SESSION["guesses"][] = $guess;
            $_SESSION["score"] += $scores_arr[strlen($guess)];
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
