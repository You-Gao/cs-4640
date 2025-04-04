<?php 

$array1 = ["a", "b", "c"]; // short-hand for array()

$array2 = array(); // init array()
$array2[] = "a"; 
$array2[] = "b";
$array2[] = "c";

$array3 = array("a", "b", "c"); // long-hand for array()

$array4 = array("a" => 1, "b" => 2, "c" => 3); // associative array
$array5 = array("a" => 1, "b" => 2, "c" => 3, "d" => array("e" => 4, "f" => 5)); // nested associative array
$array5["g"] = 6; // add to associative array
$array5[42] = 7; // add to associative array with integer key
$array5[] = 8; // add to associative array with integer key

function print_array($array) {
    foreach ($array as $key => $value) { // allows you to iterate over an array with a key and value
        if (is_array($value)) {
            echo "$key: \n";
            print_array($value);
        } else {
            echo "$key: $value\n";
        }
    }
}

print_array($array1);
print_array($array2);
print_array($array3);
print_array($array4);
print_array($array5);

function iterate_array($array) {
    for ($i = 0; $i < count($array); $i++) { // iterate over an array with a for loop
        echo "$i: $array[$i]\n";
    }
    foreach ($array as $key => $value) { // iterate over an array with a foreach loop
        echo "$key: $value\n";
    }
}
iterate_array($array1);

foreach ($array1 as $value) { // iterate over an array with a foreach loop
    echo "$value\n";
}

class Example {
    public $name; // public property
    private $age; // private property

    function __construct($name, $age) { // constructor
        $this->name = $name;
        $this->age = $age;
    }

    function get_name() { // getter method
        return $this->name;
    }

    function get_age() { // getter method
        return $this->age;
    }

    function set_age($age) { // setter method
        $this->age = $age;
    }
}
$example = new Example("John", 25); // create an object of the Example class
$example->set_age(30); // set the age property
echo $example->get_name() . "\n"; // get the name property

// different ways to open a file
$filename = "example.txt";
$file = fopen($filename, "r"); // open file for reading
$contents = fread($file, filesize($filename)); // read the file
fclose($file); // close the file
$contents = file_get_contents($filename); // read the file into a string
$lines = file($filename); // read the file into an array of lines
$lines = file($filename, FILE_IGNORE_NEW_LINES); // read the file into an array of lines without newlines


session_start(); // start a session
$_SESSION["name"] = "John"; // set a session variable
if (!isset($_SESSION["name"])) { // check if a session variable is set
    echo "Session variable is not set\n";
} else {
    echo $_SESSION["name"] . "\n"; // get a session variable
}
if (!is_null($_SESSION["name"])) { // check if a session variable is not null
    echo "Session variable is not null\n";
} else {
    echo "Session variable is null\n";
}

setcookie("key", "value", time() + 3600); // set a cookie

?>