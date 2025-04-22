<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../project/styles/main.css">
    <meta name="author" content="You Gao">
    <title>home | insert title here</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script>
        // http://localhost:8080/project/?command=getCharacterData&character_id=id
        async function gatherStatistics() {
            let characterIds = document.querySelectorAll("#characters ul li form input[name='character_id']");
            let ids = Array.from(characterIds).map(input => input.value);
            let stats = {
                "monsters_killed": [],
                "total_exp": [],
                "stat_points": [],
            }
            for (let i = 0; i < ids.length; i++) {
                let response = await fetch(`?command=getCharacterData&character_id=${ids[i]}`);
                let data = await response.json();
                stats["monsters_killed"].push(data["monsters_killed"]);
                stats["total_exp"].push(data["total_exp"]);
                stats["stat_points"].push(data["stat_points"]);
            }
            let statsDiv = document.querySelector("#statistics ul");
            statsDiv.innerHTML = ""; // Clear previous stats
            let totalMonstersKilled = stats["monsters_killed"].reduce((a, b) => a + b, 0);
            let totalExp = stats["total_exp"].reduce((a, b) => a + b, 0);
            let totalStatPoints = stats["stat_points"].reduce((a, b) => a + b, 0);
            statsDiv.innerHTML += `<li>Total Monsters Killed: ${totalMonstersKilled}</li>`;
            statsDiv.innerHTML += `<li>Total Experience: ${totalExp}</li>`;
            statsDiv.innerHTML += `<li>Total Stat Points: ${totalStatPoints}</li>`;
        }
        </script>
</head>

<body class="container" onload="gatherStatistics()">
    <section id="title" class="row justify-content-center align-items-end">
        <img src="../project/assets/mage.png" alt="placeholder" class="img-fluid col-2">
        <div class="col-auto text-center">
            <a href="index.html"><h1>insert title here</h1></a>
        </div>
        <img src="../project/assets/warrior.png" alt="placeholder" class="img-fluid col-2">
        <hr class="mt-2"/>
    </section>
        <?php
            if (isset($message) && $message != "") { ?>
                <section id="error" class="row justify-content-center mt-4 text-center">
                    <div class="col-6 alert alert-danger" role="alert">
                        <?php echo $message; ?>
                    </div>
                </section>
            <?php } ?>

    <section id="leaderboard" class="row mt-4 justify-content-center">
        <div class="col-sm-12 col-md-8">
            <h2>Leaderboard</h2>
        </div>
        <div class="col-sm-12 col-md-8 table-responsive">
            <table class="table table-sm table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Name</th>
                        <th scope="col">Level</th>
                        <th scope="col">Class</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>wizardman123</td>
                        <td>100</td>
                        <td>Wizard</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>warriorman123</td>
                        <td>100</td>
                        <td>Warrior</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>roguewoman123</td>
                        <td>100</td>
                        <td>Rogue</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <div class="row justify-content-center mt-4">
        <section id="characters" class="col-sm-12 col-md-4">
            <h2>Characters</h2>
            <h5>Select to Play</h5>
            <hr/>
            <div>
            <?php
            for ($x = 0; $x < count($characters); $x++) {
                echo "<ul>";
                echo "<li>";
                echo "<form method='POST' action='?command=game' style='display: inline;'>";
                echo "<input type='hidden' name='character_id' value='{$characters[$x]["id"]}'>";
                echo "<a href='#' onclick='this.closest(\"form\").submit(); return false;'>{$characters[$x]["name"]}</a>";
                echo "</form>";
                echo "<form method='POST' action='?command=delete' style='display: inline;'>";
                echo "<input type='hidden' name='character_id' value='{$characters[$x]["id"]}'>";
                echo "<button type='submit' class='btn btn-danger btn-sm mx-2' style='height:20px; padding:0.1rem; line-height: 1; font-size: .75rem'>x</button>";
                echo "</form>";

                echo "</li>";
                echo "</ul>";
            }
            ?>
            </div>
            <div id="create" class="my-5">
                <a href="?command=creation">Create New Character</a>
            </div>
        </section>
        <section id="statistics" class="col-sm-12 col-md-4">
            <h2>Statistics</h2>
            <div>
                <ul>
                </ul>
            </div>
        </section>
    </div>
</body>
</html>
