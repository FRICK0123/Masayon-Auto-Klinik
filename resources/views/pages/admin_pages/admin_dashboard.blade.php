<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/admin_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{asset('css/table_style.css')}}">

    <!-- Include the necessary Larapex Charts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
            <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#admin_mobile_canvas">
                <img src="{{ asset('icons/list.svg') }}" alt="Sidebar">
            </button>
            <x-admin-dashboard.mobile-canvas/>

            <div class="container-fluid row">
                <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm border mt-4 mt-lg-0">
                    <h5 class="pt-2">DASHBOARD</h5>
                </div>

                <!-- CUSTOMER COUNT CARD -->
                <a href="{{ route('users_view') }}" class="col-md-3 text-dark" style="text-decoration: none;">
                    <div class="border border-success rounded-3 mt-3 summary_cards p-3 customer_card_link" style="height: 160px; width: 100%;">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('icons/users.svg') }}" alt="Customers" width="30" height="30">
                            <h5 class="boxes_label ms-2 fw-bold">CUSTOMERS</h5>
                        </div><br>
                        <!-- Adjusted flexbox to handle large customer count -->
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 id="customerCount">{{ $customerCount }}</h2>
                            <img src="{{ asset('chart.png') }}" alt="Customers" class="box_chart">
                        </div>
                    </div>
                </a>

                <!-- VEHICLE COUNT CARD -->
                <a href="{{ route('customer_vehicles_view') }}" class="col-md-3" style="text-decoration: none;">
                    <div class="border border-secondary rounded-3 mt-3 summary_cards p-3 customer_cars_card_link" style="height: 160px; width: 100%;">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('icons/car.svg') }}" alt="Customers" width="30" height="30">
                            <h6 class="boxes_label ms-2 fw-bold">CUSTOMER CARS</h6>
                        </div><br>
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 id="vehicleCount">{{ $vehicleCount }}</h2>
                            <img src="{{ asset('chart.png') }}" alt="Vehicle Count" class="box_chart">
                        </div>
                    </div>
                </a>

                <!-- MAINTENANCE TASKS CARD -->
                <a href="{{ route('maintenance_overview') }}" class="col-md-3" style="text-decoration: none;">
                    <div class="border border-danger rounded-3 mt-3 summary_cards p-3 maintenance_task_link" style="height: 160px; width: 100%;">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('icons/gear-fine.svg') }}" alt="Maintenance Tasks" width="30" height="30">
                            <h5 class="boxes_label ms-2 fw-bold">MAINTENANCE TASKS</h5>
                        </div><br>
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 id="scheduleCount">{{ $scheduleCount }}</h2>
                            <img src="{{ asset('chart.png') }}" alt="Vehicle Count" class="box_chart">
                        </div>
                    </div>
                </a>

                <!-- NOTIFICATIONS SENT CARD -->
                <a href="{{ route('notification_view') }}" class="col-md-3" style="text-decoration: none;">
                    <div class="border border-warning rounded-3 mt-3 summary_cards p-3 notification_link" style="height: 160px; width: 100%;">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('icons/bell-ringing.svg') }}" alt="Notifications Sent" width="30" height="30">
                            <h5 class="boxes_label ms-2 fw-bold">NOTIFICATIONS SENT</h5>
                        </div><br>
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 id="notificationCount">{{ $notificationCount }}</h2>
                            <img src="{{ asset('chart.png') }}" alt="Notifications Sent" class="box_chart">
                        </div>
                    </div>
                </a>
            </div>
            <br><br>

            <!--Charts-->
            <div class="container">
                <!-- Monthly Transactions Chart -->
                <h4>Monthly Transaction History</h4>
                {!! $monthlyChart->container() !!}
            </div>

            <div class="container">
                <!-- Yearly Transactions Chart -->
                <h4>Yearly Transaction History</h4>
                {!! $yearlyChart->container() !!}
            </div>
            
            <!-- Include the script for the charts -->
            {!! $monthlyChart->script() !!}
            {!! $yearlyChart->script() !!}

            <div class="container table-responsive">
                <h5>Upcoming Maintenance Tasks:</h5>
                @if ($schedules->isEmpty())
                    <div class="container-fluid d-flex flex-column justify-content-center align-items-center" style="width: 100%; height:270px; opacity: 60%;">
                        <img src="{{ asset('icons/gear-fine.svg') }}" alt="No Maintenance Tasks for today" width="100">
                        <h6>No Maintenance Task/s for today</h6>
                    </div>
                @else
                <!--Upcoming Maintenance table-->
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>VEHICLE</th>
                                    <th>OWNER</th>
                                    <th>MAINTENANCE TYPE</th>
                                    <th>SCHEDULED DATE</th>
                                    <th>SCHEDULED MILAGE</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach ($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</td>
                                <td>{{ $schedule->vehicle->customer->fullname }}</td>
                                <td>{{ $schedule->maintenance_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}</td>
                                <td>{{ $schedule->next_milage_schedule }}</td>
                            </tr>
                            @endforeach
                        </table>
                    <!--End-->
                @endif
            </div>

            <div class="container table-responsive">
                <div class="d-flex justify-content-between">
                    @php
                        $customer_registration_daily_count = $customer_daily_registration->count();
                        $customer_registration_weekly_count = $customer_weekly_registration->count();      
                    @endphp
                    <h5 id="customer_daily_count" style="display: block;">Customer Registration: {{ $customer_registration_daily_count }}</h5>
                    <h5 id="customer_weekly_count" style="display: none;">Customer Registration: {{ $customer_registration_weekly_count }}</h5>

                    <div>
                        <button class="btn btn-sm rounded-pill me-2 btn_active" id="day_btn" style="background-color: rgb(214, 1, 1); color: white;">This Day</button>
                        <button class="btn btn-sm rounded-pill btn_inactive" id="week_btn" style="border: 1px solid black">This Week</button>
                    </div>
                </div>
                    <table class="table mt-2" id="customer_daily_table" style="display: table">
                        @if($customer_daily_registration->isEmpty())
                            <div class="container-fluid" style="width: 100%; height:270px; opacity: 60%; display:flex; flex-direction:column; justify-content:center; align-items:center;" id="customer_daily_empty">
                                <img src="{{ asset('icons/gear-fine.svg') }}" alt="No Maintenance Tasks for today" width="100">
                                <h6>No customer registration for today</h6>
                            </div>
                        @else
                            <thead class="table-dark">
                                <tr>
                                    <th>USERS</th>
                                    <th>CONTACT #</th>
                                    <th>USERNAME</th>
                                    <th>STATUS</th>
                                    <th>DATE REGISTERED</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer_daily_registration as $user)
                                    <tr>
                                        <td class="d-flex">
                                            @php
                                                $lastSeen = \Carbon\Carbon::parse($user['last_seen']);
                                                $isOnline = $lastSeen->diffInMinutes(now()) <= 3; // Check if last seen is within 3 minutes
                                            @endphp

                                            @if ($isOnline)
                                                <small><img src="{{ asset('icons/online_dot.png') }}" alt="Online" width="15"></small>
                                            @else
                                                <small><img src="{{ asset('icons/offline_dot.png') }}" alt="Online" width="10"></small>
                                            @endif
                                                
                                            <img src="{{ asset('Images/profile_images/'.$user['profile_img']) }}" alt="Profile Icon" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
                                            <div class="d-flex flex-column ms-3">
                                                <span>{{ $user['fullname'] }}</span>
                                                <span style="font-size: 13px">{{ $user['email'] }}</span>
                                            </div>
                                        </td>
                                        <td>0{{ $user['phone_number'] }}</td>
                                        <td>{{ $user['username'] }}</td>
                                        @if ($user['isVerified'] == 1 && $user['email_verified_at'] !== null)
                                            <td><span class="badge bg-success p-2">verified</span></td>
                                        @elseif($user['isVerified'] == 0 && $user['email_verified_at'] == null)
                                            <td><span class="badge bg-danger p-2">deactivated</span></td>
                                        @else
                                            <td>not verified</td>
                                        @endif
                                        <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('F j, Y') }}</td>

                                        <td>
                                            <div class="dropdown" style="position: static">
                                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('view_user_info',$user['customerID']) }}">View</a></li>

                                                    <li><a class="dropdown-item" href="{{ route('add_vehicle_view',$user['customerID']) }}">Add Vehicle</a></li>

                                                    <li><a class="dropdown-item" href="{{ route('view_user_vehicle_info', $user['customerID']) }}">Add Maintenance Schedule</a></li>

                                                    <li><a class="dropdown-item" href="{{ route('edit_user_info_view',$user['customerID']) }}">Edit</a></li>

                                                    <li>
                                                        @if ($user['isVerified'] == 1 && $user['email_verified_at'] !== null)
                                                            <a class="dropdown-item bg-danger text-light" href="#">Deactivate</a>
                                                        @else
                                                            <a class="dropdown-item bg-success text-light" href="#">Activate</a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>   

                <table class="table mt-2" id="customer_weekly_table" style="display: none">
                    @if ($customer_weekly_registration->isEmpty())
                         <div class="container-fluid" style="width: 100%; height:270px; opacity: 60%; display:none; flex-direction:column; justify-content:center; align-items:center;" id="customer_weekly_empty">
                            <img src="{{ asset('icons/gear-fine.svg') }}" alt="No Maintenance Tasks for today" width="100">
                            <h6>No customer registration for this week</h6>
                        </div>
                    @else
                        <thead class="table-dark">
                                <tr>
                                    <th>USERS</th>
                                    <th>CONTACT #</th>
                                    <th>USERNAME</th>
                                    <th>STATUS</th>
                                    <th>DATE REGISTERED</th>
                                    <th></th>
                                </tr>
                        </thead>
                        <tbody>
                                @foreach ($customer_weekly_registration as $user)
                                    <tr>
                                        <td class="d-flex">
                                            @php
                                                $lastSeen = \Carbon\Carbon::parse($user['last_seen']);
                                                $isOnline = $lastSeen->diffInMinutes(now()) <= 3; // Check if last seen is within 3 minutes
                                            @endphp

                                            @if ($isOnline)
                                                <small><img src="{{ asset('icons/online_dot.png') }}" alt="Online" width="15"></small>
                                            @else
                                                <small><img src="{{ asset('icons/offline_dot.png') }}" alt="Online" width="10"></small>
                                            @endif
                                                
                                            <img src="{{ asset('Images/profile_images/'.$user['profile_img']) }}" alt="Profile Icon" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
                                            <div class="d-flex flex-column ms-3">
                                                <span>{{ $user['fullname'] }}</span>
                                                <span style="font-size: 13px">{{ $user['email'] }}</span>
                                            </div>
                                        </td>
                                        <td>0{{ $user['phone_number'] }}</td>
                                        <td>{{ $user['username'] }}</td>

                                        @if ($user['isDeactivated'] == true)
                                            <td><span class="badge bg-danger p-2">Deactivated</span></td>
                                        @elseif($user['isDeactivated'] == false && $user['isVerified'] == true)
                                            <td><span class="badge bg-success p-2">Verified</span></td>
                                        @else
                                            <td>Not Verified</td>
                                        @endif

                                        <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('F j, Y') }}</td>

                                        <td>
                                            <div class="dropdown" style="position: static">
                                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('view_user_info',$user['customerID']) }}">View</a></li>

                                                    <li><a class="dropdown-item" href="{{ route('add_vehicle_view',$user['customerID']) }}">Add Vehicle</a></li>

                                                    <li><a class="dropdown-item" href="{{ route('view_user_vehicle_info', $user['customerID']) }}">Add Maintenance Schedule</a></li>

                                                    <li><a class="dropdown-item" href="{{ route('edit_user_info_view',$user['customerID']) }}">Edit</a></li>

                                                    <li>
                                                        @if ($user['isVerified'] == 1 && $user['email_verified_at'] !== null)
                                                            <a class="dropdown-item bg-danger text-light" href="#">Deactivate</a>
                                                        @else
                                                            <a class="dropdown-item bg-success text-light" href="#">Activate</a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    @endif 
                </table>
            </div>

            <!--Customer Transactions-->
            <div class="container table-responsive">
                <div class="d-flex justify-content-between">
                    @php
                        $customer_transaction_daily_count = $customer_daily_transaction->count();
                        $customer_transaction_weekly_count = $customer_weekly_transaction->count();      
                    @endphp
                    <h5 id="customer_daily_transaction_count" style="display: block;">Customer Transactions: {{ $customer_transaction_daily_count }}</h5>
                    <h5 id="customer_weekly_transaction_count" style="display: none;">Customer Transactions: {{ $customer_transaction_weekly_count }}</h5>

                    <div>
                        <button class="btn btn-sm rounded-pill me-2 btn_active" id="day_transaction_btn" style="background-color: rgb(214, 1, 1); color: white;">This Day</button>
                        <button class="btn btn-sm rounded-pill btn_inactive" id="week_transaction_btn" style="border: 1px solid black">This Week</button>
                    </div>
                </div>
                    <table class="table mt-2" id="customer_daily_transaction_table" style="display: table">
                        @if($customer_daily_transaction->isEmpty())
                            <div class="container-fluid" style="width: 100%; height:270px; opacity: 60%; display:flex; flex-direction:column; justify-content:center; align-items:center;" id="customer_daily_transaction_empty">
                                <img src="{{ asset('icons/gear-fine.svg') }}" alt="No Customer Transaction for today" width="100">
                                <h6>No customer transaction for today</h6>
                            </div>
                        @else
                            <thead class="table-dark">
                                <tr>
                                    <th>VEHICLE</th>
                                    <th>OWNER</th>
                                    <th>MAINTENANCE TYPE</th>
                                    <th>COST</th>
                                    <th>DATE PERFORMED</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer_daily_transaction as $item)
                                    <tr>
                                        <td>{{ $item->vehicle }}</td>
                                        <td>{{ $item->owner }}</td>
                                        <td>{{ $item->maintenance_type }}</td>
                                        <td>₱{{ number_format($item->cost, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}</td>
                                        <td>
                                            <button class="btn btn-dark btn-sm rounded-pill" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#view_transaction"
                                            data-owner="{{ $item['owner'] }}"
                                            data-vehicle="{{ $item['vehicle'] }}"
                                            data-previous-milage="{{ $item['previous_milage'] }}"
                                            data-current-milage="{{ $item['current_milage'] }}"
                                            data-maintenance-type="{{ $item['maintenance_type'] }}"
                                            data-oil-type="{{ $item['oil_type'] }}"
                                            data-pms-services="{{ $item['pms_services'] }}"
                                            data-cost="{{ $item['cost'] }}"
                                            data-date-performed="{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}"
                                            data-maintenance-description="{{ $item['maintenance_description'] }}"
                                            onclick="populateModal(this)">View</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>   

                <table class="table mt-2" id="customer_weekly_transaction_table" style="display: none">
                    @if ($customer_weekly_transaction->isEmpty())
                         <div class="container-fluid" style="width: 100%; height:270px; opacity: 60%; display:none; flex-direction:column; justify-content:center; align-items:center;" id="customer_weekly_transaction_empty">
                            <img src="{{ asset('icons/gear-fine.svg') }}" alt="No Customer Transaction This Week" width="100">
                            <h6>No customer transaction for this week</h6>
                        </div>
                    @else
                        <thead class="table-dark">
                            <tr>
                                <th>VEHICLE</th>
                                <th>OWNER</th>
                                <th>MAINTENANCE TYPE</th>
                                <th>COST</th>
                                <th>DATE PERFORMED</th>
                                <th></th>
                            </tr>
                        </thead>
                            <tbody>
                                @foreach ($customer_weekly_transaction as $item)
                                    <tr>
                                        <td>{{ $item->vehicle }}</td>
                                        <td>{{ $item->owner }}</td>
                                        <td>{{ $item->maintenance_type }}</td>
                                        <td>₱{{ number_format($item->cost, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}</td>
                                        <td>
                                            <button class="btn btn-dark btn-sm rounded-pill" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#view_transaction"
                                            data-owner="{{ $item['owner'] }}"
                                            data-vehicle="{{ $item['vehicle'] }}"
                                            data-previous-milage="{{ $item['previous_milage'] }}"
                                            data-current-milage="{{ $item['current_milage'] }}"
                                            data-maintenance-type="{{ $item['maintenance_type'] }}"
                                            data-oil-type="{{ $item['oil_type'] }}"
                                            data-pms-services="{{ $item['pms_services'] }}"
                                            data-cost="{{ $item['cost'] }}"
                                            data-date-performed="{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}"
                                            data-maintenance-description="{{ $item['maintenance_description'] }}"
                                            onclick="populateModal(this)">View</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    @endif 
                </table>
            </div>
        </x-admin-dashboard.admin-content>
    </main>
    <!--End-->

    <!--View Transactions Modal-->
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

    <script>
        //Transaction Populate Modal
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
        // Function to animate counting up numbers
        function animateValue(id, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const currentValue = Math.floor(progress * (end - start) + start);
                document.getElementById(id).innerText = currentValue;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Call the animation for each count
        document.addEventListener("DOMContentLoaded", () => {
            animateValue("customerCount", 0, {{ $customerCount }}, 1000);
            animateValue("vehicleCount", 0, {{ $vehicleCount }}, 1000); 
            animateValue("scheduleCount", 0, {{ $scheduleCount }}, 1000); 
            animateValue("notificationCount", 0, {{ $notificationCount }}, 1000);
        });

        //Daily and Weekly Customer Registration Reports button
        const day_btn = document.getElementById('day_btn');
        const week_btn = document.getElementById('week_btn');

        day_btn.addEventListener('click',function(){
            week_btn.style.backgroundColor = "white";
            week_btn.style.color = "black";
            week_btn.style.border="1px solid black";

            day_btn.style.backgroundColor = "rgb(214, 1, 1)";
            day_btn.style.color = "white";
            day_btn.style.border="none";

            document.getElementById('customer_daily_count').style.display="block";
            document.getElementById('customer_weekly_count').style.display="none";

            document.getElementById('customer_daily_table').style.display="table";
            document.getElementById('customer_weekly_table').style.display="none";

            document.getElementById('customer_daily_empty').style.display="flex";
            document.getElementById('customer_weekly_empty').style.display="none";
        });

        week_btn.addEventListener('click',function(){
            day_btn.style.backgroundColor = "white";
            day_btn.style.color = "black";
            day_btn.style.border="1px solid black";

            week_btn.style.backgroundColor = "rgb(214, 1, 1)";
            week_btn.style.color = "white";
            week_btn.style.border="none";

            document.getElementById('customer_daily_count').style.display="none";
            document.getElementById('customer_weekly_count').style.display="block";

            document.getElementById('customer_daily_table').style.display="none";
            document.getElementById('customer_weekly_table').style.display="table";

            document.getElementById('customer_daily_empty').style.display="none";
            document.getElementById('customer_weekly_empty').style.display="flex";
        });

        //Daily and Weekly Customer Transaction Reports button
        const day_transaction_btn = document.getElementById('day_transaction_btn');
        const week_transaction_btn = document.getElementById('week_transaction_btn');

        day_transaction_btn.addEventListener('click',function(){
            week_transaction_btn.style.backgroundColor = "white";
            week_transaction_btn.style.color = "black";
            week_transaction_btn.style.border="1px solid black";

            day_transaction_btn.style.backgroundColor = "rgb(214, 1, 1)";
            day_transaction_btn.style.color = "white";
            day_transaction_btn.style.border="none";

            document.getElementById('customer_daily_transaction_count').style.display="block";
            document.getElementById('customer_weekly_transaction_count').style.display="none";

            document.getElementById('customer_daily_transaction_table').style.display="table";
            document.getElementById('customer_weekly_transaction_table').style.display="none";

            document.getElementById('customer_daily_transaction_empty').style.display="flex";
            document.getElementById('customer_weekly_transaction_empty').style.display="none";
        });

        week_transaction_btn.addEventListener('click',function(){
            day_transaction_btn.style.backgroundColor = "white";
            day_transaction_btn.style.color = "black";
            day_transaction_btn.style.border="1px solid black";

            week_transaction_btn.style.backgroundColor = "rgb(214, 1, 1)";
            week_transaction_btn.style.color = "white";
            week_transaction_btn.style.border="none";

            document.getElementById('customer_daily_transaction_count').style.display="none";
            document.getElementById('customer_weekly_transaction_count').style.display="block";

            document.getElementById('customer_daily_transaction_table').style.display="none";
            document.getElementById('customer_weekly_transaction_table').style.display="table";

            document.getElementById('customer_daily_transaction_empty').style.display="none";
            document.getElementById('customer_weekly_transaction_empty').style.display="flex";
        });

    </script>
</body>

</html>