<div class="container w-75 border border-2 shadow pt-3 pb-3">
    <h2 class="text-center">Add New Car</h2>
    <form action="{{ route('add_car') }}" method="post" class="container" enctype="multipart/form-data">
        @csrf
        <div class="car_img_wrapper mt-5">
            <img src="{{ asset('Images/car_images/car.png') }}" alt="Car Image" class="car_image" id="car_image">
        </div>

        <div class="mt-3 container">
            <input class="form-control" type="file" id="car_image_file" accept=".jpg,.jpeg,.png" name="car_image">
        </div><br><br>
        
        <label for="car_make" class="fw-bold">Car Make:</label>
        <input type="text" placeholder="Honda, Ford, Mitsubishi, etc." name="car_make" class="form-control" id="car_make" required><br>

        <label for="car_model" class="fw-bold">Car Model:</label>
        <input type="text" placeholder="Honda Civic, Ford Ranger, Mitsubishi Montero Sport, etc." name="car_model" class="form-control" id="car_model" required><br>

        <label for="year_of_manufacture" class="fw-bold">Year of Manufacture:</label>
        <select name="year_of_manufacture" id="year_of_manufacture" class="form-select" required>
            <option value="">Select Year</option>
            @for ($year = date('Y'); $year >= 1990; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
            @endfor
        </select>
        @error('year_of_manufacture')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <br>

        <label for="plate_number" class="fw-bold" required>Plate Number:</label>
        <input type="text" placeholder="ABC 123" name="plate_number" class="form-control" id="plate_number"><br>

        <button class="btn btn-dark">Submit</button>
    </form>
</div>

    <script>
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