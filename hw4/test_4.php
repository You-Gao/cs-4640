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

<h2>Problem 4</h2>
<?php
 $acronyms = "rofl lol afk";
 $searchString = "Rabbits on freezing lakes only like really old fleece leggings.";
 $expected = [
     "rofl" => 2,
     "lol" => 1,
     "afk" => 0
 ];
 $result = acronymSummary($acronyms, $searchString);
 assert($result == $expected, 'Test Case 1 Failed');

 // Additional test cases
 $acronyms2 = "abc def";
 $searchString2 = "A big cat dances every Friday.";
 $expected2 = [
     "abc" => 1,
     "def" => 1
 ];
 $result2 = acronymSummary($acronyms2, $searchString2);
 assert($result2 == $expected2, 'Test Case 2 Failed');

 $acronyms3 = "xyz";
 $searchString3 = "Xylophones yield zebras.";
 $expected3 = [
     "xyz" => 1
 ];
 $result3 = acronymSummary($acronyms3, $searchString3);
 assert($result3 == $expected3, 'Test Case 3 Failed');

 $acronyms4 = "";
 $searchString4 = "This string is not empty.";
 $expected4 = [];
 $result4 = acronymSummary($acronyms4, $searchString4);
 assert($result4 == $expected4, 'Test Case 4 Failed');

 $acronyms5 = "test";
 $searchString5 = "";
 $expected5 = [];
 $result5 = acronymSummary($acronyms5, $searchString5);
 assert($result5 == $expected5, 'Test Case 5 Failed');

 echo "All test cases passed!";
?>

<p>...</p>
</body>
</html>
