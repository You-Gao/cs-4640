<?php
session_start();

function dispatchCommand($command=None){
    switch ($command) {
        case 'welcome':
            if (!empty($_POST)) {
                if (isset($_POST["name"])){
                    $_SESSION["name"] = $_POST["name"];
                }
                if (isset($_POST["user_name"])){
                    $_SESSION["user_name"] = $_POST["user_name"];
                }
                if (isset($_POST["email"])) {
                    $_SESSION["email"] = $_POST["email"];
                }
            }
            getWelcomePage();
            break;
        case 'game':
            getGamePage();
            break;
        case 'game_over':
            # code...
            break;
        case 'default':
            if (!empty($_SESSION)){
                $_SESSION["letters"] = array("A","B","C","D","E","F","G");
                getGamePage();
            }
            else {
                getWelcomePage();
            }
            break;
    }
}

function getWelcomePage() {
    include 'hw5/welcome.php';
}

function getGamePage() {
    include 'hw5/game.php';
}

$command = isset($_GET["command"]) ? $_GET["command"] : "default";
echo "<p>$command</p>";


$post = !empty($_POST) ? $_POST : NULL;
echo "<p>post vars</p>";
var_dump($post);

echo "<p>session vars</p>";
var_dump($_SESSION);

dispatchCommand($command);




?>
