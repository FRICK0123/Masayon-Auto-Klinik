<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Image</title>
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

    <form action="{{ route('profile_upload') }}" method="POST" enctype="multipart/form-data" class="container d-flex flex-column justify-content-center align-items-center mt-5">
        @csrf
        <label for="profile_image">
            <div class="profile_image_wrapper">
                <img src="{{asset('Images/profile_images/default_user.png')}}" alt="User Profile Image" class="img-fluid user_image" id="user_image">
            </div>
        </label>

        <div class="mt-3 container">
            <input class="form-control" type="file" id="profile_image" accept=".jpg,.jpeg,.png" name="profile_image">
        </div>

        <div class="btn_wrapper">
            <button class="btn btn-dark mt-3 w-100">Set as Profile Image</button>
        </div>
    </form>

    <form action="{{ route('pending_view') }}" method="GET" class="container d-flex flex-column justify-content-center align-items-center">
        <div class="btn_wrapper">
            <button class="btn btn-light border border-1 border-dark mt-3 w-100">Skip</button>
        </div>
    </form>

    <script>
        document.getElementById('profile_image').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const fileType = file.type;
                const validImageTypes = ['image/jpeg', 'image/png'];

                if (!validImageTypes.includes(fileType)) {
                    alert('Only JPG and PNG files are allowed.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('user_image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>