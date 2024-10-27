<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" href="{{asset('css/customer_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{asset('css/table_style.css')}}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
    <!--Preloader-->
        <x-preloader/>
    <!--End-->

    <!--Header-->
        <header>
            <x-customer-dashboard.navbar/>
        </header>
    <!--Header end-->

    <!--Main Content-->
        <main>
            <x-customer-dashboard.mobile-canvas/>

            <x-customer-dashboard.main-content>
                <div class="container ms-1 row">
                    <div class="container border border-1 shadow rounded-3 pb-3 col-md-4">    
                        <a href="#" class="profile_img_wrapper mt-5">
                            <img src="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" alt="Profile Image" class="profile_image">
                        </a>

                        <div class="profile_details mt-3 text-light">
                            <p><b>Full Name:</b> {{Session::get('fullname')}}</p>
                            <p><b>Email Address:</b> {{Session::get('email')}}</p>
                            <p><b>Phone Number:</b> +63{{Session::get('phone_number')}}</p>
                            <p><b>Username:</b> {{Session::get('username')}}</p>
                        </div>

                        <button class="btn btn-light">Edit Profile Details</button>
                    </div>

                    <div class="col-md-8 mt-3 mt-lg-0">
                        <h4 class="text-light">Previous Transactions</h4>
                        <div class="container">
                            <!-- Card-like table layout -->
                            @foreach ($transactions as $transaction)
                                <div class="card shadow-sm mt-2 bg-dark border border-light">
                                    <div class="card-body">
                                        <h4 class="card-title text-light">{{ $transaction['vehicle'] }}</h4>
                                        <p class="card-text text-light">
                                            <strong>Maintenance Type:</strong> {{ $transaction['maintenance_type'] }}<br>
                                            <strong>Service Date:</strong> Oct 20, 2024<br>
                                            <strong>Status:</strong> {{$transaction['maintenance_status']}}<br>
                                            <strong>Cost:</strong> ₱{{number_format($transaction['cost'],2)}}<br>
                                        </p>
                                        <a href="#" class="btn btn-light btn-sm rounded-pill">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-2">
                                {{ $transactions->appends(request()->input())->links() }}
                            </div>
                        </div>
                        <!--Transactions History table-->
                        {{-- <div class="table-responsive profile_history">
                            <table class="table table-striped mt-2 mt-md-0">
                                <tr>
                                    <th>VEHICLE</th>
                                    <th>MAINTENANCE TYPE</th>
                                    <th>COST</th>
                                    <th>DATE PERFORMED</th>
                                    <th></th>
                                </tr>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction['vehicle'] }}</td>
                                        <td>{{ $transaction['maintenance_type'] }}</td>
                                        <td>{{ $transaction['cost'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaction['date_performed'])->format('F j, Y') }}</td>
                                        <td><button class="btn btn-dark">View</button></td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $transactions->appends(request()->input())->links() }}
                        </div>
                        <!--End--> --}}
                    </div>
                </div>
            </x-customer-dashboard.main-content>
        </main>
    <!--End-->
</body>
</html>