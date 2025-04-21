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
                <h4>Thanks for playing!</h4>
                <h4>Your final score was: <?php echo $_SESSION["score"]; unset($_SESSION["score_id"]); ?></h4>

                <h2>Player Statistics</h2>
                <?php
                $total_played = 0;
                $total_wins = 0;
                $total_score = 0;
                $highest_score = 0;
                foreach ($games as $game) {
                    if ($game["user_id"] === $_SESSION["user_id"]) {
                        $total_played++;
                        $total_score += $game["score"];
                        if ($game["score"] > $highest_score) {
                            $highest_score = $game["score"];
                        }
                        if (!is_null($game["win"])) {
                            $total_wins++;
                        }
                    }
                }

                $win_rate = $total_played === 0 ? 0 : $total_wins / $total_played * 100;
                $average_score = $total_played === 0 ? 0 : $total_score / $total_played;
                
                echo "<h4>Total Games Played: $total_played</h4>";
                echo "<h4>Total Wins: $total_wins</h4>";
                echo "<h4>Win Rate: $win_rate%</h4>";
                echo "<h4>Average Score: $average_score</h4>";
                echo "<h4>Highest Score: $highest_score</h4>";

                ?>

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
                            <th scope="col">User ID</th>
                            <th scope="col">Score</th>
                            <th scope="col">Word</th>
                            <th scope="col"># Unguessed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // brings back memories of java comparables
                        usort($games, function($a, $b) {
                            return $b["score"] - $a["score"];
                        });
                        $rank = 1;

                        foreach ($games as $game) {
                            echo "<tr>";
                            echo "<th scope='row'>$rank</th>";
                            echo "<td>{$game['user_id']}</td>";
                            echo "<td>{$game['score']}</td>";
                            echo "<td>{$game['word']}</td>";
                            echo "<td>{$game['words_remaining']}</td>";
                            echo "</tr>";
                            $rank++;
                        }
                        ?>
                    </tbody>
            </section>
        </section>
    </body>
</html> 