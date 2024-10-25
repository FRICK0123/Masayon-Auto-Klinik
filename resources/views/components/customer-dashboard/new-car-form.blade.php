@props(['cars'])

<div class="container w-75 border border-2 shadow pt-3 pb-3 rounded-4">
    <h2 class="text-center text-light">Add Your Car</h2>
    <form action="{{ route('add_car') }}" method="post" class="container" enctype="multipart/form-data">
        @csrf
        <div class="car_img_wrapper mt-5">
            <img src="{{ asset('Images/car_images/sample_car.png') }}" alt="Car Image" class="car_image" id="car_image">
        </div>

        <div class="mt-3 container">
            <label class="fw-bold text-light">You can also upload your own car image:</label>
            <input class="form-control" type="file" id="car_image_file" accept=".jpg,.jpeg,.png" name="car_image">
        </div><br><br>
        <!-- Hidden input field to store car image filename -->
            <input type="hidden" id="car_image_hidden" name="car_image_hidden">
        <!-- Car Dropdown -->
        <label for="car_select" class="fw-bold text-light">Select Car:</label>
        <select class="form-select" id="car_select">
            <option value="" disabled selected>Select a car</option>
            @foreach ($cars as $car)
                <option value="{{ $car->id }}"
                        data-make="{{ $car->car_make }}"
                        data-model="{{ $car->car_model }}"
                        data-year="{{ $car->year_of_manufacture }}"
                        data-engine-type="{{ $car->engine_type }}"
                        data-image="{{ asset('Images/car_images/' .$car->car_image) }}"
                        data-image-file="{{ $car->car_image }}">
                    {{ $car->car_make }} {{ $car->car_model }} ({{ $car->year_of_manufacture }}) {{ $car->engine_type }}
                </option>
            @endforeach
        </select><br>

        <!-- Input fields for car details -->
        <label for="car_make" class="fw-bold text-light">Car Make:</label>
        <input type="text" id="car_make" name="car_make" class="form-control" readonly><br>

        <label for="car_model" class="fw-bold text-light">Car Model:</label>
        <input type="text" id="car_model" name="car_model" class="form-control" readonly><br>

        <label for="year_of_manufacture" class="fw-bold text-light">Year of Manufacture:</label>
        <input type="text" id="year_of_manufacture" name="year_of_manufacture" class="form-control" readonly><br>
        <br>

        <label for="engine_type" class="fw-bold text-light">Engine Type:</label>
        <input type="text" id="engine_type" name="engine_type" class="form-control" readonly><br>
        <br>

        <label for="milage" class="fw-bold text-light" required>Milage:</label>
        <input type="number" name="milage" class="form-control" id="milage"><br>

        <label for="engine_number" class="fw-bold text-light" required>Engine Number:</label>
        <input type="text" name="engine_number" class="form-control" id="engine_number"><br>

        <label for="vehicle_identification_number" class="fw-bold text-light" required>Vehicle Identification Number:</label>
        <input type="text" name="vehicle_identification_number" class="form-control" id="vehicle_identification_number"><br>

        <label for="chassis_number" class="fw-bold text-light" required>Chassis Number:</label>
        <input type="text" name="chassis_number" class="form-control" id="chassis_number"><br>

        <label for="plate_number" class="fw-bold text-light" required>Plate Number:</label>
        <input type="text" placeholder="ABC-123" name="plate_number" class="form-control" id="plate_number" pattern="[A-Z]{3}-[0-9]{3}" title="Please enter a valid plate number in the format ABC-123"><br>

        <button class="btn btn-secondary w-100">Submit</button>
    </form>
</div>

    <script>
        // JavaScript to handle dropdown change event
        document.getElementById('car_select').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            // Get data attributes from the selected option
            const make = selectedOption.getAttribute('data-make');
            const model = selectedOption.getAttribute('data-model');
            const year = selectedOption.getAttribute('data-year');
            const engine_type = selectedOption.getAttribute('data-engine-type');
            const image = selectedOption.getAttribute('data-image');
            const imageFile = selectedOption.getAttribute('data-image-file');

            // Populate input fields
            document.getElementById('car_make').value = make;
            document.getElementById('car_model').value = model;
            document.getElementById('year_of_manufacture').value = year;
            document.getElementById('engine_type').value = engine_type;

            // Update the car image
            document.getElementById('car_image').src = image;

            // Populate the hidden input field with the image filename
            document.getElementById('car_image_hidden').value = imageFile;
        });
        document.getElementById('car_image_file').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const fileType = file.type;
                const validImageTypes = ['image/jpeg', 'image/png'];

                if (!validImageTypes.includes(fileType)) {
                    alert('Only JPG and PNG files are allowed.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('car_image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>