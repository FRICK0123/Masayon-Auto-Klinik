@props(['vehicles','customer'])
<div class="container">
    <h2 class="pb-2 border-bottom">{{ $customer['fullname'] }} VEHICLES</h2>

    <table class="table table-striped table-responsive">
        <tr>
            <th>MAKE</th>
            <th>MODEL</th>
            <th>YEAR OF MANUFACTURE</th>
            <th>ENGINE TYPE</th>
        </tr>

        @foreach ($vehicles as $vehicle)
            <tr>
                <td>{{ $vehicle['make'] }}</td>
                <td>{{ $vehicle['model'] }}</td>
                <td>{{ $vehicle['year_of_manufacture'] }}</td>
                <td>{{ $vehicle['engine_type'] }}</td>
            </tr>
        @endforeach
    </table>
</div>