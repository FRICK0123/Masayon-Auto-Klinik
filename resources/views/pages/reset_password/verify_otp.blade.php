<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4">Verify Your OTP</h2>

            <form action="{{ route('verify_otp') }}" method="POST">
                @csrf
                
                <!-- OTP Input -->
                <div class="mb-3">
                    <label for="otp" class="form-label fw-bold">Enter the OTP sent to your email:</label>
                    <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP" required>
                </div>

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger py-2 mt-2" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-dark">Verify</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
