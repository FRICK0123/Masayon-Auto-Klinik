@props(['vehicle'])
<div class="container w-75 border border-2 shadow pt-3 pb-3">
        <div class="car_img_wrapper mt-5">
            <img src="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}" alt="Car Image" class="car_image" id="car_image">
        </div>

        <p><b>Owner: </b>{{ Session::get('fullname') }}</p>
        <p><b>Car Make: </b>{{ $vehicle['make'] }}</p>
        <p><b>Model: </b>{{ $vehicle['model'] }}</p>
        <p><b>Year of Manufacture: </b>{{ $vehicle['year_of_manufacture'] }}</p>
        <p><b>Plate Number: </b>{{ $vehicle['plate_number'] }}</p>

        <div class="container">
            <div class="row">
                <form action="#" method="POST" class="col-md-6 mt-3">
                    <button class="btn btn-dark w-100">Schedule Maintenance</button>
                </form>

                <form action="#" method="POST" class="col-md-6 mt-3">
                    <button class="btn btn-danger w-100">Delete Car</button>
                </form>
            </div>
        </div>
</div>