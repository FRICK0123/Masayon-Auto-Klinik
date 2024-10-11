@props(['schedules'])
<div class="container">
    <h2 class="pb-2 border-bottom">Appointments</h2>
  
      <div class="container pt-3 p-md-0 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="bg-dark text-white"><p>Vehicle</p></th>
                    <th class="bg-dark text-white"><p>Maintenance Type</p></th>
                    <th class="bg-dark text-white"><p>Scheduled Interval</p></th>
                    <th class="bg-dark text-white"><p>Next Maintenance</p></th>
                    <th class="bg-dark text-white"><p>Last Maintenance</p></th>
                    <th class="bg-dark text-white"><p>Oil Type</p></th>
                    <th class="bg-dark text-white"><p>Current Mileage</p></th>
                    <th class="bg-dark text-white"><p>Next Mileage for Maintenance</p></th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule['make'] }} {{ $schedule['model'] }} {{ $schedule['year_of_manufacture'] }}</td>
                        <td>{{ $schedule['maintenance_type'] }}</td>
                        <td>{{ $schedule['scheduled_interval'] }} months</td>
                        <td>{{ \Carbon\Carbon::parse($schedule['scheduled_date'])->format('F j, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule['last_maintenance_date'])->format('F j, Y') }}</td>
                        <td>{{ $schedule['oil_type'] }}</td>
                        <td>{{ $schedule['current_milage'] }}</td>
                        <td>{{ $schedule['next_milage_schedule'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
