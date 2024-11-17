<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/manager_dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/table_style.css')}}">
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
                        <form action="{{ route('manager_appointment') }}" method="GET" class="search-box me-2">
                            @csrf
                            {{-- <input type="text" class="form-control rounded-5" placeholder="Search Customers" name="search_customers" autocomplete="off"> --}}
                            <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Appointment" width="30"></button>
                            <input type="text" class="input-search" placeholder="Search Appointment" name="search_appointment">
                        </form>
                    </div>

                    <!--Functionalities-->
                    <div class="mb-3">
                        <form action="{{ route('manager_appointments_date_range') }}" method="GET" class="d-flex flex-column flex-md-row align-items-center gap-2">
                            <label for="start_date" class="form-label mb-0">Start Date:</label>
                            <input type="date" class="form-control me-2" name="start_date" required>

                            <label for="end_date" class="form-label mb-0">End Date:</label>
                            <input type="date" class="form-control me-2" name="end_date" required>

                            <button class="btn btn-dark">Filter</button>
                        </form>
                    </div>
                    <!--end-->

                    <!--Cars table-->
                    <div id="carTableContainer" class="table-responsive">
                        <table class="table">
                            <tr class="table-dark">
                                <th>OWNER</th>
                                <th>VEHICLE</th>
                                <th class="hide-mobile">MAINTENANCE TYPE</th>
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
                                    <td class="hide-mobile">{{ $schedule->maintenance_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->appointment_date)->format('F j, Y') }}</td>
                                    
                                    <td>
                                        <div class="dropdown" style="position: static;">
                                            <button class="btn btn-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#view_schedule"
                                                data-view-owner="{{ $schedule->vehicle->customer->fullname }}"
                                                data-view-vehicle="{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} {{ $schedule->vehicle->year_of_manufacture }}"
                                                data-view-maintenance-type="{{ $schedule->maintenance_type }}"
                                                data-view-pms-services="{{ $schedule->PMS_services }}"
                                                data-view-scheduled-date="{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}"
                                                data-view-last-maintenance-date="{{ \Carbon\Carbon::parse($schedule->last_maintenance_date)->format('F j, Y') }}"
                                                data-view-scheduled-interval="{{ $schedule->scheduled_interval }}"
                                                data-view-oil-type="{{ $schedule->oil_type }}"
                                                data-view-current-milage="{{ $schedule->vehicle->milage }}"
                                                data-view-next-milage-schedule="{{ $schedule->next_milage_schedule }}"
                                                onclick="populateModal(this)">View</a></li>

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
                                                <li><a class="dropdown-item" href="#" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#cancelModal"
                                                data-maintenance-id="{{ $schedule->maintenanceID }}"
                                                onclick="cancelFunc(this)">Delete Appointment</a></li>
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

            <!-- View Maintenance Schedule Modal -->
            <div class="modal fade" id="view_schedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Maintenance Schedule</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="fw-bold">Owner:</label>
                        <p id="view_owner"></p>
                                    
                        <label class="fw-bold">Vehicle:</label>
                        <p id="view_vehicle"></p>

                        <label class="fw-bold">Maintenance Type:</label>
                        <p id="view_maintenance_type"></p>

                        <label class="fw-bold">PMS Services:</label>
                        <p id="view_pms_services"></p>

                        <label class="fw-bold">Scheduled Date:</label>
                        <p id="view_scheduled_date"></p>

                        <label class="fw-bold">Last Maintenance Date:</label>
                        <p id="view_last_maintenance_date"></p>

                        <label class="fw-bold">Schedule Interval:</label>
                        <p id="view_schedule_interval"></p>

                        <label class="fw-bold">Oil Type:</label>
                        <p id="view_oil_type"></p>

                        <label class="fw-bold">Current Mileage:</label>
                        <p id="view_current_milage"></p>

                        <label class="fw-bold">Next Mileage Schedule:</label>
                        <p id="view_next_milage_schedule"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Schedule updated Toast Notification -->
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div id="scheduleUpdatedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success">
                        <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('schedule_updated') }}
                    </div>
                </div>
            </div>

            <!-- Appointment Cancelled Toast Notification -->
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div id="cancelToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success">
                        <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('cancel') }}
                    </div>
                </div>
            </div>

            <!-- Appointment Cancel Error Toast Notification -->
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div id="cancelErrorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-danger">
                        <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                </div>
            </div>

            <!--Cancel Appointment Modal -->
            <div class="modal fade" id="cancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5 text-light">Cancel this appointment?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to cancel this appointment?
                    </div>
                    <div class="modal-footer">
                        <form action="" id="cancelForm" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-dark">Yes</button>
                            <button type="button" class="btn border border-dark" data-bs-dismiss="modal">No</button>
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

            function populateModal(element){
                const owner = element.getAttribute('data-view-owner');
                const vehicle = element.getAttribute('data-view-vehicle');
                const maintenance_type = element.getAttribute('data-view-maintenance-type');
                const pms_services = element.getAttribute('data-view-pms-services');
                const scheduled_date = element.getAttribute('data-view-scheduled-date');
                const last_maintenance_date = element.getAttribute('data-view-last-maintenance-date');
                const schedule_interval = element.getAttribute('data-view-scheduled-interval');
                const oil_type = element.getAttribute('data-view-oil-type');
                const current_milage = element.getAttribute('data-view-current-milage');
                const next_milage_schedule = element.getAttribute('data-view-next-milage-schedule');

                document.getElementById('view_owner').innerHTML = owner;
                document.getElementById('view_vehicle').innerHTML = vehicle;
                document.getElementById('view_maintenance_type').innerHTML = maintenance_type;
                document.getElementById('view_pms_services').innerHTML = pms_services;
                document.getElementById('view_scheduled_date').innerHTML = scheduled_date;
                document.getElementById('view_last_maintenance_date').innerHTML = last_maintenance_date;
                document.getElementById('view_schedule_interval').innerHTML = schedule_interval + " months";
                document.getElementById('view_oil_type').innerHTML = oil_type;
                document.getElementById('view_current_milage').innerHTML = current_milage;
                document.getElementById('view_next_milage_schedule').innerHTML = next_milage_schedule;

            }

            function cancelFunc(element){
                const maintenanceID = element.getAttribute('data-maintenance-id');

                document.getElementById('cancelForm').action = `/appointment_cancelled/${maintenanceID}`;
            }

            @if (session('schedule_updated'))
                // Show the toast
                var toastEl = new bootstrap.Toast(document.getElementById('scheduleUpdatedToast'));
                toastEl.show();
            @endif

            @if (session('cancel'))
                // Show the toast
                var toastEl = new bootstrap.Toast(document.getElementById('cancelToast'));
                toastEl.show();
            @endif

            @if (session('error'))
                // Show the toast
                var toastEl = new bootstrap.Toast(document.getElementById('cancelErrorToast'));
                toastEl.show();
            @endif
        </script>
    <!--end-->
</body>
</html>