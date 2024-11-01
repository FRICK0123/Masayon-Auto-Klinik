<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $vehicle['model'] }}</title>
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
        <main>            
            <x-customer-dashboard.main-content>
                <div class="container p-3 border border-2 shadow rounded-3" style="width: 98%" id="minor_details">
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="view_car_wrapper">
                                <img src="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}" alt="Car Image" id="car_image" class="view_car_image">
                            </div>
                        </div>

                        <div class="col-md-6 mt-2 text-dark">
                            <h2>{{$vehicle['make']}} {{$vehicle['model']}} {{$vehicle['year_of_manufacture']}}</h2>
                            <div class="d-flex">
                                <label class="fw-bold">Current Mileage: &nbsp;</label>
                                <p>{{ $vehicle['milage'] }} mi</p>
                            </div>

                            <div class="d-flex">
                                <label class="fw-bold">Engine Number: &nbsp;</label>
                                <p>{{ $vehicle['engine_number'] }}</p>
                            </div>

                            <div class="d-flex">
                                <label class="fw-bold">VIN: &nbsp;</label>
                                <p>{{ $vehicle['vehicle_identification_number'] }}</p>
                            </div>

                            <div class="d-flex">
                                <label class="fw-bold">Chassis Number: &nbsp;</label>
                                <p>{{ $vehicle['chassis_number'] }}</p>
                            </div>

                            <div class="d-flex">
                                <label class="fw-bold">Plate Number: &nbsp;</label>
                                <p>{{ $vehicle['plate_number'] }}</p>
                            </div>

                            <div class="d-flex">
                                <label class="fw-bold">Engine Type: &nbsp;</label>
                                <p>{{ $vehicle['engine_type'] }} mi</p>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <form action="{{ route('schedule_maintenance_form',$vehicle['vehicleID']) }}" method="GET" class="col-md-6 mt-3">
                                        @csrf
                                        <button class="btn btn-dark w-100">Appointment</button>
                                    </form>

                                    <form action="#" method="POST" class="col-md-6 mt-3">
                                        @csrf
                                        <button class="btn btn-danger w-100">Delete Car</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Transactions History table-->
                <div class="container mt-4">
                    <h5 class="text-dark">Previous Transactions</h5>
                    <div class="container">
                        <!-- Card-like table layout -->
                        @foreach ($transactions as $transaction)
                            <div class="card shadow-sm mt-2 bg-dark border border-light" id="card">
                                <div class="card-body">
                                    <h4 class="card-title text-light">{{ $transaction['vehicle'] }}</h4>
                                    <p class="card-text text-light">
                                        <strong>Maintenance Type:</strong> {{ $transaction['maintenance_type'] }}<br>
                                        <strong>Service Date:</strong> {{ \Carbon\Carbon::parse($transaction['date_performed'])->format('F j, Y') }}<br>
                                        <strong>Status:</strong> {{$transaction['maintenance_status']}}<br>
                                        <strong>Cost:</strong> ₱{{number_format($transaction['cost'],2)}}<br>
                                    </p>
                                    <a href="#" class="btn btn-light btn-sm rounded-pill">View Details</a>
                                </div>
                                <span class="top"></span>
                                <span class="bottom"></span>
                                <span class="right"></span>
                                <span class="left"></span>
                            </div>
                        @endforeach
                        <div class="mt-2">
                            {{ $transactions->appends(request()->input())->links() }}
                        </div>
                    </div>
                <!--End-->
            </x-customer-dashboard.main-content>
        </main>
    <!--End-->
</body>
</html>