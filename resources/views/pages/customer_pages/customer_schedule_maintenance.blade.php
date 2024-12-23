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

 
                                        <a href="#" class="btn btn-dark btn-sm"
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
                                                onclick="populateModal(this)">View Details</a>
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
            </x-customer-dashboard.main-content>
        </main>
    <!--End-->

    <!--Footer-->
        <footer class="d-block d-md-none">
            <x-customer-dashboard.mobile-footer/>
        </footer>
    <!--end-->

    <script>
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
            document.getElementById('view_current_milage').innerHTML = current_milage + "km";
            document.getElementById('view_next_milage_schedule').innerHTML = next_milage_schedule + "km";
        }
    </script>
</body>
</html>