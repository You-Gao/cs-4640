<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("/opt/src/example/Config.php");
include_once("/opt/src/example/Database.php");
include_once("/opt/src/example/GameController.php");

echo "project set-up";

$controller = new GameController($_GET);
$controller->run();

?>