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
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm mt-5 mt-lg-0">
                        <h5 class="pt-2">MAINTENANCE SCHEDULE</h5>
                    </div>

                    <!--Functionalities-->
                        <div class="d-flex justify-content-between">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset('icons/bars-filter.svg')}}" alt="Filter">
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
                    <div class="row">
                        @php
                            $now = \Carbon\Carbon::now();
                        @endphp
                        @foreach ($schedules as $schedule)
                            @php
                                $scheduledDate = \Carbon\Carbon::parse($schedule->scheduled_date);
                                $isNearingDate = $scheduledDate->diffInDays($now) <= 7 && $scheduledDate >= $now;
                                $isOverdue = $scheduledDate->diffInDays($now) <= 7 && $scheduledDate < $now;

                                // Mileage-based logic (for oil type maintenance)
                                $isNearingMileage = false;
                                if (in_array($schedule->maintenance_type, ['Oil Change', 'EGR Cleaning', 'Basic PMS', 'Full PMS'])) {
                                    $currentMileage = $schedule->current_milage;
                                    $nextMileage = $schedule->next_milage_schedule;

                                    // Check if the mileage has been reached or exceeded
                                    $isNearingMileage = $currentMileage >= $nextMileage;
                                }
                            @endphp
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card bg-light">
                                    <div class="card-body @if($isNearingDate || $isNearingMileage || $isOverdue) bg-danger-subtle @endif">
                                        <h5 class="card-title">{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</h5>
                                        <p><strong>Owner:</strong> {{ $schedule->vehicle->customer->fullname }}</p>
                                        <p><strong>Maintenance Type:</strong> {{ $schedule->maintenance_type }}</p>
                                        <p><strong>Scheduled Date:</strong> {{ $scheduledDate->format('F j, Y') }}</p>
                                        <p><strong>Scheduled Milage:</strong>
                                            @if (in_array($schedule->maintenance_type, ['Oil Change', 'EGR Cleaning', 'Basic PMS', 'Full PMS']))
                                                {{ $schedule->next_milage_schedule }} miles
                                                @if($isNearingMileage)
                                                    <span class="badge bg-danger">Mileage Reached!</span>
                                                @elseif($isNearingDate || $isOverdue)
                                                    <span class="badge bg-danger">Schedule for Maintenance!</span>
                                                @endif
                                            @else
                                                N/A
                                                @if($isNearingDate || $isOverdue)
                                                    <span class="badge bg-danger">Schedule for Maintenance!</span>
                                                @endif
                                            @endif
                                        </p>

                                        <a href="#" class="btn btn-primary btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div> 
                        @endforeach
                    </div>
                </div>
            </x-manager-dashboard.manager-content>
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
    </script>
</body>
</html>