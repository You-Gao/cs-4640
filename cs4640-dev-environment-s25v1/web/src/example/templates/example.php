<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="CS4640 Spring 2024">
  <meta name="description" content="A full-stack example with PHP and JavaScript.">  
  <title>CS4640 Spring 2024 Full-Stack Example</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"  crossorigin="anonymous">
</head>

<body>

<div class="container" style="margin-top: 15px;">
            <div class="row col-xs-12">
                <h1>CS4640 Spring 2024 Full Stack Example</h1>
                <p>This example includes a front-controller design in PHP, along with some JavaScript.</p>
            </div>
            <div class="row col-xs-12">
                <!-- Print a variable from PHP using short tags -->
                <p id="example">Input Parameters: <?= $dataElement ?></p>
            </div>
        </div>

    <!-- Include our JavaScript, which must be publicly served by Apache -->
    <script src="js/example.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
