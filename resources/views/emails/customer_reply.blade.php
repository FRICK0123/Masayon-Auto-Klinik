<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reply from {{ config('app.name') }}</title>
        <!--Bootstrap CDN Links-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
    <body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">

        <div class="container mt-5">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Reply from {{ config('app.name') }}</h4>
                </div>
                <div class="card-body p-4">
                    <p class="fw-bold">Dear {{ $customerName }},</p>

                    <p class="text-secondary">{{ $replyMessage }}</p>

                    <p class="mt-4">Best regards,</p>
                    <p class="fw-bold">{{ config('app.name') }} Team</p>
                </div>
                <div class="card-footer text-muted text-center">
                    <small>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</small>
                </div>
            </div>
        </div>

    </body>
</html>
