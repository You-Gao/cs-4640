<!DOCTYPE html>
<html lang="en">
<head>
    <!--  url: https://cs4640.cs.virginia.edu/djx3rn/project/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../project/styles/main.css">
    <meta name="author" content="You Gao">
    <title>home | Cool RPG Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="container">
    <section id="title" class="row justify-content-center align-items-end">
        <img src="../project/assets/mage.png" alt="placeholder" class="img-fluid col-2">
        <div class="col-auto text-center">
            <a href="?command=welcome"><h1>Cool RPG Game</h1></a>
        </div>
        <img src="../project/assets/warrior.png" alt="placeholder" class="img-fluid col-2">
        <hr class="mt-2"/>
    </section>
    
    <div class="row" id="content">
	        <?php
            if (isset($message) && $message != "") { ?>
                <section id="error" class="row justify-content-center mt-4 text-center">
                    <div class="col-6 alert alert-danger" role="alert">
                        <?php echo $message; ?>
                    </div>
                </section>
            <?php } ?>
        <div class="col-sm-12 col-md-2" id="side-content">
            <section id="login" class="row mt-4 mx-1">
                <h4>Login</h4>

                <form action="?command=login" method="post">
                    <div class="mb-2">
              		<label for="email" class="form-label">Email address</label>
             		<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
              		<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            	    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <a href="?command=signup" class="btn btn-secondary col-11 mx-2 mt-2">Sign Up</a>

            </section>
        </div>

        <div class="col-sm-12 col-md-10" id="main-content">
            <section id="leaderboard" class="row justify-content-center mt-4">
                <div class="col-10">
                    <h2>Leaderboard</h2>
                </div>
                <div class="col-10 table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Rank</th>
                                <th scope="col">Name</th>
                                <th scope="col">Exp</th>
                                <th scope="col">Monsters Killed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td><?=$leader1[0]?></td>
                                <td><?=$leader1[1]?></td>
                                <td><?=$leader1[2]?></td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td><?=$leader2[0]?></td>
                                <td><?=$leader2[1]?></td>
                                <td><?=$leader2[2]?></td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td><?=$leader3[0]?></td>
                                <td><?=$leader3[1]?></td>
                                <td><?=$leader3[2]?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="register" class="row justify-content-center mt-4 text-center">
                <a id="sign-up" href="?command=creation" class="btn btn-primary col-6 p-2">[ MAKE A CHARACTER!!! ]</a>
                <p>*No Sign-up Required*</p>
            </section>

        </div>
    </div>
</body>
