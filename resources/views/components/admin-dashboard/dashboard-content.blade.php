@props(['schedules','scheduleCount','customerCount','vehicleCount'])
<div class="container row">
    <h2 class="pb-2 border-bottom">DASHBOARD</h2>

    <div class="col-md-3">
        <div class="border border-success d-flex flex-column align-items-center mt-3 summary_cards" style="height: 200px">
            <img src="{{ asset('icons/users.svg') }}" alt="Customers" width="100" height="100">
            <h5>CUSTOMERS:</h5>
            <h5 id="customerCount">{{ $customerCount }}</h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-secondary d-flex flex-column align-items-center mt-3 summary_cards" style="height: 200px">
            <img src="{{ asset('icons/car.svg') }}" alt="Customers" width="100" height="100">
            <h5>CUSTOMER CARS:</h5>
            <h5 id="vehicleCount">{{ $vehicleCount }}</h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-danger d-flex flex-column align-items-center mt-3 summary_cards" style="height: 200px">
            <img src="{{ asset('icons/gear-fine.svg') }}" alt="Customers" width="100" height="100">
            <h5 class="text-center">UPCOMING MAINTENANCE TASKS:</h5>
            <h5 id="scheduleCount">{{ $scheduleCount }}</h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-warning d-flex flex-column align-items-center mt-3 summary_cards" style="height: 200px">
            <img src="{{ asset('icons/bell-ringing.svg') }}" alt="Customers" width="100" height="100">
            <h5 class="text-center">NOTIFICATIONS SENT:</h5>
            <h5>0</h5>
        </div>
    </div>
</div>
<br><br>

<div class="container">
    <h5>Upcoming Maintenance Tasks:</h5>
   <!--Cars table-->
        <table class="table table-striped table-responsive">
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
