<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <style>
        #anagram-title {
            text-align: center;
        } 
        </style>
    </head>
    <body class="container-lg">
        <section id="title" class="row justify-content-center align-items-end">
            <img src="../project/assets/mage.png" alt="placeholder" class="img-fluid col-2">
            <div class="col-auto text-center">
                <a href="?command=welcome"><h1>Cool RPG Game</h1></a>
            </div>
            <img src="../project/assets/warrior.png" alt="placeholder" class="img-fluid col-2">
            <hr class="mt-2"/>
        </section>
        <section id="inputs" class="row justify-content-center">
            <h2 id="anagram-title" class="my-4"> sign-up to save progress!</h1>
            <?php
            if (isset($message) && $message != "") { ?>
                <section id="error" class="row justify-content-center mt-4 text-center">
                    <div class="col-6 alert alert-danger" role="alert">
                        <?php echo $message; ?>
                    </div>
                </section>
            <?php } ?>

                <div id="form container" class="col-6">
                    <form action="?command=signup" method="post">
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 col-5">
                                <label class="form-label">username</label>
                                <input type="name" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label">password</label>
                                <input type="password" name="password" class="form-control" minlength="6" required>
                            </div> 
                        </div>
                        <div class="mb-3">
                            <label class="form-label">email</label>
                            <input type="email" name="email" class="form-control"required> 
                        </div>
                        <div class="d-grid mx-auto">
                            <button type="submit" class="btn btn-primary col-6 mx-auto">onwards to adventure!</button>
                        </div>
                    </form>
                </div>
        </section>
</html>
