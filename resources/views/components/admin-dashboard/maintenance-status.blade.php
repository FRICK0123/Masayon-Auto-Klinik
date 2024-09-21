@props(['schedules'])

<div class="container">
    <h2 class="pb-2 border-bottom">MAINTENANCE STATUS</h2>

    <div class="container">
    <!--Cars table-->
            <table class="table table-striped table-responsive">
                <tr>
                    <th>VEHICLE</th>
                    <th>OWNER</th>
                    <th>MAINTENANCE TYPE</th>
                    <th>SCHEDULED DATE</th>
                    <th>SCHEDULED MILAGE</th>
                    <th>STATUS</th>
                    <th></th>
                </tr>

                @foreach ($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</td>
                    <td>{{ $schedule->vehicle->customer->fullname }}</td>
                    <td>{{ $schedule->maintenance_type }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}</td>
                    <td>{{ $schedule->next_milage_schedule }}</td>
                    <td class="bg-warning">Pending...</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Update</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        <!--End-->
    </div>
</div>