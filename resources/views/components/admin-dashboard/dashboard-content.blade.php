@props(['schedules','scheduleCount','customerCount','vehicleCount'])
<div class="container row">
    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm border">
        <h5 class="pt-2">DASHBOARD</h5>
    </div>

    <div class="col-md-3">
        <div class="border border-success rounded-3 mt-3 summary_cards p-3" style="height: 160px; width: 90%;">
            <div class="d-flex align-items-center">
                <img src="{{ asset('icons/users.svg') }}" alt="Customers" width="30" height="30">
                <h5 class=" boxes_label ms-2 fw-bold">CUSTOMERS</h5>
            </div><br>

            <div class="d-flex justify-content-between">
                <h2 id="customerCount">{{ $customerCount }}</h2>
                <img src="{{ asset('chart.png') }}" alt="Customers" width="100">
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-secondary rounded-3 mt-3 summary_cards p-3" style="height: 160px; width: 90%;">
            <div class="d-flex align-items-center">
                <img src="{{ asset('icons/car.svg') }}" alt="Customers" width="30" height="30">
                <h5 class=" boxes_label ms-2 fw-bold">CUSTOMER CARS</h5>
            </div><br>

            <div class="d-flex justify-content-between">
                <h2 id="vehicleCount">{{ $vehicleCount }}</h2>
                <img src="{{ asset('chart.png') }}" alt="Vehicle Count" width="100">
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-danger rounded-3 mt-3 summary_cards p-3" style="height: 160px; width: 90%;">
            <div class="d-flex align-items-center">
                <img src="{{ asset('icons/gear-fine.svg') }}" alt="Maintenance Tasks" width="30" height="30">
                <h5 class=" boxes_label ms-2 fw-bold">MAINTENANCE TASKS</h5>
            </div><br>

            <div class="d-flex justify-content-between">
                <h2 id="scheduleCount">{{ $scheduleCount }}</h2>
                <img src="{{ asset('chart.png') }}" alt="Vehicle Count" width="100">
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-warning rounded-3 mt-3 summary_cards p-3" style="height: 160px; width: 90%;">
            <div class="d-flex align-items-center">
                <img src="{{ asset('icons/bell-ringing.svg') }}" alt="Notifications Sent" width="30" height="30">
                <h5 class=" boxes_label ms-2 fw-bold">NOTIFICATIONS SENT</h5>
            </div><br>

            <div class="d-flex justify-content-between">
                <h2 id="scheduleCount">0</h2>
                <img src="{{ asset('chart.png') }}" alt="Vehicle Count" width="100">
            </div>
        </div>
    </div>
</div>
<br><br>

<div class="container table-responsive">
    <h5>Upcoming Maintenance Tasks:</h5>
   <!--Cars table-->
        <table class="table table-striped">
            <tr>
                <th>VEHICLE</th>
                <th>OWNER</th>
                <th>MAINTENANCE TYPE</th>
                <th>SCHEDULED DATE</th>
                <th>SCHEDULED MILAGE</th>
                <th></th>
            </tr>

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
</div>

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
</script>
