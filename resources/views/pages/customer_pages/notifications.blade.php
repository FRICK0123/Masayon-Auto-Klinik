<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schedule Maintenance</title>
    <link rel="stylesheet" href="{{asset('css/customer_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{asset('css/table_style.css')}}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="body">
    <!--Preloader-->
        <x-preloader/>
    <!--End-->

    <!--Header-->
        <header>
            <x-customer-dashboard.navbar/>
        </header>
    <!--Header end-->
    
    <!--Main Content-->
        <main class="pb-5">            
            <x-customer-dashboard.main-content>
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm mt-5 mt-lg-0">
                        <h5 class="pt-2">NOTIFICATIONS  </h5>
                    </div>

                    <br>

                    <div class="row">
                        <!-- Card 1 -->
                        @foreach ($notifications as $notification)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm border border-dark bg-light" id="card">
                                <div class="card-body">
                                <h4 class="card-title">{{ $notification['maintenance_type'] }} for {{ $notification['vehicle'] }}</h4>
                                
                                <p>{{ $notification['content'] }}</p>
                                @if ($notification['isConfirmed'] == false)
                                    <a href="{{ route('confirm_notification',$notification['notificationID']) }}" class="btn btn-success btn-sm">Confirm</a>
                                @else
                                    <a href="{{ route('unconfirm_notification',$notification['notificationID']) }}" class="btn btn-danger btn-sm">Unconfirm</a>
                                @endif
                                </div>

                                <span class="top"></span>
                                <span class="bottom"></span>
                                <span class="left"></span>
                                <span class="right"></span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </x-customer-dashboard.main-content>
        </main>
    <!--End-->

    <!--Footer-->
        <footer class="d-block d-md-none">
            <x-customer-dashboard.mobile-footer/>
        </footer>
    <!--end-->
</body>
</html>