<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{asset('css/login_and_register.css')}}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
    <!--Preloader-->
        <x-preloader/>
    <!--End-->
    <div class="container-fluid d-flex justify-content-center mt-5">
        <div class="login_container d-flex flex-column align-items-center">
            <h1 class="login_heading text-center">Login</h1>
            <form action="{{route('login')}}" method="POST" class="container mt-4">
                @csrf
                <label for="login_username" class="fw-bold">Username:</label>
                <input type="text" class="login_username form-control mt-1 border border-1 border-dark" name="username" id="login_username" placeholder="Enter Username" autocomplete="off">

                <label for="login_password" class="fw-bold mt-4">Password:</label>
                <input type="password" class="login_password form-control mt-1 border border-1 border-dark" name="password" id="login_password" placeholder="********" autocomplete="off">
                <div class="container d-flex mt-2">
                    <input type="checkbox" id="showPassword" class="me-2" onclick="showP()">
                    <label for="showPassword">Show Password</label>
                </div>

                <div class="container-fluid d-flex justify-content-center mt-4">
                    <button class="btn btn-dark w-100">Login</button>
                </div>

                <div class="container mt-3 text-center">
                    <p>Don't remember password? <a href="#">Reset Password</a></p>
                    <p>Don't have an account? <a href="{{route('register_view')}}">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        let password_field = document.getElementById('login_password');
        let password_checkbox = document.getElementById('showPassword');

        function showP(){
            if(password_checkbox.checked == true){
                password_field.type = "text";
            } else {
                password_field.type = "password"
            }
        }
    </script>
</body>
</html>