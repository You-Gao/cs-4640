<!DOCTYPE html>
<?php
function makeAlert($alert = NULL) {
    if (!is_null($alert) && isset($_POST["guess"])){
        echo "<div class='alert alert-danger col-6 mt-3' role='alert'>";
        echo "<h5 class='mb-0' style='text-align:center'>$alert</h5>";
        echo "</div>";
    }
else if (isset($_POST["guess"]) && (!($_POST["guess"] == ""))) {
        echo "<div class='alert alert-success col-6 mt-3' role='alert'>";
        echo "<h5 class='mb-0' style='text-align:center'>you got it right</h5>";
        echo "</div>";
        return;
    }
}

function echoScore()
{
    if (isset($_SESSION["score"])) {
        echo $_SESSION['score'];
    } else {
        echo "0";
    }
}

function echoName()
{
    if (isset($_SESSION["user_name"])) {
        echo $_SESSION['user_name'];
    } else {
        echo "something went wrong";
    }
}

function makeAnagramDisplay()
{
    if (isset($_SESSION["letters"])) {
        $letters = $_SESSION["letters"];
        for ($i = 0; $i < 7; $i++) {
            echo "<div class='mx-1'><h1>$letters[$i]</h1></div>";
        }
    }
}

function makeGuesses()
{
    $guesses = $_SESSION["guesses"];
    for ($i = 7; $i > 0; $i--) {
        $filtered = array_filter($guesses, function ($guess) use ($i) {
            return strlen($guess) == $i;
        });
        if (empty($filtered)) {
            continue;
        }
        echo "<div id='$i-letter-words' class='d-flex align-items-center mt-2'>";
        echo "<h2>$i" . "L" . ":</h2>";
        foreach ($guesses as $guess) {
            if (strlen($guess) == $i) {
                echo "<h3>$guess</h3>";
            }
        }
        echo "</div>";
    }
}

function makeHR($correct = NULL)
{
    if ($correct) {
        echo "<hr id='underline' class='mt-2 col-6 mx-auto' style='height: 5px; background-color: green;'/>";
    } else if ($correct === FALSE) {
        echo "<hr id='underline' class='mt-2 col-6 mx-auto' style='height: 5px; background-color: red;'/>";
    } else {
        echo "<hr id='underline' class='mt-2 col-6 mx-auto' style='height: 5px;'/>";
    }
}

?>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style>
        #anagram-display #display div,
        #user-input div {
            border: solid;
            height: 50px;
            width: 50px;
            text-align: center;
        }

        [id$="-letter-words"] {
            gap: 10px;
            border-bottom: solid;
            width: auto;
            height: auto;
            flex-wrap: wrap;
        }

        #score {
            max-width: 100%;
        }

        #shuffle button {
            border: none;
            background-color: white;
        }

        #guess_form button {
            border: none;
            background-color: white;
        }

        hr {
            margin-bottom: 0;
        }
        #guess_form {
            display: flex;
            align-items: flex-end;
        }
    </style>
</head>

<body class="container-lg mb-5">
    <section id="anagrams" class="row justify-content-center mt-4">
        <section id="anagram-title" class="d-flex col-12 align-items-baseline">
            <div class="col-3">
            </div>
            <h1 class="col-6 text-center">the anagrams game</h1>
            <div class="col-3 d-flex justify-content-end ">
                <h2 class="mb-0"><?php echoName(); ?></h2>
            </div>
        </section>
        <hr class="col-12 mx-auto mb-3" style="height: 5px;" />
        <section id="anagram-display" class="d-flex justify-content-between align-items-baseline mb-3">
            <div id="score" class="col-3">
                <h2>Score: <?php echoScore(); ?></h2>
            </div>
            <div id="display" class="d-flex col-6 justify-content-center">
                <?php makeAnagramDisplay(); ?>
            </div>
            <div id="shuffle" class="d-flex mb-0 col-3 justify-content-end">
                <form action="/index.php?command=game" method="post">
                    <input type="hidden" name="shuffle" value="true">
                    <button class="d-flex align-items-end" type="submit">
                        <h2 class="mb-0">shuffle</h2>
                    </button>
                </form>
                <form action="/index.php?command=game_over" method="post">
                    <input type="hidden" name="give_up" value="true">
                    <button class="d-flex align-items-end" type="submit">
                        <h2 class="mb-0">give up?</h2>
                    </button>
                </form>
            </div>
        </section>

        <section id="anagram-guesses" class="d-flex flex-wrap flex-column">
            <?php makeGuesses(); ?>
        </section>
        
        <?php makeAlert($alert); ?>

        <section id="input-line" class="d-flex mt-3 justify-content-center">
            <div class="col-3 d-flex align-items-end">
                <?php echo "<h2 class='mb-0'>".$_SESSION["words_remaining"]." words left"."</h2>" ?>
            </div>
            <div id="user-input" class="d-flex col-6 justify-content-center mb-0" style="height: 50px"></div>
            <form id="guess_form" action="/index.php?command=game" method="post" class="col-3 mb-0">
                <div class="col">
                    <input type="hidden" name="guess" class="form-control" required>
                    <button type="submit" style="";>
                        <h2 class="mb-0">^submit</h2>
                    </button>
                </div>
            </form>
        </section>

        <section id="name-email" style="position: fixed; bottom: 0; right: 0;">
            <p><?php echo "here just for the requirements (i like just the username) "; echo $_SESSION["name"]; echo " "; echo $_SESSION["email"]; ?></p>
        </section>
        
        <?php makeHR($correct_guess); ?>
    </section>
</body>

<script>
    function getGuess() {
        const inputDiv = document.getElementById("user-input");

        let guess_string = "";

        for (let child of inputDiv.children) {
            guess_string += child.textContent;
        }
        return guess_string;
    }

    function handleInput(event) {
        const key = event.key;
        const inputDiv = document.getElementById("user-input")

        if (key === "Backspace") {
            event.stopPropagation();
            event.preventDefault();
            const lastDiv = inputDiv.lastElementChild;
            if (lastDiv) {
                inputDiv.removeChild(lastDiv);
            }
            return 0;
        }

        if (key === "Enter") {
            const form = document.getElementById("guess_form");
            const hiddenInput = form.querySelector('input[type="hidden"][name="guess"]');
            hiddenInput.value = getGuess();
            form.submit();
            return 0;
        }

        if (inputDiv.childElementCount >= 7) {
            return 0;
        }

        if (key.match(/^[a-zA-Z]$/)) {
            const newDiv = document.createElement('div');
            newDiv.classList.add('mx-1');
            newDiv.innerHTML = `<h1>${key.toUpperCase()}</h1>`;
            inputDiv.appendChild(newDiv);
        }

    }
    window.addEventListener('keydown', handleInput);
</script>

</html>
