@props(['cars'])

<div class="container">
    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
        <h5 class="pt-2">CARS</h5>

        <form action="{{ route('car_form') }}" method="get">
            <button class="btn btn-dark"><small>+ ADD CAR </small></button>
        </form>
    </div>

    <!--Functionalities-->
        <div class="d-flex justify-content-between mt-2 mb-2">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('icons/funnel.svg')}}" alt="Filter">
                </button>
                <form id="carFilterForm" action="{{ route('car_filter') }}" method="GET" class="dropdown-menu p-2">
                    <input type="radio" id="by_make" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_make">
                    <label for="by_make" class="ms-2">By Make</label><br><br>

                    <input type="radio" id="by_model" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_model">
                    <label for="by_model" class="ms-2">By Model</label><br><br>

                    <input type="radio" id="by_year" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_year">
                    <label for="by_year" class="ms-2">By Year</label><br><br>

                    <button type="submit" class="btn btn-dark">Filter</button>
                </form>
            </div>

            <form action="{{ route('admin_cars') }}" method="GET" class="search-box">
                 @csrf
                <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Cars" width="30"></button>
                <input type="text" class="input-search" placeholder="Search Cars" name="search_cars">
            </form>
        </div>
    <!--end-->

    <!--Cars table-->
    <div id="carTableContainer" class="table-responsive">
        <table class="table table-striped">
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
                    <td><img src="{{ asset('Images/car_images/'.$car['car_image']) }}" alt="Car Image" width="100" height="100" style="border-radius: 50%"></td>
                    <td>{{ $car['car_make'] }}</td>
                    <td>{{ $car['car_model'] }}</td>
                    <td>{{ $car['year_of_manufacture'] }}</td>
                    <td>{{ $car['engine_type'] }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#"
                                       data-bs-toggle="modal"
                                       data-bs-target="#editBackdrop"
                                       data-car-id="{{ $car['id'] }}"
                                       data-car-image="{{ asset('Images/car_images/'.$car['car_image']) }}"
                                       data-car-make="{{ $car['car_make'] }}"
                                       data-car-model="{{ $car['car_model'] }}"
                                       data-car-year="{{ $car['year_of_manufacture'] }}"
                                       data-car-engine="{{ $car['engine_type'] }}"
                                       onclick="populateModal(this)">
                                        Edit
                                    </a>
                                </li>
                                <li><a class="dropdown-item bg-danger text-light" href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteBackdrop"
                                    data-car-id-delete="{{ $car['id'] }}"
                                    onclick="deleteCar(this)">
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <!--End-->
</div>

<!--Edit Modal-->
    <div class="modal fade" id="editBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Car Information</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="editCarForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="car_id" name="car_id">

                <!-- Car Image -->
                <div class="mb-3">
                    <label for="car_image" class="form-label">Car Image</label>
                    <div>
                        <img id="car_image_preview" src="" alt="Car Image" width="150" height="150">
                    </div>
                    <input type="file" class="form-control mt-2" id="car_image" name="car_image">
                </div>

                <!-- Car Make -->
                <div class="mb-3">
                    <label for="car_make" class="form-label">Car Make</label>
                    <input type="text" class="form-control" id="car_make" name="car_make" required>
                </div>

                <!-- Car Model -->
                <div class="mb-3">
                    <label for="car_model" class="form-label">Car Model</label>
                    <input type="text" class="form-control" id="car_model" name="car_model" required>
                </div>

                <!-- Year of Manufacture -->
                <div class="mb-3">
                    <label for="car_year" class="form-label">Year of Manufacture</label>
                    <input type="number" class="form-control" id="car_year" name="car_year" required>
                </div>

                <!-- Engine Type -->
                <div class="mb-3">
                    <label for="engine_type" class="form-label">Engine Type</label>
                    <input type="text" class="form-control" id="engine_type" name="engine_type" required>
                </div>
                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        </div>
    </div>
    </div>
<!--end-->

<!--Delete Modal-->
    <div class="modal fade" id="deleteBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Car</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteCarForm" action="#" method="POST">
                    @csrf
                    @method('delete')
                    <h3>Do you want to delete this car</h3><br><br>                
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
<!--end-->

<!-- Car Added Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="carAddedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto text-light">Masayon Auto Klinik</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('car_added') }}
        </div>
    </div>
</div>

<!-- Car Details Edit Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="carEditedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto text-light">Masayon Auto Klinik</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('car_edited') }}
        </div>
    </div>
</div>

<!-- Car Delete Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="carDeletedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto text-light">Masayon Auto Klinik</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('car_deleted') }}
        </div>
    </div>
</div>

<script>
    //Edit Option
    function populateModal(element) {
        // Get data from clicked edit button
        const carId = element.getAttribute('data-car-id');
        const carImage = element.getAttribute('data-car-image');
        const carMake = element.getAttribute('data-car-make');
        const carModel = element.getAttribute('data-car-model');
        const carYear = element.getAttribute('data-car-year');
        const carEngine = element.getAttribute('data-car-engine');

        // Populate modal fields
        document.getElementById('car_id').value = carId;
        document.getElementById('car_image_preview').src = carImage;
        document.getElementById('car_make').value = carMake;
        document.getElementById('car_model').value = carModel;
        document.getElementById('car_year').value = carYear;
        document.getElementById('engine_type').value = carEngine;
        document.getElementById('editCarForm').action = `/edit_car/${carId}`;
    }

    //Delete option
    function deleteCar(element){
        const carId = element.getAttribute('data-car-id-delete');
        document.getElementById('deleteCarForm').action = `/delete_car/${carId}`;
    }

        @if (session('car_added'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('carAddedToast'));
            toastEl.show();
        @endif

        @if (session('car_edited'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('carEditedToast'));
            toastEl.show();
        @endif

        @if (session('car_deleted'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('carDeletedToast'));
            toastEl.show();
        @endif
</script>