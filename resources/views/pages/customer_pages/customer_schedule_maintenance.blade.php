<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schedule Maintenance</title>
    <link rel="stylesheet" href="{{asset('css/customer_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

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
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
                        <h5 class="pt-2">MAINTENANCE SCHEDULE</h5>
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
                                <th>VEHICLE</th>
                                <th>MAINTENANCE TYPE</th>
                                <th>SCHEDULED DATE</th>
                                <th>SCHEDULED MILAGE</th>
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
                                <tr @if($isNearingDate || $isNearingMileage) class="table-danger" @endif>
                                    <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</td>
                                    <td>{{ $schedule->maintenance_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}</td>
                                    
                                    <!-- Show mileage if it's an oil type maintenance -->
                                    @if ($schedule->maintenance_type == 'Oil Change' || $schedule->maintenance_type == 'EGR Cleaning' || $schedule->maintenance_type == 'Basic PMS' || $schedule->maintenance_type == 'Full PMS')
                                        <td>{{ $schedule->next_milage_schedule }} miles
                                            @if($isNearingMileage)
                                                <span class="badge bg-danger">Mileage Reached!</span>
                                            @elseif($isNearingDate)
                                                <span class="badge bg-danger">Schedule for Maintenance!</span>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            N/A
                                            @if($isNearingDate)
                                                <span class="badge bg-danger">Schedule for Maintenance!</span>
                                            @endif
                                        </td>
                                    @endif
                                    
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <!--End-->
                </div>
            </x-customer-dashboard.main-content>
        </main>
    <!--End-->
</body>
</html>