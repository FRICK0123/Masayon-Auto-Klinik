<table class="table table-striped table-responsive">
    <tr>
        <th>CAR IMAGE</th>
        <th>MAKE</th>
        <th>MODEL</th>
        <th>YEAR</th>
        <th>ENGINE TYPE</th>
        <th></th>
    </tr>
    @foreach ($cars as $car)
        <tr>
            <td><img src="{{ asset('Images/car_images/'.$car['car_image']) }}" alt="Car Image" width="100" height="100"></td>
            <td>{{ $car['car_make'] }}</td>
            <td>{{ $car['car_model'] }}</td>
            <td>{{ $car['year_of_manufacture'] }}</td>
            <td>{{ $car['engine_type'] }}</td>
            <td>
                <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                        <li><a class="dropdown-item bg-danger text-light" href="#">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
</table>
