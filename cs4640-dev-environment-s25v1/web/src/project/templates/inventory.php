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
        <script>
            async function load(){      
            var response = await fetch("?command=items")
            if (!response.ok) {;
                throw new Error("Response failed");
            }
            let obj = await response.json();
            let table = document.getElementById("table");
            const additem = (item) => {
                let newRow = table.insertRow(table.rows.length);
                let newCell = newRow.insertCell(0);
                newCell.textContent = item.name + " (" + item.type + ") " + " atk: " + item.atk + " def: " + item.def + " hp: " + item.hp;
                newCell = newRow.insertCell(1);
                if(item.equiped === "0"){
                    newCell.innerHTML = "<button class='btn btn-primary' onclick='equip("+item.id+");'>Equip</button>";
                }
                else{
                    newCell.innerHTML = "<button class='btn btn-danger' onclick='equip("+item.id+");'>Unequip</button>";
                }
            };
            if(obj.length !== 0){
                for (let i = 0; i < obj.length; i++){
                    additem(obj[i]);
                }
            }
            }
            async function equip(id){
                var response = await fetch("?command=equip", {
                method: "POST",
                body:  JSON.stringify({item_id: id})
                })
                if (!response.ok) {;
                    throw new Error("Response failed");
                }
                let obj = await response.json();
                let table = document.getElementById("table");
                for (let i = table.rows.length - 1; i > 0; i--) {
                    table.deleteRow(i);
                }
                await load();
            }
        </script>
    </head>  
    <body onload="load();">
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
        <div class="row" style="margin-top: 20px;">    
            <div class="col-12">
              <div class="card">
                <h4 class="card-header">Inventory</h4>
                <div class="card-body"> 
                <table id="table" class="table table-striped">
                    <tr class="table-dark">
                        <th style="width: 80%;">Items</th>
                        <th style="width: 20%;"></th>
                    </tr>
                </table>
                </div>
              </div>
            </div>
        </div>
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
