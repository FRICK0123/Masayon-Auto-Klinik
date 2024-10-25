@props(['schedules'])

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
                    <td>{{ $schedule->vehicle->customer->fullname }}</td>
                    <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</td>
                    <td>{{ $schedule->maintenance_type }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}</td>
                    
                    <!-- Show mileage if it's an oil type maintenance -->
                    @if ($schedule->maintenance_type == 'Oil Change' || $schedule->maintenance_type == 'EGR Cleaning' || $schedule->maintenance_type == 'Basic PMS' || $schedule->maintenance_type == 'Full PMS')
                        <td>{{ $schedule->next_milage_schedule }} km
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
                                <li>
                                    <a class="dropdown-item" href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#view_schedule"
                                    data-owner="{{ $schedule->vehicle->customer->fullname }}"
                                    data-vehicle="{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} {{ $schedule->vehicle->year_of_manufacture }}"
                                    data-maintenance-type="{{ $schedule->maintenance_type }}"
                                    data-pms-services="{{ $schedule->PMS_services }}"
                                    data-scheduled-date="{{ $schedule->scheduled_date }}"
                                    data-last-maintenance-date="{{ $schedule->last_maintenance_date }}"
                                    data-scheduled-interval="{{ $schedule->scheduled_interval }}"
                                    data-oil-type="{{ $schedule->oil_type }}"
                                    data-current-milage="{{ $schedule->current_milage }}"
                                    data-next-milage-schedule="{{ $schedule->next_milage_schedule }}"
                                    onclick="populateModal(this)">View</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Notify</a></li>
                            </ul>
                        </div>
                    </td>
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