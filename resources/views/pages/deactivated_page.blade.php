<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deactivated</title>

    <!--Bootstrap Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!--Bootstrap Links end-->

</head>
<body>
    <section class="container-fluid mt-5">
        <div class="container d-flex flex-column align-items-center">
            <div style="background-color: red; border-radius: 50%; width: 150px; height: 150px;" class="d-flex justify-content-center align-items-center">
                <h1 class="text-light" style="font-size: 50px;">X</h1>
            </div>
            <h3 class="text-center mt-5">Your Account has been deactivated, please contact the manager or admin!</h3>

            <form action="/" method="get">
                @csrf
                <button class="btn btn-primary mt-5 p-3">Go back to homepage</button>
            </form>
        </div>
    </section>
</body>
</html>