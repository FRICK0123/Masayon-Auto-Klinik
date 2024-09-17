@props(['vehicles','customer'])
<div class="container">
    <h2 class="pb-2 border-bottom">{{ $customer['fullname'] }} VEHICLES</h2>

    <table class="table table-striped table-responsive">
        <tr>
            <th>IMAGE</th>
            <th>MAKE</th>
            <th>MODEL</th>
            <th>YEAR OF MANUFACTURE</th>
            <th>ENGINE TYPE</th>
            <th></th>
        </tr>

        @foreach ($vehicles as $vehicle)
            <tr>
                <td><img src="{{asset('Images/car_images/'.$vehicle['vehicle_image'])}}" alt="Vehicle Image" width="100" height="100"></td>
                <td>{{ $vehicle['make'] }}</td>
                <td>{{ $vehicle['model'] }}</td>
                <td>{{ $vehicle['year_of_manufacture'] }}</td>
                <td>{{ $vehicle['engine_type'] }}</td>
                <td>...</td>
            </tr>
        @endforeach
    </table>
</div>