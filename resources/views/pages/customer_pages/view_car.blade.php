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
                                <p>{{ $vehicle['milage'] }} km</p>
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

                                    <div class="col-md-6 mt-3">
                                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteVehicleModal"
                                        data-vehicleID="{{ $vehicle['vehicleID'] }}"
                                        data-vehicle="{{ $vehicle['make'] }} {{ $vehicle['model'] }} {{ $vehicle['year_of_manufacture'] }}"
                                        onclick="deleteModal(this)">Delete Car</button>
                                    </div>
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
                                    <a href="#" class="btn btn-light btn-sm rounded-pill"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#view_transaction"
                                        data-owner="{{ $transaction['owner'] }}"
                                        data-vehicle="{{ $transaction['vehicle'] }}"
                                        data-previous-milage="{{ $transaction['previous_milage'] }}"
                                        data-current-milage="{{ $transaction['current_milage'] }}"
                                        data-maintenance-type="{{ $transaction['maintenance_type'] }}"
                                        data-oil-type="{{ $transaction['oil_type'] }}"
                                        data-pms-services="{{ $transaction['pms_services'] }}"
                                        data-cost="{{ $transaction['cost'] }}"
                                        data-date-performed="{{ \Carbon\Carbon::parse($transaction->date_performed)->format('F j, Y') }}"
                                        data-maintenance-description="{{ $transaction['maintenance_description'] }}"
                                        onclick="populateModal(this)">View Details</a>
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

    <!--View Transaction-->
    <div class="modal fade" id="view_transaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="fw-bold">Owner:</label>
                <p id="owner"></p>

                <label class="fw-bold">Vehicle:</label>
                <p id="vehicle"></p>

                <label class="fw-bold">Previous Mileage:</label>
                <p id="previous_milage"></p>

                <label class="fw-bold">Current Mileage:</label>
                <p id="current_milage"></p>

                <label class="fw-bold">Maintenance Type:</label>
                <p id="maintenance_type"></p>

                <label class="fw-bold" id="oil_type_label">Oil Type:</label>
                <p id="oil_type"></p>

                <label class="fw-bold" id="pms_label">PMS Services:</label>
                <p id="pms_services"></p>


                <label class="fw-bold">Cost:</label>
                <p id="cost"></p>

                <label class="fw-bold">Date Performed:</label>
                <p id="date_performed"></p>

                <label class="fw-bold">Maintenance Description:</label>
                <p id="maintenance_description"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>  
    </div>

    <!-- Delete Vehicle Modal -->
    <div class="modal fade" id="deleteVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5 text-light">Are you sure you want to delete <span id="vehicleModal"></span> ?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Any existing appointments and schedules related with this vehicle will also be deleted! </p>
            </div>
            <div class="modal-footer">
                <form action="" method="post" id="deleteVehicleForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        function populateModal(element){
            const owner = element.getAttribute('data-owner');
            const vehicle = element.getAttribute('data-vehicle');
            const previous_milage = element.getAttribute('data-previous-milage');
            const current_milage = element.getAttribute('data-current-milage');
            const maintenance_type = element.getAttribute('data-maintenance-type');
            const oil_type = element.getAttribute('data-oil-type');
            const pms_services = element.getAttribute('data-pms-services');
            const cost = element.getAttribute('data-cost');
            const date_performed = element.getAttribute('data-date-performed');
            const maintenance_description = element.getAttribute('data-maintenance-description');

            document.getElementById('owner').innerHTML = owner;
            document.getElementById('vehicle').innerHTML = vehicle;
            document.getElementById('previous_milage').innerHTML = previous_milage;
            document.getElementById('current_milage').innerHTML = current_milage;
            document.getElementById('maintenance_type').innerHTML = maintenance_type;
            if(oil_type == ""){
                document.getElementById('oil_type_label').style.display = "none";
            }else{
                document.getElementById('oil_type_label').style.display = "block";
            }

            if(pms_services == ""){
                document.getElementById('pms_label').style.display = "none";
            }else{
                document.getElementById('pms_label').style.display = "block";
            }
            document.getElementById('oil_type').innerHTML = oil_type;
            document.getElementById('pms_services').innerHTML = pms_services;
            document.getElementById('cost').innerHTML = `₱ ${cost}`;
            document.getElementById('date_performed').innerHTML = date_performed;
            document.getElementById('maintenance_description').innerHTML = maintenance_description;
        }

        function deleteModal(element){
            const vehicleID = element.getAttribute('data-vehicleID');
            const vehicle = element.getAttribute('data-vehicle');

            document.getElementById('deleteVehicleForm').action = `/delete_car/${vehicleID}`;
            document.getElementById('vehicleModal').innerHTML = vehicle;
        }
    </script>
</body>
</html>