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
            <h1 class="login_heading text-center">Reset Password</h1>
            <form action="{{ route('email_exist') }}" method="POST" class="container mt-4">
                @csrf
                <label for="login_username" class="fw-bold">Enter Email Address:</label>
                <input type="email" class="form-control border border-1 border-dark" name="email" placeholder="Enter your email address" autocomplete="off">
                <!-- Display Error Message -->
                @if(session('error'))
                    <span class="text-danger mt-2">
                        {{ session('error') }}
                    </span><br>
                @endif

                <div class="container-fluid mt-4">
                    <button class="btn btn-dark w-100" type="submit">Submit</button>
                    <a href="/" class="btn btn-outline-dark w-100 mt-3" type="submit">Back to Homepage</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Display Error Message -->
    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <script>
        let password_field = document.getElementById('register_password');
        let confirm_password_field = document.getElementById('confirm_password');
        let password_checkbox = document.getElementById('showPassword');
        let confirm_password_checkbox = document.getElementById('showConfirmPassword');


        function showP(){
            if(password_checkbox.checked == true){
                password_field.type = "text";
            } else {
                password_field.type = "password"
            }
        }

        function showConfirm(){
            if(confirm_password_checkbox.checked == true){
                confirm_password_field.type = "text";
            } else {
                confirm_password_field.type = "password"
            }
        }
    </script>
</body>
</html>