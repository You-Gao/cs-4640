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
        <meta property="og:url" content="https://cs4640.cs.virginia.edu/">
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
                    <form action="?command=game" method="post">
                        <input type="hidden" name="location" value="main">
                        <button type="submit">Map</button>
                    </form> 
                </div>
                <div class="n-item">
                <a href="?command=inventory">Inventory</a>
                </div>
                <div class="n-item">
                <a href="?command=friends">Friends</a>
                </div>
                <div class="n-item">
                <a href="?command=settings">Settings</a>
                </div>
                <a class="nav-item align-right btn" href="?command=logout">
                    <h3> Log out</h3>
                </a>
            </nav>
        </header>
        
        <div class="container">
            <footer class="py-3 my-4">
              <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="?command=logout" class="nav-link px-2 text-body-secondary">Home</a></li>
                <li class="nav-item"><a href="?command=game" class="nav-link px-2 text-body-secondary">Game</a></li>
                <li class="nav-item"><a href="?command=inventory" class="nav-link px-2 text-body-secondary">Inventory</a></li>
                <li class="nav-item"><a href="?command=friends" class="nav-link px-2 text-body-secondary">Friends</a></li>
                <li class="nav-item"><a href="?command=settings" class="nav-link px-2 text-body-secondary">Settings</a></li>
              </ul>
              <small class="copyright">&copy; copyright 2025 video game name</small>
            </footer>
          </div>
    </body>
</html>
