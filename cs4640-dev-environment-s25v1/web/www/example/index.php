<?php
/**
 * Example full-stack application
 * CS4640 Spring 2024
 */

// Show all errors (for development)
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Autoload all classes in the src/ folder. This will
// automatically include the ExampleController and all
// other classes.
spl_autoload_register(function ($classname) {
    include "/opt/src/example/$classname.php";
});
        

// Instantiate the controller and pass in the URL (HTTP GET) parameters
$controller = new ExampleController($_GET);

$controller->run();
