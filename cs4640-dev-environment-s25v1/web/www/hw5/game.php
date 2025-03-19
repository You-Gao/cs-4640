<?php
function echoScore() {
    if (isset($_SESSION["score"])){
        echo $_SESSION['score'];
    }
    else {
        echo "0";
    }
}

function echoName() {
    if (isset($_SESSION["name"])){
        echo $_SESSION['name'];
    }
    else {
        echo "something went wrong";
    }
}

function makeAnagramDisplay() {
    if (isset($_SESSION["letters"])){
        $letters = $_SESSION["letters"];
        foreach ($letters as $letter) {
            echo "<div class='mx-1'><h1>$letter</h1></div>";
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <style>
        #anagram-display div, #user-input div {
            border: solid;
            height: 50px;
            width: 50px;
            text-align: center;
        }
        input {
            text-align: center;
            font-size: calc(1.375rem + 1.5vw) !important;
        }
        </style>
    </head>
    <body class="container">
        <h2><?php echoScore(); ?></h2> 
        <section id="anagrams" class="row justify-content-center">
            <div id="anagram-display" class="d-flex justify-content-center">
                <?php makeAnagramDisplay(); ?>    
            </div>
            
            <div id="anagram-guesses">

            </div>

            <div id="user-input" class="d-flex justify-content-center"></div>
            <hr id="underline" class="mt-2 col-8" style="height: 5px;"/>
            <form id="guess_form" action="/index.php?command=game" method="post">
                     <div class="mb-3 col">
                        <input type="hidden" name="guess" class="form-control" required>
                    </div> 
                </form>

        </section>
    </body>

    <script>
    function getGuess(){
        const inputDiv = document.getElementById("user-input");

        let guess_string = "";

        for (let child of inputDiv.children) {
            guess_string += child.textContent;
        }

    }
    function handleInput(event){
        const key = event.key;
        const inputDiv = document.getElementById("user-input")
        
       
        if (key === "Backspace") {
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
