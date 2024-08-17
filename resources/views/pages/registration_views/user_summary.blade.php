<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Review</title>
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
            <h2 class="register_heading text-center">Review Details</h2>

            <form action="{{route('register_store')}}" method="POST" class="container mt-4">
                @csrf
                <span class="fw-bold">Full Name: </span><span>{{Session::get('fullname')}}</span><br><br>
                <span class="fw-bold">Email address: </span> <span>{{Session::get('email')}}</span><br><br>
                <span class="fw-bold">Phone Number: </span> <span>+63{{Session::get('phone')}}</span><br><br>
                <span class="fw-bold">Username: </span> <span>{{Session::get('username')}}</span><br><br>
                <span class="fw-bold">Password: </span> <span id="password">********</span><br>
                <div class="d-flex">
                    <input type="checkbox" id="dehash" class="me-2">
                    <label for="dehash">Show Password</label>
                </div>

                <button class="btn btn-dark mt-3 w-100">Register</button>
                <button class="btn btn-light border border-1 border-dark mt-3 w-100" id="goBack" type="button">Go Back</button>

                <input type="hidden" name="fullname" value="{{Session::get('fullname')}}">
                <input type="hidden" name="email" value="{{Session::get('email')}}">
                <input type="hidden" name="phone" value="{{Session::get('phone')}}">
                <input type="hidden" name="username" value="{{Session::get('username')}}">
                <input type="hidden" name="password" value="{{Session::get('plain_password')}}">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('dehash').addEventListener('change', function() {
            var passwordField = document.getElementById('password');
            if (this.checked) {
                passwordField.textContent = "{{ Session::get('plain_password') }}";
            } else {
                passwordField.textContent = "********";
            }
        });

        document.getElementById('goBack').addEventListener('click',()=>{
            window.history.back();
        });
    </script>
</body>
</html>