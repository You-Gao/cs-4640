<?php 
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <style>
        </style>
    </head>
    <body class="container-lg">
        <section class="row">
            <h1>Game Over</h1>
            <p>Thanks for playing!</p>
            <p>Your final score was: <?php echo $_SESSION["score"]; unset($_SESSION["score"]); ?></p>
            <form action="/index.php?command=game_over" method="post">
                <input type="hidden" name="play_again" value="true">
                <button type="submit" class="btn btn-primary">Play Again</button>
            </form>
            <form action="/index.php?command=game_over" method="get">
                <input type="hidden" name="logout" value="true">
                <button type="submit" class="btn btn-primary">Quit</button>
            </form>
        </section>
    </body>
</html> 