<?php
    include("homework4.php");

    // Hint: include error printing!
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Homework 4 Test File</title>
</head>
<body>
<h1>Homework 4 Test File</h1>

<h2>Problem 1</h2>
<?php
    echo "Write tests for Problem 1 here\n";
    $test1 = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ] ];
    echo calculateAverage($test1, false) . "\n"; // should be 55
    echo calculateAverage($test1, true); // should be 55
    //...
    echo "\n";

    echo gridCorners(3, 3) . "\n"; // should be 1,3,7,9
    echo gridCorners(3, 4) . "\n"; // should be 1,3,7,9,13,15
    //...

    $list1 = [ "user" => "Fred", 
           "list" => ["frozen pizza", "bread", "apples", "oranges"]
         ];

    $list2 = [ "user" => "Wilma",
            "list" => ["bread", "apples", "coffee"]
            ];

    echo combineShoppingLists($list1,$list2) . "\n";


    $acronyms = "rofl lol afk";
    $searchString = "Rabbits on freezing lakes only like really old fleece leggings.";
    $acrosum = acronymSummary($acronyms, $searchString);
    echo $acrosum . "\n"; // should be "rofl lol afk"

?>

<p>...</p>
</body>
</html>
