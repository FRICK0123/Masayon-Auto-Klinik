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
            <x-manager-dashboard.mobile-canvas/>
            <x-manager-dashboard.manager-content>
                <div class="container-fluid">
                    <div class="container-fluid row">
                        <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm border mt-4 mt-lg-0">
                            <h5 class="pt-2">DASHBOARD</h5>
                        </div>

                        <!-- CUSTOMER COUNT CARD -->
                        <div class="col-md-3">
                            <div class="border border-success rounded-3 mt-3 summary_cards p-3" style="height: 160px; width: 100%;">
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
                        </div>

                        <!-- VEHICLE COUNT CARD -->
                        <div class="col-md-3">
                            <div class="border border-secondary rounded-3 mt-3 summary_cards p-3" style="height: 160px; width: 100%;">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('icons/car.svg') }}" alt="Customers" width="30" height="30">
                                    <h6 class="boxes_label ms-2 fw-bold">CUSTOMER CARS</h6>
                                </div><br>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 id="vehicleCount">{{ $vehicleCount }}</h2>
                                    <img src="{{ asset('chart.png') }}" alt="Vehicle Count" class="box_chart">
                                </div>
                            </div>
                        </div>

                        <!-- MAINTENANCE TASKS CARD -->
                        <div class="col-md-3">
                            <div class="border border-danger rounded-3 mt-3 summary_cards p-3" style="height: 160px; width: 100%;">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('icons/gear-fine.svg') }}" alt="Maintenance Tasks" width="30" height="30">
                                    <h5 class="boxes_label ms-2 fw-bold">MAINTENANCE TASKS</h5>
                                </div><br>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 id="scheduleCount">{{ $scheduleCount }}</h2>
                                    <img src="{{ asset('chart.png') }}" alt="Vehicle Count" class="box_chart">
                                </div>
                            </div>
                        </div>

                        <!-- NOTIFICATIONS SENT CARD -->
                        <div class="col-md-3">
                            <div class="border border-warning rounded-3 mt-3 summary_cards p-3" style="height: 160px; width: 100%;">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('icons/bell-ringing.svg') }}" alt="Notifications Sent" width="30" height="30">
                                    <h5 class="boxes_label ms-2 fw-bold">NOTIFICATIONS SENT</h5>
                                </div><br>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 id="notificationCount">0</h2>
                                    <img src="{{ asset('chart.png') }}" alt="Notifications Sent" class="box_chart">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>

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
                                <button class="btn btn-sm rounded-pill btn_inactive mt-2 mt-md-0" id="week_btn" style="border: 1px solid black">This Week</button>
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
                                                    <div class="dropdown">
                                                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="{{ route('view_user_info',$user['customerID']) }}">View</a></li>
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
                                                @if ($user['isVerified'] == 1 && $user['email_verified_at'] !== null)
                                                    <td><span class="badge bg-success p-2">verified</span></td>
                                                @elseif($user['isVerified'] == 0 && $user['email_verified_at'] == null)
                                                    <td><span class="badge bg-danger p-2">deactivated</span></td>
                                                @else
                                                    <td>not verified</td>
                                                @endif
                                                <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('F j, Y') }}</td>

                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="{{ route('view_user_info',$user['customerID']) }}">View</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            @endif 
                        </table>
                    </div>
                </div>

            </x-manager-dashboard.manager-content>
        </main>
    <!--End-->

<script>
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
        animateValue("customerCount", 0, {{ $customerCount }}, 600); // 2 seconds duration
        animateValue("vehicleCount", 0, {{ $vehicleCount }}, 600); 
        animateValue("scheduleCount", 0, {{ $scheduleCount }}, 600); 
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
</script>
</body>
</html>