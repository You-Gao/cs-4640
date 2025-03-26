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
    <body class="container-lg mt-5">
        <section class="row">
            <section class="col-6">
                <h1>Game Over</h1>
                <p>Thanks for playing!</p>
                <p>Your final score was: <?php echo $_SESSION["score"];?></p>
                <form action="/index.php?command=game" method="post">
                    <input type="hidden" name="play_again" value="true">
                    <button type="submit" class="btn btn-primary">Play Again</button>
                </form>
                <form action="/index.php?command=default" method="post">
                    <input type="hidden" name="logout" value="true">
                    <button type="submit" class="btn btn-primary">Quit</button>
                </form>
            </section>

            <section class="col-6">
                <h2> High Scores </h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Name</th>
                            <th scope="col">Score</th>
                            <th scope="col">Word</th>
                            <th scope="col"># Unguessed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $high_scores = json_decode(file_get_contents('/opt/src/high_scores.json'), true);
                        $rank = 1;
                        foreach ($high_scores as $score) {
                            echo "<tr>";
                            echo "<th scope='row'>$rank</th>";
                            echo "<td>" . $score["name"] . "</td>";
                            echo "<td>" . $score["score"] . "</td>";
                            echo "<td>" . $score["word"] . "</td>";
                            echo "<td>" . $score["words_remaining"] . "</td>";
                            echo "</tr>";
                            $rank++;
                        }
                        ?>
                    </tbody>
            </section>
        </section>
    </body>
</html> 