@props(['schedules'])
<div class="container pt-3 table-responsive">
    <table class="table table-striped border">
        <thead>
            <tr>
                <th>Vehicle</th>
                <th>Current Mileage</th>
                <th>Maintenance Type</th>
                <th>Appointment Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule['make'] }} {{ $schedule['model'] }} {{ $schedule['year_of_manufacture'] }}</td>
                    <td>{{ $schedule['current_milage'] }}</td>
                    <td>{{ $schedule['maintenance_type'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule['appointment_date'])->format('F j, Y') }}</td>
                    <td>
                        <div class="dropdown" style="position: static">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Delete Appointment</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>