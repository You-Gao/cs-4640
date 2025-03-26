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
        <section id="inputs" class="row justify-content-center">
            <h2 id="anagram-title" class="my-4"> lets play some anagram! </h1>
                <div id="form container" class="col-6">
                    <form action="/index.php?command=welcome" method="post">
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 col-5">
                                <label class="form-label">name</label>
                                <input type="name" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label">display name</label>
                                <input type="name" name="user_name" class="form-control" maxlength="12" required>
                            </div> 
                        </div>
                        <div class="mb-3">
                            <label class="form-label">email</label>
                            <input type="email" name="email" class="form-control"required> 
                        </div>
                        <div class="mb-3">
                            <label class="form-label">password</label>
                            <input type="password" name="password" class="form-control"required> 
                        </div>
                        <div class="d-grid mx-auto">
                            <button type="submit" class="btn btn-primary col-6 mx-auto">onwards to anagrams</button>
                        </div>
                    </form>
                </div>
        </section>
</html>
