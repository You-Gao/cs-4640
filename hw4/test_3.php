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

<h2>Problem 3</h2>
<?php
     $list1 = [
        "user" => "Fred",
        "list" => ["frozen pizza", "bread", "apples", "oranges"]
    ];

    $list2 = [
        "user" => "Wilma",
        "list" => ["bread", "apples", "coffee"]
    ];

    $expected = [
        "apples" => ["Fred", "Wilma"],
        "bread" => ["Fred", "Wilma"],
        "coffee" => ["Wilma"],
        "frozen pizza" => ["Fred"],
        "oranges" => ["Fred"]
    ];

    $result = combineShoppingLists($list1, $list2);
    assert($result == $expected, 'Test Case 1 Failed');

    // Additional test cases
    $list3 = [
        "user" => "Barney",
        "list" => ["milk", "bread", "eggs"]
    ];

    $list4 = [
        "user" => "Betty",
        "list" => ["bread", "milk", "butter"]
    ];

    $expected2 = [
        "bread" => ["Barney", "Betty"],
        "butter" => ["Betty"],
        "eggs" => ["Barney"],
        "milk" => ["Barney", "Betty"]
    ];

    $result2 = combineShoppingLists($list3, $list4);
    assert($result2 == $expected2, 'Test Case 2 Failed');

    $list5 = [
        "user" => "Alice",
        "list" => ["chocolate", "cookies"]
    ];

    $list6 = [
        "user" => "Bob",
        "list" => ["cookies", "ice cream"]
    ];

    $expected3 = [
        "chocolate" => ["Alice"],
        "cookies" => ["Alice", "Bob"],
        "ice cream" => ["Bob"]
    ];

    $result3 = combineShoppingLists($list5, $list6);
    assert($result3 == $expected3, 'Test Case 3 Failed');

    echo "All test cases passed!";
?>

<p>...</p>
</body>
</html>
