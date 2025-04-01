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
        <div class = "row clearfix">
            <div class = "col-md-2 float-md-end col-border clearfix">
                <h4>Recent Anoucments</h4>
                <p>
                    Sprint 3 completed
                </p>
            </div>
            <div class = 'col-md-8 float-md-end col-border clearfix'>
                <?php
if($location === "town"){
                    echo '<h4 class = "content">Town</h4>
                <table class = "content">
                    <tr>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                    </tr>
                    <tr>
                      <td><p>quest giver place holder</p></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td>
                          <form action = "?command=heal" method = "post">
                            <button type="submit">
                              <p>healing well place holder</p>
                            </button>
                          </form>
                      </td>
                    </tr>
                    <tr>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td>
                          <form action="?command=game" method="post">
                              <input type="hidden" name="location" value="main">
                              <button type="submit" class="btn btn-primary">Back</button>
                          </form>
                      </td>
                    </tr>
                  </table>';
}
elseif($location === "won"){
                    echo '
                <table class = "content">
                    <tr>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td><p>You defeated '.$monster_name.'.
                      <p>You got '.$exp_gain.' exp.
                      </p></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                    </tr>
                    <tr>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td><p>You recived 1 '.$recived[0]["name"].'.</p></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                    </tr>
                    <tr>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td>
                          <form action="?command=game" method="post">
                              <input type="hidden" name="location" value="main">
                              <button type="submit" class="btn btn-primary">Back</button>
                          </form>
                      </td>
                    </tr>
                  </table>';
}
elseif($location === "forest" || $location === "plains" || $location === "mountains" || $location === "boss"){
                    echo '<h4 class = "content">'.ucfirst($location).'</h4>
                <table class = "content">
                    <tr>
                      <td><p>Health = '.$hp.'/'.$max_hp.'</p></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td><p>Monster Health = '.$monster_hp.'</p></td>
                    </tr>
                    <tr>
                      <td><p>character image place holder</p></td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td><p>'.$monster_name.' image place holder</p></td>
                    </tr>
                    <tr>
                      <td colspan="2">';
                    if(isset($damage_dealt) && !empty($damage_dealt)){
                        echo '<p>You dealt '.$damage_dealt.' to '.$monster_name.'.
                        <p>'.$monster_name.' dealt '.$damage_taken.' to you.
                        </p>';
                    }
                echo'</td>
                      <td>
                          <a href="?command=attack" class="btn btn-danger">Attack</a>
                          <form action="?command=game" method="post">
                              <input type="hidden" name="location" value="main">
                              <button type="submit" class="btn btn-primary">Run</button>
                          </form>
                      </td>
                    </tr>
                  </table>';
}
else{
                echo '<h4 class = "content">Game map</h4>
                <table class = "content">
                    <tr>
                      <td>
                          <form action="?command=game" method="post">
                              <input  type="hidden" name="location" value="town">
                              <button type="submit">
                                  <img src="../assets/town.png" alt="town image">
                              </button>
                          </form>
                      </td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td>
                          <form action="?command=game" method="post">
                              <input  type="hidden" name="location" value="forest">
                              <button type="submit">
                                  <img src="../assets/forest.png" alt="forest image">
                              </button>
                          </form>
                      </td>
                    </tr>
                    <tr>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td>
                          <form action="?command=game" method="post">
                              <input  type="hidden" name="location" value="plains">
                              <button type="submit">
                                  <img src="../assets/plains.png" alt="plains image">
                              </button>
                          </form>
                      </td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                    </tr>
                    <tr>
                      <td>
                          <form action="?command=game" method="post">
                              <input  type="hidden" name="location" value="mountains">
                              <button type="submit">
                                  <img src="../assets/mountains.png" alt="mountians image">
                              </button>
                          </form>
                      </td>
                      <td><img src = "../assets/empty.png" alt="empty location"></td>
                      <td>
                          <form action="?command=game" method="post">
                              <input  type="hidden" name="location" value="boss">
                              <button type="submit">
                                  <img src="../assets/castle.png" alt="castle image">
                              </button>
                          </form>
                      </td>
                    </tr>
                  </table>';
}
                ?>
            </div>
            <div class = 'float-md-end col-md-2 col-border clearfix'>
                <div class = 'mobile_split_4'>
                    <?php
                    echo "<p>";
                        $levelpoints = array(0,10,30,75,180,400,1000,1000000000000);
                        $end = 0;
                        for ($x = 0; $x < count($levelpoints); $x++) {
                            if($exp >= $levelpoints[$x]){
                              $end = min($x, 6);
                            }
                        }
                    echo "Level = ".$end+1;
                    echo "<p>";
                    echo "exp = ".$exp-$levelpoints[.$end]."/".$levelpoints[.$end+1]-$levelpoints[.$end];
                    echo "</p>";
                    ?>
                    <h2>
                        <p>
                            placehould for hat with id = <?=$hat_id?>
                        <p>
                            placehould for shirt with id = <?=$shirt_id?>
                        <p>
                            placehould for pants with id = <?=$pants_id?>
                        <p>
                            placehould for shoes with id = <?=$shoes_id?>
                        </p>
                    </h2>
                </div>
                <div class = 'mobile_split_4'>
                    <p>
                        Stats
                    <p>
                        Health = <?=$hp?>/<?=$max_hp?>
                    <p>
                        Defence = <?=$def?>
                    <p>
                        Attack = <?=$atk?>
                    </p>
                </div>
                <div class = 'mobile_split_4'>
                    <p>
                        Quests:
                    <p>
                        placeholder for quest with id = <?=$quest_id?>
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
