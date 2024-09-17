@props(['schedules'])

<div class="container">
    <h2 class="pb-2 border-bottom">MAINTENANCE OVERVIEW</h2>

    <!--Functionalities-->
        <div class="d-flex justify-content-between">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('icons/funnel.svg')}}" alt="Filter">
                </button>
                <form id="carFilterForm" action="{{ route('car_filter') }}" method="GET" class="dropdown-menu p-2">
                    <input type="radio" id="by_make" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_make">
                    <label for="by_make" class="ms-2">By Make</label><br><br>

                    <input type="radio" id="by_model" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_model">
                    <label for="by_model" class="ms-2">By Model</label><br><br>

                    <input type="radio" id="by_year" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_year">
                    <label for="by_year" class="ms-2">By Year</label><br><br>

                    <button type="submit" class="btn btn-dark">Filter</button>
                </form>
            </div>
        </div>
    <!--end-->

    <!--Cars table-->
    <div id="carTableContainer">
        <table class="table table-striped table-responsive">
            <tr>
                <th>VEHICLE</th>
                <th>OWNER</th>
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
                    $isNearingDate = $scheduledDate->diffInMonths($now) <= 3 && $scheduledDate >= $now;

                    // Mileage-based logic (for oil type maintenance)
                    $isNearingMileage = false;
                    if ($schedule->maintenance_type == 'Oil Change') {
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
                    <td>{{ $schedule->vehicle->customer->fullname }}</td>
                    <td>{{ $schedule->maintenance_type }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}</td>
                    
                    <!-- Show mileage if it's an oil type maintenance -->
                    @if ($schedule->maintenance_type == 'Oil Change')
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