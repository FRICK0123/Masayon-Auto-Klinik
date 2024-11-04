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
                <div class="container ms-1 row">
                    <div class="container border border-1 shadow rounded-3 pb-3 col-md-4">    
                        <a href="#" class="profile_img_wrapper mt-5">
                            <img src="{{ asset('Images/profile_images/'.$customer['profile_img']) }}" alt="Profile Image" class="profile_image">
                        </a>

                        <div class="profile_details mt-3">
                            <p><b>Full Name:</b> {{ $customer['fullname'] }}</p>
                            <p><b>Email Address:</b> {{ $customer['email'] }}</p>
                            <p><b>Phone Number:</b> +63{{ $customer['phone_number'] }}</p>
                            <p><b>Account Status:</b> 
                                @if ($customer['isVerified'] == true)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-danger">Not Verified</span>
                                @endif
                            </p>
                            <p><b>Username:</b> {{ $customer['username'] }}</p>
                        </div>

                        <button class="btn btn-dark">Edit Profile Details</button>
                    </div>

                    <div class="col-md-8 mt-3 mt-lg-0">
                    <!-- Accordion for Vehicles -->
                    <div class="accordion" id="vehiclesAccordion">
                        <h5>{{ $customer['fullname'] }} Vehicles</h5>
                        @foreach($vehicles as $index => $vehicle)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                    <h6>{{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->year_of_manufacture }})</h6>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#vehiclesAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{ asset('Images/car_images/' . $vehicle->vehicle_image) }}" alt="Vehicle Image" class="img-fluid">
                                        </div>
                                        <div class="col-md-8">
                                            <ul class="list-unstyled">
                                                <li><strong>Make:</strong> {{ $vehicle->make }}</li>
                                                <li><strong>Model:</strong> {{ $vehicle->model }}</li>
                                                <li><strong>Year of Manufacture:</strong> {{ $vehicle->year_of_manufacture }}</li>
                                                <li><strong>Mileage:</strong> {{ number_format($vehicle->milage) }} km</li>
                                                <li><strong>Engine Number:</strong> {{ $vehicle->engine_number }}</li>
                                                <li><strong>VIN:</strong> {{ $vehicle->vehicle_identification_number }}</li>
                                                <li><strong>Chassis Number:</strong> {{ $vehicle->chassis_number }}</li>
                                                <li><strong>Plate Number:</strong> {{ $vehicle->plate_number }}</li>
                                                <li><strong>Engine Type:</strong> {{ $vehicle->engine_type }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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