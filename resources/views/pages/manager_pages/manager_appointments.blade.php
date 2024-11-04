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
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
                        <h5 class="pt-2">Appointments</h5>
                        <form action="{{ route('admin_appointment_view') }}" method="GET" class="search-box me-2">
                            @csrf
                            {{-- <input type="text" class="form-control rounded-5" placeholder="Search Customers" name="search_customers" autocomplete="off"> --}}
                            <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Appointment" width="30"></button>
                            <input type="text" class="input-search" placeholder="Search Appointment" name="search_appointment">
                        </form>
                    </div>

                    <!--Functionalities-->
                        <div class="d-flex justify-content-between">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset('icons/funnel.svg')}}" alt="Filter">
                                </button>
                                {{-- <form id="carFilterForm" action="{{ route('car_filter') }}" method="GET" class="dropdown-menu p-2">
                                    <input type="radio" id="by_make" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_make">
                                    <label for="by_make" class="ms-2">By Make</label><br><br>

                                    <input type="radio" id="by_model" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_model">
                                    <label for="by_model" class="ms-2">By Model</label><br><br>

                                    <input type="radio" id="by_year" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_year">
                                    <label for="by_year" class="ms-2">By Year</label><br><br>

                                    <button type="submit" class="btn btn-dark">Filter</button>
                                </form> --}}
                            </div>
                        </div>
                    <!--end-->

                    <!--Cars table-->
                    <div id="carTableContainer">
                        <table class="table table-striped table-responsive">
                            <tr>
                                <th>OWNER</th>
                                <th>VEHICLE</th>
                                <th>MAINTENANCE TYPE</th>
                                <th>Appointment Date</th>
                                <th></th>
                            </tr>

                            @php
                                $now = \Carbon\Carbon::now();
                            @endphp

                            @foreach ($schedules as $schedule)
                                <!-- Highlight if either the time is nearing or mileage is reached -->
                                <tr>
                                    <td>{{ $schedule->vehicle->customer->fullname }}</td>
                                    <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</td>
                                    <td>{{ $schedule->maintenance_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->appointment_date)->format('F j, Y') }}</td>
                                    
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">View</a></li>
                                                <li><a class="dropdown-item" href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#update"
                                                    data-maintenance-id="{{ $schedule->maintenanceID }}"
                                                    data-vehicle-id="{{ $schedule->vehicle->vehicleID }}"
                                                    data-customer-id="{{ $schedule->vehicle->customer->customerID }}"
                                                    data-owner="{{ $schedule->vehicle->customer->fullname }}"
                                                    data-vehicle="{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} {{ $schedule->vehicle->year_of_manufacture }}"
                                                    data-previous-milage="{{ $schedule->vehicle->milage }}"
                                                    data-maintenance-type="{{ $schedule->maintenance_type }}"
                                                    data-oil-type="{{ $schedule->oil_type }}"
                                                    data-scheduled-interval="{{ $schedule->scheduled_interval }}"
                                                    onclick="fillData(this)">
                                                        Confirm Appointment
                                                    </a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Delete Appointment</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <!--End-->
                </div>

            <!-- Modal -->
            <div class="modal fade" id="update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirm Appointment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('appointment_update') }}" method="post">
                        @csrf
                        <label for="current_milage" class="fw-bold">Enter Current Mileage:</label>
                        <input type="number" placeholder="miles" class="form-control" id="current_milage" name="current_milage"><br><br>

                        <label for="cost" class="fw-bold">Enter Maintenance Cost:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">₱</span>
                            <input type="number" class="form-control" name="cost" id="cost">
                        </div><br>

                        <label for="maintenance_description" class="form-label fw-bold">Enter Maintenance Description</label>
                        <textarea class="form-control" id="maintenance_description" rows="3" name="maintenance_description"></textarea><br><br>

                        <input type="hidden" id="maintenance_id" name="maintenance_id">
                        <input type="hidden" id="vehicle_id" name="vehicle_id">
                        <input type="hidden" id="customer_id" name="customer_id">
                        <input type="hidden" id="owner" name="owner">
                        <input type="hidden" id="vehicle" name="vehicle">
                        <input type="hidden" id="previous_milage" name="previous_milage">
                        <input type="hidden" id="maintenance_type" name="maintenance_type">
                        <input type="hidden" id="scheduled_interval" name="scheduled_interval">
                        <input type="hidden" id="oil_type" name="oil_type">

                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Mark as Completed</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
            </x-manager-dashboard.manager-content>
        </main>
    <!--End-->
    <!--Javascript-->
        <script>
            function fillData(element){
                //get data from link
                const maintenance_id = element.getAttribute('data-maintenance-id');
                const vehicle_id = element.getAttribute('data-vehicle-id');
                const customer_id = element.getAttribute('data-customer-id');
                const owner = element.getAttribute('data-owner');
                const vehicle = element.getAttribute('data-vehicle');
                const previous_milage = element.getAttribute('data-previous-milage');
                const maintenance_type = element.getAttribute('data-maintenance-type');
                const scheduled_interval = element.getAttribute('data-scheduled-interval');
                const oil_type = element.getAttribute('data-oil-type');

                //fill input values
                document.getElementById('maintenance_id').value = maintenance_id;
                document.getElementById('vehicle_id').value = vehicle_id;
                document.getElementById('customer_id').value = customer_id;
                document.getElementById('owner').value = owner;
                document.getElementById('vehicle').value = vehicle;
                document.getElementById('previous_milage').value = previous_milage;
                document.getElementById('maintenance_type').value = maintenance_type;
                document.getElementById('scheduled_interval').value = scheduled_interval;
                document.getElementById('oil_type').value = oil_type;
            }
        </script>
    <!--end-->
</body>
</html>