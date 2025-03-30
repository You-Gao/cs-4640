<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../project/styles/main.css">
    <meta name="author" content="You Gao">
    <title>character creation | insert title here</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="container">
    <section id="title" class="row justify-content-center align-items-end">
        <img src="../project/public/mage.png" alt="placeholder" class="img-fluid col-2">
        <div class="col-auto text-center">
            <a href="index.html"><h1>insert title here</h1></a>
        </div>
        <img src="../project/public/warrior.png" alt="placeholder" class="img-fluid col-2">
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
                    <div class="col-4 mx-2">hat 1</div>
                    <div class="col-4 mx-2">hat 2</div>
                    <div class="col-4 mx-2">hat 3</div>
                </div>
            </div>
            <div onclick="show_selection(event)">
                <p>SHIRTS</p>
                <div class="selections">
                    <div class="col-4 mx-2">shirt 1</div>
                    <div class="col-4 mx-2">shirt 2</div>
                    <div class="col-4 mx-2">shirt 3</div>
                </div>
            </div>


		</div>	
	    </div>

	<img class="col-6" src="../project/public/stick.jpg" alt="stick man"/>

		<div class="col-2">
			<div class="row flex-column align-items-start">
				<div onclick="show_selection(event)">
                    <p>SHOES</p>
                    <div class="selections">
                        <div class="col-4 mx-2">shoe 1</div>
                        <div class="col-4 mx-2">shoe 2</div>
                        <div class="col-4 mx-2">shoe 3</div>
                    </div>
                </div>
				<div onclick="show_selection(event)">
                    <p>PANTS</p>
                    <div class="selections">
                        <div class="col-4 mx-2">pant 1</div>
                        <div class="col-4 mx-2">pant 2</div>
                        <div class="col-4 mx-2">pant 3</div>
                    </div>
                </div>

			</div>
		</div>
	
    </section>

    <section id="register" class="row justify-content-center mt-4 text-center">
        <form action="?command=make_character" method="POST" class="col-12">
            <input type="hidden" name="hat_id" id="hat" value="null">
            <input type="hidden" name="shirt_id" id="shirt" value="null">
            <input type="hidden" name="shoe_id" id="shoe" value="null">
            <input type="hidden" name="pant_id" id="pant" value="null">
            <input type="hidden" name="name" id="hidden-character-name" value="null">
            <button type="submit" class="btn btn-primary p-2 col-6">[ OFF TO ADVENTURE!!! ]</button>
        </form>
    </section>

<script>
    function show_selection(event){
        let parent = event.target;
        console.log("parent", parent);
        let selection = parent.querySelector(".selections");
        console.log("selection", selection);

        document.querySelectorAll(".selections").forEach(function(element){
            element.style.display = "none";
        });

        // if clicked on inner div return (js is weird)
        if (selection == null){
            return;
        }

        selection.style.display = "flex";
        selection.querySelectorAll("div").forEach(function(element){
            element.addEventListener("click", function(event){
            let div_text = event.target.innerText;
            let first_word = div_text.split(" ")[0];
            let last_word = div_text.split(" ")[1];
            document.getElementById(first_word).value = last_word;
            console.log("hat", document.getElementById("hat").value);
            });
        });
    }


    function set_character_name(event){
        let character_name = document.getElementById("character-name").value;
        document.getElementById("hidden-character-name").value = character_name;
    }

</script>

</body>
