<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="friends page">
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
        <script>
            async function fillUsers() {
                let input = document.querySelector('input[name="username"]').value;
                if (input.length < 3) {
                    return; // Don't send a request if the input is less than 3 characters
                }
                const response = await fetch(`?command=searchF&name=${input}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                const datalist = document.getElementById('users');
                datalist.innerHTML = '';
                for (let i = 0; i < data.user_characters.length; i++) {
                   // data[i].username is the username of the character
                    console.log(data.user_characters[i].username);
                    const option = document.createElement('option');
                    option.value = data.user_characters[i].username;
                    option.textContent = data.user_characters[i].username; // Set the text content to the username
                    datalist.appendChild(option);

                }
            }
        </script>
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
                <a class="nav-item align-right btn" href="?command=logout" id="logout">
                    <h3> Log out</h3>
                </a>
            </nav>
        </header>
        <div class="row">
            <?php
            if (isset($message) && $message != "") { ?>
                <section id="error" class="row justify-content-center mt-4 text-center">
                    <div class="col-6 alert alert-danger" role="alert">
                        <?php echo $message; ?>
                    </div>
                </section>
            <?php } ?>
            <div class = "col-12" id = "add-friends">
                <h2 class = "friend-heading"> Add Friends</h2>
                <div class="search-container">
                    <form method="get">
                        <input type="hidden" name="command" value="searchF">
                        <input type="text" placeholder="Search for usernames" name="name">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>

            <div class = "col-12" id = "mocked-friends">
                    <form action="?command=addF" method="post">
                        <input list="users" type="text" placeholder="enter friend's username" name="username"
                        onchange="fillUsers()">
                        <datalist id="users">
                        </datalist> 
                        <button type="submit">Add Friend</button>
                    </form>
            </div>

            <div class="col-12">
                <h3 class = "friend-heading">Friend Requests</h3>
                <?php
                for ($x = 0; $x < count($friend_requests_out); $x++) {
                    echo "<div class = 'col-12 friend-item'>";
                    echo "<h5>{$friend_requests_out[$x]["username"]}</h5>";
                    echo "<form>";
                    echo "<button type='submit' class='btn btn-secondary'>Pending</button>";
                    echo "</form>";
                    echo "</div>";
                }
                ?>
                <?php
                for ($x = 0; $x < count($friend_requests_in); $x++) {
                    echo "<div class = 'col-12 friend-item'>";
                    echo "<h5>{$friend_requests_in[$x]["username"]}</h5>";
                    echo "<form method='POST' action='?command=acceptF'>";
                    echo "<input type='hidden' name='friend_id' value='{$friend_requests_in[$x]["id"]}'>";
                    echo "<button type='submit' class='btn btn-primary'>Accept</button>";
                    echo "</form>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div id="friend-row">
            <h2 class="friend-heading">Friends</h2>
            <?php 
            foreach ($friends as $friend) {
                echo "<div class='col-12 friend-item'>";
                echo "<h5>{$friend[0]["username"]}</h5>";
                echo "<form method='POST' action='?command=removeF'>";
                echo "<input type='hidden' name='friend_id' value='{$friend[0]["id"]}'>";
                echo "<button type='submit' class='btn btn-danger'>Remove</button>";
                echo "</form>";
                echo "</div>";
            }
            ?>
        </div>

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
