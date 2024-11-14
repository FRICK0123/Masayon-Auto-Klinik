<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/admin_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <!--Preloader-->
        <x-preloader/>
    <!--End-->
    <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Do you want to log out?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log out</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    <!--end-->

    <!--Header-->
        <header style="position: fixed; width: 100%; z-index: 100;">
            <x-admin-dashboard.header/>
        </header>
    <!--Header end-->

    <!--Main Content-->
    <main>
        <x-admin-dashboard.admin-content>
            <div class="container">
                <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
                    <h5 class="pt-2">MAINTENANCE OVERVIEW</h5>
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
                            <th>SCHEDULED DATE</th>
                            <th>SCHEDULED MILAGE</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

                        @php
                            $now = \Carbon\Carbon::now();
                        @endphp

                        @foreach ($schedules as $schedule)
                            @php
                                // Time-based logic
                                $scheduledDate = \Carbon\Carbon::parse($schedule->scheduled_date);
                                $isNearingDate = $scheduledDate->diffInDays($now) <= 7 && $scheduledDate >= $now;
                                $isOverdue = $scheduledDate->diffInDays($now) <= 7 && $scheduledDate < $now;

                                $lastTaskDate = \Carbon\Carbon::parse($schedule->last_maintenance_date);
                                $sendRegards = $lastTaskDate->diffInDays($now) >= 3;

                                // Mileage-based logic (for oil type maintenance)
                                $isNearingMileage = false;
                                if ($schedule->maintenance_type == 'Oil Change' || $schedule->maintenance_type == 'EGR Cleaning' || $schedule->maintenance_type == 'Basic PMS' || $schedule->maintenance_type == 'Full PMS') {
                                    $currentMileage = $schedule->current_milage;
                                    $nextMileage = $schedule->next_milage_schedule;

                                    // Check if the mileage has been reached or exceeded
                                    if ($currentMileage >= $nextMileage) {
                                        $isNearingMileage = true;
                                    }
                                }
                            @endphp
                            <!-- Highlight if either the time is nearing or mileage is reached -->
                            <tr @if($isNearingDate || $isNearingMileage || $isOverdue) class="table-danger"  @elseif($sendRegards && $schedule->isRegarded==false) class="table-warning" @endif>
                                <td>{{ $schedule->vehicle->customer->fullname }}</td>
                                <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</td>
                                <td>{{ $schedule->maintenance_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}</td>
                                
                                <!-- Show mileage if it's an oil type maintenance -->
                                @if ($schedule->maintenance_type == 'Oil Change' || $schedule->maintenance_type == 'EGR Cleaning' || $schedule->maintenance_type == 'Basic PMS' || $schedule->maintenance_type == 'Full PMS')
                                    <td>{{ $schedule->next_milage_schedule }} km
                                        @if($isNearingMileage)
                                            <span class="badge bg-danger">Mileage Reached!</span>
                                        @elseif($isNearingDate || $isOverdue)
                                            <span class="badge bg-danger">Schedule for Maintenance!</span>
                                        @elseif($sendRegards && $schedule->isRegarded == false)
                                            <span class="badge bg-danger">Send Regards</span>
                                        @endif
                                    </td>
                                @else
                                    <td>
                                        N/A
                                        @if($isNearingDate || $isOverdue)
                                            <span class="badge bg-danger">Schedule for Maintenance!</span>
                                        @elseif($sendRegards && $schedule->isRegarded == false)
                                            <span class="badge bg-danger">Send Regards</span>
                                        @endif
                                    </td>
                                @endif

                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#view_schedule"
                                        data-owner="{{ $schedule->vehicle->customer->fullname }}"
                                        data-vehicle="{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} {{ $schedule->vehicle->year_of_manufacture }}"
                                        data-maintenance-type="{{ $schedule->maintenance_type }}"
                                        data-pms-services="{{ $schedule->PMS_services }}"
                                        data-scheduled-date="{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}"
                                        data-last-maintenance-date="{{ \Carbon\Carbon::parse($schedule->last_maintenance_date)->format('F j, Y') }}"
                                        data-scheduled-interval="{{ $schedule->scheduled_interval }}"
                                        data-oil-type="{{ $schedule->oil_type }}"
                                        data-current-milage="{{ $schedule->vehicle->milage }}"
                                        data-next-milage-schedule="{{ $schedule->next_milage_schedule }}"
                                        onclick="populateModal(this)">
                                        <img src="{{ asset('icons/eye.svg') }}" alt="View" width="20">
                                    </button>
                                </td>

                                <td>
                                <div class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <img src="{{ asset('icons/bell-ringing.svg') }}" alt="Notify" width="20">
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#notify"
                                        data-customerID="{{ $schedule->vehicle->customer->customerID }}"
                                        data-vehicleID="{{ $schedule->vehicle->vehicleID }}"
                                        data-maintenanceID="{{ $schedule->maintenanceID }}"
                                        data-owner="{{ $schedule->vehicle->customer->fullname }}"
                                        data-vehicle="{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} {{ $schedule->vehicle->year_of_manufacture }}"
                                        data-maintenance-type="{{ $schedule->maintenance_type }}"
                                        data-scheduled-date="{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}"
                                        data-scheduled-date-orig="{{ $schedule->scheduled_date }}"
                                        onclick="notifyModal(this)">Notify Customer</a></li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sendRegardsModal"
                                        data-customerID="{{ $schedule->vehicle->customer->customerID }}"
                                        data-vehicleID="{{ $schedule->vehicle->vehicleID }}"
                                        data-maintenanceID="{{ $schedule->maintenanceID }}"
                                        data-owner="{{ $schedule->vehicle->customer->fullname }}"
                                        data-vehicle="{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} {{ $schedule->vehicle->year_of_manufacture }}"
                                        data-maintenance-type="{{ $schedule->maintenance_type }}"
                                        data-scheduled-date="{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}"
                                        data-scheduled-date-orig="{{ $schedule->scheduled_date }}"
                                        data-last-maintenance-date="{{ \Carbon\Carbon::parse($schedule->last_maintenance_date)->format('F j, Y') }}"
                                        onclick="sendRegards(this)">Send Regards</a>
                                        </li>
                                    </ul>
                                </div>
                                </td>

                                <td><button class="btn btn-danger btn-sm"><img src="{{ asset('icons/trash.svg') }}" alt="Delete" width="20" data-bs-toggle="modal" data-bs-target="#delete_maintenance" data-maintenanceID="{{ $schedule->maintenanceID }}" onclick="deleteModal(this)"></button></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!--End-->
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
                    <p id="owner"></p>
                    
                    <label class="fw-bold">Vehicle:</label>
                    <p id="vehicle"></p>

                    <label class="fw-bold">Maintenance Type:</label>
                    <p id="maintenance_type"></p>

                    <label class="fw-bold">PMS Services:</label>
                    <p id="pms_services"></p>

                    <label class="fw-bold">Scheduled Date:</label>
                    <p id="scheduled_date"></p>

                    <label class="fw-bold">Last Maintenance Date:</label>
                    <p id="last_maintenance_date"></p>

                    <label class="fw-bold">Schedule Interval:</label>
                    <p id="schedule_interval"></p>

                    <label class="fw-bold">Oil Type:</label>
                    <p id="oil_type"></p>

                    <label class="fw-bold">Current Mileage:</label>
                    <p id="current_milage"></p>

                    <label class="fw-bold">Next Mileage Schedule:</label>
                    <p id="next_milage_schedule"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
                </div>
            </div>
            </div>

            <!--Notify Customer Modal-->
            <div class="modal fade" id="notify" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Do you want to notify <span id="customer"></span>?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>From Masayon Auto Klinik</h3><br>
                        <p class="fw-bold">Notification Content:</p>
                        <p class="content">Good Day Sir/Ma'am <span id="contentCustomer" class="fw-bold"></span>, We would like to inform you that your <span id="vehicleContent" class="fw-bold"></span> is due for <span id="contentServiceType" class="fw-bold"></span> on <span id="contentDueDate" class="fw-bold"></span>. Please arrive within the scheduled date to keep your vehicle on top condition</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('notify_customer') }}" method="POST">
                            @csrf
                            <input type="hidden" id="input_customerID" name="customerID">
                            <input type="hidden" id="input_vehicleID" name="vehicleID">
                            <input type="hidden" id="input_maintenanceID" name="maintenanceID">
                            <input type="hidden" id="input_owner" name="owner">
                            <input type="hidden" id="input_vehicle" name="vehicle">
                            <input type="hidden" id="input_maintenance_type" name="maintenance_type">
                            <input type="hidden" id="input_scheduled_date" name="scheduled_date">
                            <input type="hidden" id="input_scheduled_date_orig" name="scheduled_date_orig">

                            <button type="submit" class="btn btn-warning">Notify</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <!--Delete Maintenance Modal-->
            <div class="modal fade" id="delete_maintenance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Do you want to delete this maintenance task</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>This will delete all the records and schedule associated with this task</p>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <form action="" method="post" id="delete_maintenance_form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Send Regards Modal-->
            <div class="modal fade" id="sendRegardsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Send Regards to <span id="regCustomer"></span></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Content: </h5><br>
                            <p class="content">"Hi <span id="regCustomerContent"></span>, we hope your <span id="regVehicle"></span> is running smoothly after the recent <span id="regServiceType"></span> on <span id="regServiceDate"></span>. If you have any questions or need further assistance, please reach out. Safe travels! - Masayon Auto Klinik"</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="{{ route('send_regards') }}" method="POST">
                                @csrf
                                <input type="hidden" id="reg_customerID" name="customerID">
                                <input type="hidden" id="reg_vehicleID" name="vehicleID">
                                <input type="hidden" id="reg_maintenanceID" name="maintenanceID">
                                <input type="hidden" id="reg_owner" name="owner">
                                <input type="hidden" id="reg_vehicle" name="vehicle">
                                <input type="hidden" id="reg_maintenance_type" name="maintenance_type">
                                <input type="hidden" id="reg_scheduled_date" name="scheduled_date">
                                <input type="hidden" id="reg_scheduled_date_orig" name="scheduled_date_orig">
                                <input type="hidden" id="reg_last_maintenance_date" name="last_maintenance_date">

                                <button type="submit" class="btn btn-warning">Send Regards</button>
                        </div>
                    </div>
                </div>
            </div>
        </x-admin-dashboard.admin-content>
    </main>
    <!--End-->

    <script>
        function populateModal(element){
            const owner = element.getAttribute('data-owner');
            const vehicle = element.getAttribute('data-vehicle');
            const maintenance_type = element.getAttribute('data-maintenance-type');
            const pms_services = element.getAttribute('data-pms-services');
            const scheduled_date = element.getAttribute('data-scheduled-date');
            const last_maintenance_date = element.getAttribute('data-last-maintenance-date');
            const schedule_interval = element.getAttribute('data-scheduled-interval');
            const oil_type = element.getAttribute('data-oil-type');
            const current_milage = element.getAttribute('data-current-milage');
            const next_milage_schedule = element.getAttribute('data-next-milage-schedule');

            document.getElementById('owner').innerHTML = owner;
            document.getElementById('vehicle').innerHTML = vehicle;
            document.getElementById('maintenance_type').innerHTML = maintenance_type;
            document.getElementById('pms_services').innerHTML = pms_services;
            document.getElementById('scheduled_date').innerHTML = scheduled_date;
            document.getElementById('last_maintenance_date').innerHTML = last_maintenance_date;
            document.getElementById('schedule_interval').innerHTML = schedule_interval;
            document.getElementById('oil_type').innerHTML = oil_type;
            document.getElementById('current_milage').innerHTML = current_milage;
            document.getElementById('next_milage_schedule').innerHTML = next_milage_schedule;

        }

        function notifyModal(element){
            const customerID = element.getAttribute('data-customerID');
            const vehicleID = element.getAttribute('data-vehicleID');
            const maintenanceID = element.getAttribute('data-maintenanceID');
            const owner = element.getAttribute('data-owner');
            const vehicle = element.getAttribute('data-vehicle');
            const maintenance_type = element.getAttribute('data-maintenance-type');
            const scheduled_date = element.getAttribute('data-scheduled-date');
            const scheduled_date_orig = element.getAttribute('data-scheduled-date-orig');

            //Content
            document.getElementById('customer').innerHTML = owner;
            document.getElementById('contentCustomer').innerHTML = owner;
            document.getElementById('vehicleContent').innerHTML = vehicle;
            document.getElementById('contentServiceType').innerHTML = maintenance_type;
            document.getElementById('contentDueDate').innerHTML = scheduled_date;

            //Input Value
            document.getElementById('input_customerID').value=customerID;
            document.getElementById('input_vehicleID').value=vehicleID;
            document.getElementById('input_maintenanceID').value=maintenanceID;
            document.getElementById('input_owner').value=owner;
            document.getElementById('input_vehicle').value=vehicle;
            document.getElementById('input_maintenance_type').value=maintenance_type;
            document.getElementById('input_scheduled_date').value=scheduled_date;
            document.getElementById('input_scheduled_date_orig').value=scheduled_date_orig;
        }

        function sendRegards(element){
            const customerID = element.getAttribute('data-customerID');
            const vehicleID = element.getAttribute('data-vehicleID');
            const maintenanceID = element.getAttribute('data-maintenanceID');
            const owner = element.getAttribute('data-owner');
            const vehicle = element.getAttribute('data-vehicle');
            const maintenance_type = element.getAttribute('data-maintenance-type');
            const scheduled_date = element.getAttribute('data-scheduled-date');
            const scheduled_date_orig = element.getAttribute('data-scheduled-date-orig');
            const last_maintenance_date = element.getAttribute('data-last-maintenance-date');

            document.getElementById('regCustomer').innerHTML=owner;
            document.getElementById('regCustomerContent').innerHTML=owner;
            document.getElementById('regVehicle').innerHTML=vehicle;
            document.getElementById('regServiceType').innerHTML=maintenance_type;
            document.getElementById('regServiceDate').innerHTML=last_maintenance_date;

            document.getElementById('reg_customerID').value=customerID;
            document.getElementById('reg_vehicleID').value=vehicleID;
            document.getElementById('reg_maintenanceID').value=maintenanceID;
            document.getElementById('reg_owner').value=owner;
            document.getElementById('reg_vehicle').value=vehicle;
            document.getElementById('reg_maintenance_type').value=maintenance_type;
            document.getElementById('reg_scheduled_date').value=scheduled_date;
            document.getElementById('reg_scheduled_date_orig').value=scheduled_date_orig;
            document.getElementById('reg_last_maintenance_date').value=last_maintenance_date;
        }

        function deleteModal(element){
            const maintenanceID = element.getAttribute('data-maintenanceID');

            document.getElementById('delete_maintenance_form').action=`/delete_maintenance/${maintenanceID}`;
        }
    </script>
</body>

</html>