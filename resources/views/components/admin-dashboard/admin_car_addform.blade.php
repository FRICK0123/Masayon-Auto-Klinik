<div class="container w-75 border border-2 shadow pt-3 pb-3 mb-3">
    <h1 class="text-center">Add new car</h1>

    <form action="{{ route('store_car') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="car_img_wrapper mt-5">
            <img src="{{ asset('Images/car_images/sample_car.png') }}" alt="Car Image" class="car_image" id="car_image">
        </div>

        <div class="mt-3 container">
            <label class="fw-bold">Upload car image:</label>
            <input class="form-control" type="file" id="car_image_file" accept=".jpg,.jpeg,.png" name="car_image" required>
        </div><br><br>

        <!-- Input fields for car details -->
        <label for="car_make" class="fw-bold">Car Make:</label>
        <input type="text" id="car_make" name="car_make" class="form-control"><br>

        <label for="car_model" class="fw-bold">Car Model:</label>
        <input type="text" id="car_model" name="car_model" class="form-control"><br>

        <label for="carYear" class="form-label">Select Year of Manufacture</label>
        <select name="car_year" id="carYear" class="form-select">
            <option value="" disabled selected>Choose year</option>
            @php
                // Get the current year and set a range of 50 years in the past
                $currentYear = date('Y');
                $startYear = $currentYear - 50;
            @endphp
            @foreach (range($currentYear, $startYear) as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select><br>

        <label for="engine_type" class="fw-bold">Engine Type:</label>
        <input type="text" id="engine_type" name="engine_type" class="form-control"><br>

        <button class="btn btn-dark" type="submit">Submit</button>
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