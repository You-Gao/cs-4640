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

<h2>Problem 2</h2>
<?php
    // Test cases for gridCorners function
    $result = gridCorners(3, 3);
    assert($result == "1, 2, 3, 4, 6, 7, 8, 9", "Test 1 Failed");

    $result = gridCorners(2, 2);
    assert($result == "1, 2, 3, 4", "Test 2 Failed");

    $result = gridCorners(3, 4);
    assert($result == "1, 2, 3, 4, 5, 8, 9, 10, 11, 12", "Test 3 Failed");

    $result = gridCorners(1, 1);
    assert($result == "1", "Test 4 Failed");

    $result = gridCorners(1, 2);
    assert($result == "1, 2", "Test 5 Failed");

    $result = gridCorners(2, 1);
    assert($result == "1, 2", "Test 6 Failed");

    $result = gridCorners(1, 5);
    assert($result == "1, 2, 3, 4, 5", "Test 7 Failed");

    $result = gridCorners(1, 9);
    assert($result == "1, 2, 3, 4, 5, 6, 7, 8, 9", "Test 8 Failed");

    // large grids
    $result = gridCorners(7,7);
    echo $result;
  

    echo "All tests passed for gridCorners function!";
?>

<p>...</p>
</body>
</html>