@props(['vehicle'])
<div class="container p-3 border border-2 shadow rounded-" style="width: 98%">
    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="view_car_wrapper">
                <img src="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}" alt="Car Image" id="car_image" class="view_car_image">
            </div>
        </div>

        <div class="col-md-6 mt-2">
            <h2>{{$vehicle['make']}} {{$vehicle['model']}} {{$vehicle['year_of_manufacture']}}</h2>
            <div class="d-flex">
                <label class="fw-bold">Current Mileage: &nbsp;</label>
                <p>{{ $vehicle['milage'] }} mi</p>
            </div>

            <div class="d-flex">
                <label class="fw-bold">Engine Number: &nbsp;</label>
                <p>{{ $vehicle['engine_number'] }}</p>
            </div>

            <div class="d-flex">
                <label class="fw-bold">VIN: &nbsp;</label>
                <p>{{ $vehicle['vehicle_identification_number'] }}</p>
            </div>

            <div class="d-flex">
                <label class="fw-bold">Chassis Number: &nbsp;</label>
                <p>{{ $vehicle['chassis_number'] }}</p>
            </div>

            <div class="d-flex">
                <label class="fw-bold">Plate Number: &nbsp;</label>
                <p>{{ $vehicle['plate_number'] }}</p>
            </div>

            <div class="d-flex">
                <label class="fw-bold">Engine Type: &nbsp;</label>
                <p>{{ $vehicle['engine_type'] }} mi</p>
            </div>

            <div class="container">
                <div class="row">
                    <form action="{{ route('schedule_maintenance_form',$vehicle['vehicleID']) }}" method="GET" class="col-md-6 mt-3">
                        @csrf
                        <button class="btn btn-dark w-100">Appointment</button>
                    </form>

                    <form action="#" method="POST" class="col-md-6 mt-3">
                        @csrf
                        <button class="btn btn-danger w-100">Delete Car</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>