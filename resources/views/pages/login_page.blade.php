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
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="container-fluid d-flex justify-content-center mt-5">
        <div class="login_container d-flex flex-column align-items-center">
            <h1 class="login_heading text-center">Login</h1>
            <form action="{{route('login')}}" method="POST" class="container mt-4">
                @csrf
                <label for="login_username" class="fw-bold">Username:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><img src="{{ asset('icons/user-circle-dark.svg') }}" alt="Username"></span>
                    <input type="text" class="login_username form-control" name="username" id="login_username" placeholder="Enter Username" autocomplete="off">
                </div>
                @error('username')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <label for="login_password" class="fw-bold mt-4">Password:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><img src="{{ asset('icons/key.svg') }}" alt="Password"></span>
                    <input type="password" class="login_password form-control" name="password" id="login_password" placeholder="********" autocomplete="off">
                </div>

                <div class="container d-flex mt-2">
                    <input type="checkbox" id="showPassword" class="me-2" onclick="showP()">
                    <label for="showPassword">Show Password</label>
                </div>
                @error('password')
                    <p class="text-danger">{{$message}}</p>
                @enderror

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