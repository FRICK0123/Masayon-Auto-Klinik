@props(['transaction','interval'])
<div class="container-fluid">
    <h3>Repair/Maintenance Transactions ({{ $interval }})</h3><br>

    @php
        $transaction_count = $transaction->count();
    @endphp

    <h4>Transactions: {{ $transaction_count }}</h4>

    <form method="GET" action="{{route('reports_transaction_filter')}}">
        <label for="interval">Select Interval:</label>
        <select name="interval" id="interval" onchange="this.form.submit()">
                <option value="daily" {{ $interval == 'daily' ? 'selected' : '' }}>This Day</option>
                <option value="weekly" {{ $interval == 'weekly' ? 'selected' : '' }}>This Week</option>
                <option value="monthly" {{ $interval == 'monthly' ? 'selected' : '' }}>This Month</option>
                <option value="yearly" {{ $interval == 'yearly' ? 'selected' : '' }}>This Year</option>
        </select>
    </form><br>

    <!--Transactions Chart reports-->
        <div class="container" style="width: 700px;">
            <canvas id="myChart"></canvas>  
        </div><br>
    <!--end-->

    <!--Cars table-->
    <div id="carTableContainer">
        <table class="table table-striped table-responsive">
            <tr>
                <th>VEHICLE</th>
                <th>OWNER</th>
                <th>MAINTENANCE TYPE</th>
                <th>COST</th>
                <th>DATE PERFORMED</th>
                <th></th>
            </tr>

            @foreach ($transaction as $item)
                <tr>
                    <td>{{ $item->vehicle }}</td>
                    <td>{{ $item->owner }}</td>
                    <td>{{ $item->maintenance_type }}</td>
                    <td>₱{{ $item->cost }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}</td>
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

<script>
    // Get the context of the canvas element
    const ctx = document.getElementById('myChart').getContext('2d');

    // Create the chart
    const myChart = new Chart(ctx, {
        type: 'bar', // Specify the chart type (e.g., bar, line, pie, etc.)
        data: {
            labels: ['8:00AM','9:00AM','10:00AM','11:00AM','12:00AM','1:00AM','2:00AM','3:00AM','4:00AM','5:00AM'], // Labels for the X-axis
            datasets: [{
                label: 'Daily Transactions',
                data: [12, 19, 3, 5, 2, 3, 16, 4, 7, 12], // Data points for the chart
                backgroundColor: [
                    'gray',
                    'gray',
                    'gray',
                    'gray',
                    'gray',
                    'gray',
                    'gray',
                    'gray',
                    'gray',
                    'gray'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true // Make Y-axis start at zero
                }
            }
        }
    });

</script>
