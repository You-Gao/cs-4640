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
    // Test 1: No scores
    $scores = [];
    $result = calculateGrade($scores);
    assert($result == 0, "Test 1 Failed");

    // Test 2: Single score, no drop
    $scores = [ ["score" => 80, "max_points" => 100] ];
    $result = calculateGrade($scores);
    assert($result == 80.000, "Test 2 Failed");

    // Test 3: Multiple scores, no drop
    $scores = [ ["score" => 80, "max_points" => 100], ["score" => 90, "max_points" => 100] ];
    $result = calculateGrade($scores);
    assert($result == 85.000, "Test 3 Failed");

    // Test 4: Multiple scores, drop lowest
    $scores = [ ["score" => 80, "max_points" => 100], ["score" => 90, "max_points" => 100], ["score" => 70, "max_points" => 100] ];
    $result = calculateGrade($scores, true);
    echo $result;
    assert($result == 85.000, "Test 4 Failed");

    // Test 5: Multiple scores with different max points, no drop
    $scores = [ ["score" => 80, "max_points" => 100], ["score" => 45, "max_points" => 50] ];
    $result = calculateGrade($scores);
    assert($result == 83.333, "Test 5 Failed");

    // Test 6: Multiple scores with different max points, drop lowest
    $scores = [ ["score" => 80, "max_points" => 100], ["score" => 45, "max_points" => 50], ["score" => 30, "max_points" => 50] ];
    $result = calculateGrade($scores, true);
    assert($result == 83.333, "Test 6 Failed");

    echo "All tests passed!";
?>

<p>...</p>
</body>
</html>
