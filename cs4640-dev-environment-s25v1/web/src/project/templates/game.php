<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="text based video game rpg">
        <meta name="author" content="Owen Williams">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:title" content="main game page">
        <meta property="og:type" content="website">
        <meta property="og:img" content="../project/assets/mage.png">
        <meta property="og:url" content="https://cs4640.cs.virginia.edu/yourid/hw2/index.html">
        <meta property="og:description" content="text based video game rpg">
        <meta property="og:site_name" content="Video Game Name">
        <title>Video Game Name</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../project/styles/game.css">
    </head>  
    <body>
        <header class = "row">
            <nav class="navbar navbar-light bg-light">
                <a class="navbar-brand btn" href="home_logged_in.html">
                  <h2> Game title</h2>
                </a>
                <div class="n-item">
                <a href="game.html">Map</a>
                </div>
                <div class="n-item">
                <a href="inventory.html">Inventory</a>
                </div>
                <div class="n-item">
                <a href="friends.html">Friends</a>
                </div>
                <div class="n-item">
                <a href="settings.html">Settings</a>
                </div>
                <a class="nav-item align-right btn" href="index.html">
                    <h3> Log out</h3>
                </a>
            </nav>
        </header>
        <div class = "row clearfix">
            <div class = "col-md-2 float-md-end col-border clearfix">
                <h4>Recent Anoucments</h4>
                <p>
                    Anoucments placeholder
                </p>
            </div>
            <div class = 'col-md-8 float-md-end col-border clearfix'>
                <h4 class = "content">Game map</h4>
                <form action="/action_page.php" method="get">
                <table class = "content">
                    <tr>
                      <td><input type="image" src="../project/assets/Town.png" alt="andi placeholder"></td>
                      <td><img src = "../project/assets/empty.png" alt="andi placeholder"></td>
                      <td><input type="image" src="../project/assets/Plains.png" alt="andi placeholder"/></td>
                    </tr>
                    <tr>
                      <td><img src = "../project/assets/empty.png" alt="andi placeholder"></td>
                      <td><input type="image" src="../project/assets/Forest.png" alt="andi placeholder"/></td>
                      <td><img src = "../project/assets/empty.png" alt="andi placeholder"></td>
                    </tr>
                    <tr>
                      <td><input type="image" src="../project/assets/Mountains.png" alt="andi placeholder"/></td>
                      <td><img src = "../project/assets/empty.png" alt="andi placeholder"></td>
                      <td><input type="image" src="../project/assets/Castle.png" alt="andi placeholder"/></td>
                    </tr>
                  </table>
                </form>
                </div>
            <div class = 'float-md-end col-md-2 col-border clearfix'>
                <div class = 'mobile_split_4'>
                    <h2>
                        <img src = "../project/assets/mage.png" alt = "charater icon">
                    </h2>
                </div>
                <div class = 'mobile_split_4'>
                    <p>
                        Basic stats
                    <p>
                        Health = 20/20
                    <p>
                        Defence = 5
                    <p>
                        Attack = 10
                    </p>
                </div>
                <div class = 'mobile_split_4'>
                    <p>
                        Quests:
                    <p>
                        Do Something
                    </p>
                </div>
            </div>
        </div>
        <section class = "row" id = "about">
            <div class = "col-12">
                <h2>
                    About the game
                </h2>
                <p>
                    This game is a text based rpg where your charater can level up click on the map to get quests, fight monsters and level up.
                </p>
            </div>
        </section>
        <div class="container">
            <footer class="py-3 my-4">
              <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="home.html" class="nav-link px-2 text-body-secondary">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Game</a></li>
                <li class="nav-item"><a href="inventory.html" class="nav-link px-2 text-body-secondary">Inventory</a></li>
                <li class="nav-item"><a href="friends.html" class="nav-link px-2 text-body-secondary">Friends</a></li>
                <li class="nav-item"><a href="settings.html" class="nav-link px-2 text-body-secondary">Settings</a></li>
              </ul>
              <small class="copyright">&copy; copyright 2025 video game name</small>
            </footer>
          </div>
    </body>
</html>
