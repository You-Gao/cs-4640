<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../project/styles/main.css">
    <meta name="author" content="You Gao">
    <title>character creation | Cool RPG Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .character-container {
        width: 300px;
        display: flex;
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        position: absolute;
    }

    .character-container img {
        max-width: 100%; 
        max-height: 100%; 
        object-fit: contain; 
        z-index: -1;
    }

    .hat {
        width: 150px !important;
        height: 150px !important;
    }

    .shirt {
        max-width: 250px !important;
        height: 150px !important;
    }

    .pant {
        margin-top: -50px !important;
        max-width: 150px !important;
        height: 150px !important;
    }

    .shoes {
        margin-top: -50px !important;
        width: 150px !important;
        height: 100px !important;
    }

    @media screen and (max-width: 768px) {
        .register {
            margin-top: 100px !important;
        }
        .hat {
            width: 100px !important;
            height: 100px !important;
        }

        .shirt {
            width: 150px !important;
            height: 150px !important;
        }

        .pant {
            width: 100px !important;
            height: 100px !important;
        }

        .shoes {
            width: 100px !important;
            height: 100px !important;
        }
    }

    @media screen and (max-width: 480px) {
        .hat {
            width: 80px !important;
            height: 80px !important;
        }

        .shirt {
            width: 120px !important;
            height: 120px !important;
        }

        .pant {
            width: 80px !important;
            height: 80px !important;
        }

        .shoes {
            width: 80px !important;
            height: 80px !important;
        }
        
    }
    </style>
</head>

<body class="container">
    <section id="title" class="row justify-content-center align-items-end">
        <img src="../project/assets/mage.png" alt="placeholder" class="img-fluid col-2">
        <div class="col-auto text-center">
            <a href="?command=home">
                <h1>Cool RPG Game</h1>
            </a>
        </div>
        <img src="../project/assets/warrior.png" alt="placeholder" class="img-fluid col-2">
        <hr class="mt-2" />
    </section>

    <?php
    if (isset($message) && $message != "") { ?>
        <section id="error" class="row justify-content-center mt-4 text-center">
            <div class="col-6 alert alert-danger" role="alert" id="error-message">
                <?php echo $message; ?>
            </div>
        </section>
    <?php } ?>

    <section id="name" class="row justify-content-center mt-4">
        <div class="col-3 ">
            <input type="text" class="form-control" id="character-name" name="character-name" placeholder="-> make a cool name here <-" required oninput="set_character_name(event)">
        </div>
    </section>

    <section id="create" class="row justify-content-center mt-4">

        <div class="col-2">
            <div class="row flex-column align-items-end">
                <div onclick="show_selection(event)">
                    <p>HATS</p>
                    <div class="selections">
                        <div class="col-4 mx-2" onclick="change_src(1, 'hats')">hat 1</div>
                        <div class="col-4 mx-2" onclick="change_src(2, 'hats')">hat 2</div>
                        <div class="col-4 mx-2" onclick="change_src(3, 'hats')">hat 3</div>
                    </div>
                </div>
                <div onclick="show_selection(event)">
                    <p>SHIRTS</p>
                    <div class="selections">
                        <div class="col-4 mx-2" onclick="change_src(1, 'shirts')">shirt 1</div>
                        <div class="col-4 mx-2" onclick="change_src(2, 'shirts')">shirt 2</div>
                        <div class="col-4 mx-2" onclick="change_src(3, 'shirts')">shirt 3</div>
                    </div>
                </div>


            </div>
        </div>
        <img class="col-6" style="z-index: -2;" src="../project/assets/stick.jpg" alt="stick man" />
        <div class="character-container">
            <img id="hats" class="hat" src="../project/assets/transparent.png" alt="hat" />
            <img id="shirts" class="shirt" src="../project/assets/transparent.png" alt="shirt" />
            <img id="pants" class="pant" src="../project/assets/transparent.png" alt="pant" />
            <img id="shoes" class="shoes" src="../project/assets/transparent.png" alt="shoes" />
        </div>

        <div class="col-2">
            <div class="row flex-column align-items-start">
                <div onclick="show_selection(event)">
                    <p>SHOES</p>
                    <div class="selections">
                        <div class="col-4 mx-2" onclick="change_src(1, 'shoes')">shoe 1</div>
                        <div class="col-4 mx-2" onclick="change_src(2, 'shoes')">shoe 2</div>
                        <div class="col-4 mx-2" onclick="change_src(3, 'shoes')">shoe 3</div>
                    </div>
                </div>
                <div onclick="show_selection(event)">
                    <p>PANTS</p>
                    <div class="selections">
                        <div class="col-4 mx-2" onclick="change_src(1, 'pants')">pant 1</div>
                        <div class="col-4 mx-2" onclick="change_src(2, 'pants')">pant 2</div>
                        <div class="col-4 mx-2" onclick="change_src(3, 'pants')">pant 3</div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <section id="register" class="row justify-content-center mt-4 text-center">
        <form action="?command=create" method="POST" class="col-12">
            <input type="hidden" name="hat_id" id="hat" value="0">
            <input type="hidden" name="shirt_id" id="shirt" value="0">
            <input type="hidden" name="shoe_id" id="shoe" value="0">
            <input type="hidden" name="pant_id" id="pant" value="0">`
            <input type="hidden" name="name" id="hidden-character-name" value="">
            <button type="submit" class="btn btn-primary p-2 col-6">[ OFF TO ADVENTURE!!! ]</button>
        </form>
    </section>

    <script>
        function show_selection(event) {
            let parent = event.target;
            console.log("parent", parent);
            let selection = parent.querySelector(".selections");
            console.log("selection", selection);

            document.querySelectorAll(".selections").forEach(function(element) {
                element.style.display = "none";
            });

            // if clicked on inner div return (js is weird)
            if (selection == null) {
                return;
            }

            selection.style.display = "flex";
            selection.querySelectorAll("div").forEach(function(element) {
                element.addEventListener("click", function(event) {
                    let div_text = event.target.innerText;
                    let first_word = div_text.split(" ")[0];
                    let last_word = div_text.split(" ")[1];
                    document.getElementById(first_word).value = last_word;
                    console.log("hat", document.getElementById("hat").value);
                });
            });
        }

        function change_src(value, id) {
            let img = document.getElementById(id);
            img.src = "../project/assets/" + id + "/" + value + ".png";
            img.style.display = "block";
        }


        function set_character_name(event) {
            let character_name = document.getElementById("character-name");

            // validate that it only contains letters and numbers
            if (!/^[a-zA-Z0-9_]*$/.test(character_name.value)) {
                character_name.value = character_name.value.replace(/[^a-zA-Z0-9_\s]/g, '');
                alert("Name can only contain letters and numbers.");
                return;
            }
            document.getElementById("hidden-character-name").value = character_name;
        }
        
        window.addEventListener("load", function () {
            const stickImage = document.querySelector("img[src='../project/assets/stick.jpg']");
            const characterContainer = document.querySelector(".character-container");

            if (stickImage && characterContainer) {
                const stickRect = stickImage.getBoundingClientRect();
                characterContainer.style.top = `${stickRect.top + window.scrollY - 100}px`;
            }
        });
    </script>
</body>
