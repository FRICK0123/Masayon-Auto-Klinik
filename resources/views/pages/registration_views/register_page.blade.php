<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
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
            <h2 class="register_heading text-center">Register</h2>
            <form action="{{route('register_details')}}" method="POST" class="container mt-4 registration_form">
                @csrf
                <!--Full Name-->
                <label for="register_fullname" class="fw-bold">Full Name:</label>
                <input type="text" class="form-control mt-1 border border-1 border-dark" name="register_fullname" id="register_fullname" placeholder="Enter Full Name" autocomplete="on" required>

                <!--Email Address-->
                <label for="register_email" class="fw-bold mt-4">Email Address:</label>
                <input type="email" class="form-control mt-1 border border-1 border-dark" name="register_email" id="register_email" placeholder="Enter Email Address" autocomplete="on" required>
                @error('register_email')
                    <span class="text-danger">{{ $message }}</span><br>
                @enderror

                <!--Phone Number-->
                <label for="register_phone" class="fw-bold mt-4">Phone Number:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">+63</span>
                    <input type="text" class="form-control" placeholder="9705678909" id="register_phone" pattern="[9][0-9]{9}" name="register_phone" required>
                </div>

                <!--Username-->
                <label for="register_username" class="fw-bold">Username:</label>
                <input type="text" class="form-control mt-1 border border-1 border-dark" name="register_username" id="register_username" placeholder="Enter Username" autocomplete="on" required>
                @error('register_username')
                    <span class="text-danger">{{ $message }}</span><br>
                @enderror

                <!--Password-->
                <label for="register_password" class="fw-bold mt-4">Password:</label>
                <input type="password" class="form-control mt-1 border border-1 border-dark" name="register_password" id="register_password" placeholder="********" autocomplete="off" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password must contain at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters long.">
                <div class="container d-flex mt-2">
                    <input type="checkbox" id="showPassword" class="me-2" onclick="showP()">
                    <label for="showPassword">Show Password</label>
                </div>
                @error('register_password')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <!--Confirm Password-->
                <label for="confirm_password" class="fw-bold mt-4">Confirm Password:</label>
                <input type="password" class="form-control mt-1 border border-1 border-dark" name="confirm_password" id="confirm_password" placeholder="********" autocomplete="off" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password must contain at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters long.">
                <div class="container d-flex mt-2">
                    <input type="checkbox" id="showConfirmPassword" class="me-2" onclick="showConfirm()">
                    <label for="showConfirmPassword">Show Password</label>
                </div>
                @error('confirm_password')
                    <p class="text-danger">{{$message}}</p>
                @enderror


                <div class="container-fluid d-flex justify-content-center mt-4">
                    <button class="btn btn-dark w-100">Next</button>
                </div>
            </form>
        </div>
    </div>

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