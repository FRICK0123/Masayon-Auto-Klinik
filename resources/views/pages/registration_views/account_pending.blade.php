<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pending</title>

    <!--Bootstrap Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!--Bootstrap Links end-->

</head>
<body>
    <section class="container-fluid">
        <div class="container d-flex flex-column align-items-center">
            <img src="Images/pending_art.png" alt="Pending Image" class="img-fluid" width="500">
            <h3 class="text-center">Your Request is Pending. Please wait until your account is verified</h3>

            <form action="/" method="get">
                @csrf
                <button class="btn btn-primary mt-5 p-3">Go back to homepage</button>
            </form>
        </div>
    </section>
</body>
</html>