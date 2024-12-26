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
    <style>
        .notification-item {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            transition: background-color 0.2s;
        }
        .notification-item:hover {
            background-color: #e9ecef;
        }
        .notification-item .card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .notification-actions {
            margin-top: 10px;
        }
    </style>
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
                        <h5 class="pt-2">NOTIFICATIONS</h5>
                    </div>

                    <br>

                    <div class="notifications-list">
                        @foreach ($notifications as $notification)
                        <div class="notification-item shadow-sm">
                            <h4 class="card-title">{{ $notification['maintenance_type'] }} for {{ $notification['vehicle'] }}</h4>
                            <p>{{ $notification['content'] }}</p>
                            <div class="notification-actions">
                                @if ($notification['isConfirmed'] == false)
                                    <a href="{{ route('confirm_notification', $notification['notificationID']) }}" class="btn btn-success btn-sm">Confirm</a>
                                @else
                                    <a href="{{ route('unconfirm_notification', $notification['notificationID']) }}" class="btn btn-danger btn-sm">Unconfirm</a>
                                @endif
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
