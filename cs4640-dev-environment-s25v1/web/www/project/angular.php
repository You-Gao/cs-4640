<?php

$words_array = file("/opt/src/angularwords.txt");
$word = $words_array[array_rand($words_array)];
$word = trim($word);
$json = [
    "word" => $word,
];

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($json);

?>