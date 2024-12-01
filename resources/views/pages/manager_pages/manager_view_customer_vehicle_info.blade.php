<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/manager_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!--Preloader-->
        <x-preloader/>
    <!--End-->

    <!--Header-->
        <header>
            <x-manager-dashboard.header/>
        </header>
    <!--Header end-->
    
    <!--Main Content-->
        <main>            
            <x-manager-dashboard.manager-content>
                <div class="container-fluid ms-1 row border border-1 shadow rounded-3">
                    <div class="container pb-3 col-md-4">    
                        <a href="#" class="profile_img_wrapper mt-5">
                            <img src="{{ asset('Images/profile_images/'.$customer['profile_img']) }}" alt="Profile Image" class="profile_image">
                        </a>

                        <div class="profile_details mt-3">
                            <p><b>Full Name:</b> {{ $customer['fullname'] }}</p>
                            <p><b>Email Address:</b> {{ $customer['email'] }}</p>
                            <p><b>Phone Number:</b> +63{{ $customer['phone_number'] }}</p>
                            <a href="{{ route('manager_view_customer_info',$customer['customerID']) }}" class="btn btn-dark">Return</a>
                        </div>
                    </div>

                    <div class="col-md-8 pt-3 pt-lg-0">
                        <p><b>List of Cars</b></p>
                        <!-- Loop through the customer's vehicles -->
                        @foreach ($allVehicles as $allvehicle)
                            <div class="vehicle-item mb-3">
                                <a href="{{ route('manager_view_customer_vehicle_info', ['customerID' => $customer['customerID'], 'vehicleID' => $allvehicle['vehicleID']]) }}" class="btn btn-dark">
                                    <h6>{{ $allvehicle->make }} {{ $allvehicle->model }} ({{ $allvehicle->year_of_manufacture }})</h6>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="container p-3 border border-2 shadow rounded-3 mt-3" style="width: 98%" id="minor_details">
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
                        </div>
                    </div>
                </div>
                
                <div class="container mt-3">
                    <h4 class="text-dark">Previous Transactions</h4>
                    <div class="container">
                        <!-- Card-like table layout -->
                        @foreach ($previous_maintenance as $transaction)
                            <div class="card shadow-sm mt-2">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $transaction['vehicle'] }}</h4>
                                    <p class="card-text">
                                        <strong>Maintenance Type:</strong> {{ $transaction['maintenance_type'] }}<br>
                                        <strong>Service Date:</strong> {{ \Carbon\Carbon::parse($transaction['date_performed'])->format('F j, Y') }}<br>
                                        <strong>Status:</strong> {{$transaction['maintenance_status']}}<br>
                                        <strong>Cost:</strong> ₱{{number_format($transaction['cost'],2)}}<br>
                                    </p>
                                    <a href="#" class="btn btn-dark btn-sm rounded-pill">View Details</a>
                                </div>
                            </div>
                         @endforeach
                        <div class="mt-2">
                            {{ $previous_maintenance->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </x-manager-dashboard.manager-content>
        </main>
    <!--End-->
</body>
</html>