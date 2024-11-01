<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schedule Maintenance</title>
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
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm mt-5 mt-lg-0">
                        <h5 class="pt-2">MAINTENANCE SCHEDULE</h5>
                    </div>

                    <br>
                    <div class="row">
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
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card bg-light border border-dark" id="card">
                                    <div class="card-body @if($isNearingDate || $isNearingMileage) bg-danger-subtle" @endif>
                                        <h5 class="card-title">{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</h5>
                                        <p><strong>Maintenance Type:</strong> {{ $schedule->maintenance_type }}</p>
                                        <p><strong>Scheduled Date:</strong> {{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}</p>
                                        <p><strong>Scheduled Milage:</strong>
                                            @if ($schedule->maintenance_type == 'Oil Change' || $schedule->maintenance_type == 'EGR Cleaning' || $schedule->maintenance_type == 'Basic PMS' || $schedule->maintenance_type == 'Full PMS')
                                                {{ $schedule->next_milage_schedule }} miles
                                                @if($isNearingMileage)
                                                    <span class="badge bg-danger">Mileage Reached!</span>
                                                @elseif($isNearingDate)
                                                    <span class="badge bg-danger">Schedule for Maintenance!</span>
                                                @endif
                                            @else
                                                    N/A
                                                    @if($isNearingDate)
                                                        <span class="badge bg-danger">Schedule for Maintenance!</span>
                                                    @endif
                                            @endif
                                        </p>

                                        <!-- Show mileage if it's an oil type maintenance -->

 
                                        <a href="#" class="btn btn-primary btn-sm">View Details</a>
                                    </div>
                                    <span class="top"></span>
                                    <span class="bottom"></span>
                                    <span class="right"></span>
                                    <span class="left"></span>
                                </div>
                            </div> 
                        @endforeach
                    </div>
                </div>
            </x-customer-dashboard.main-content>
        </main>
    <!--End-->
</body>
</html>