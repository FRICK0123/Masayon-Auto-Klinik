<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" href="{{asset('css/customer_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{asset('css/table_style.css')}}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="body">
    <!--Preloader-->
        <x-preloader/>
    <!--End-->

    <!--Header-->
        <header>
            <x-customer-dashboard.navbar/>
        </header>
    <!--Header end-->

    <!--Main Content-->
        <main>
            <x-customer-dashboard.main-content>
                <div class="container-fluid ms-1 row">
                    <div class="container border border-1 shadow rounded-3 pb-3 col-md-6 border border-1 border-dark">   
                        <div class="d-flex justify-content-center dropdown">
                            <a href="#" class="profile_img_wrapper mt-5" data-bs-toggle="dropdown">
                                <img src="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" alt="Profile Image" class="profile_image">
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" target="_blank">View Profile Image</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileImg">Edit Profile Image</a></li>
                            </ul>
                        </div>
                        <h2 class="text-center mt-2">Good Day, {{ Session::get('fullname') }}!!!</h2> 

                        <div class="profile_details mt-3 text-dark">
                            <p><b>Full Name:</b> {{Session::get('fullname')}}</p>
                            <p><b>Email Address:</b> {{Session::get('email')}}</p>
                            <p><b>Phone Number:</b> +63{{Session::get('phone_number')}}</p>
                            <p><b>Username:</b> {{Session::get('username')}}</p>
                        </div>

                        <div class="d-flex justify-content-evenly">
                            <button class="btn btn-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#editProfileDetails"
                            data-fullname="{{ Session::get('fullname') }}"
                            data-phone="{{ Session::get('phone_number') }}"
                            data-username="{{ Session::get('username') }}"
                            onclick="populateEditDetails(this)">
                                Edit Profile Details
                            </button>

                            <button class="btn btn-outline-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#milageModal">Update Mileage</button>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3 mt-lg-0">
                        <h4 class="text-dark">Previous Transactions</h4>
                        <div class="container">
                            <!-- Card-like table layout -->
                            @foreach ($transactions as $transaction)
                                <div class="card shadow-sm mt-2 bg-dark border border-light" id="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-light">{{ $transaction['vehicle'] }}</h4>
                                        <p class="card-text text-light">
                                            <strong>Maintenance Type:</strong> {{ $transaction['maintenance_type'] }}<br>
                                            <strong>Service Date:</strong> {{ Carbon\Carbon::parse($transaction->date_performed)->format('F j, Y') }}<br>
                                            <strong>Status:</strong> {{$transaction['maintenance_status']}}<br>
                                            <strong>Cost:</strong> ₱{{number_format($transaction['cost'],2)}}<br>
                                        </p>
                                        <a href="#" class="btn btn-light btn-sm rounded-pill"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#view_transaction"
                                        data-owner="{{ $transaction['owner'] }}"
                                        data-vehicle="{{ $transaction['vehicle'] }}"
                                        data-previous-milage="{{ $transaction['previous_milage'] }}"
                                        data-current-milage="{{ $transaction['current_milage'] }}"
                                        data-maintenance-type="{{ $transaction['maintenance_type'] }}"
                                        data-oil-type="{{ $transaction['oil_type'] }}"
                                        data-pms-services="{{ $transaction['pms_services'] }}"
                                        data-cost="{{ $transaction['cost'] }}"
                                        data-date-performed="{{ \Carbon\Carbon::parse($transaction->date_performed)->format('F j, Y') }}"
                                        data-maintenance-description="{{ $transaction['maintenance_description'] }}"
                                        onclick="populateModal(this)">View Details</a>
                                    </div>
                                    <span class="top"></span>
                                    <span class="right"></span>
                                    <span class="bottom"></span>
                                    <span class="left"></span>
                                </div>
                            @endforeach
                            <div class="mt-2">
                                {{ $transactions->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-customer-dashboard.main-content>
        </main>
    <!--End-->

    <!-- Edit Profile Details Modal-->
    <div class="modal fade" id="editProfileDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit Profile Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit_customer_details') }}" method="post">
                        @csrf
                        <label for="fullname">Fullname:</label>
                        <input type="text" class="form-control" name="fullname" id="fullname"><br>

                        <label for="phone">Phone Number:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">+63</span>
                            <input type="text" class="form-control" id="phone" pattern="[9][0-9]{9}" name="phone">
                        </div>

                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" id="username">

                        <button type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-dark mt-2">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--View Transaction-->
    <div class="modal fade" id="view_transaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-dark text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Information</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label class="fw-bold">Owner:</label>
            <p id="owner"></p>

            <label class="fw-bold">Vehicle:</label>
            <p id="vehicle"></p>

            <label class="fw-bold">Previous Mileage:</label>
            <p id="previous_milage"></p>

            <label class="fw-bold">Current Mileage:</label>
            <p id="current_milage"></p>

            <label class="fw-bold">Maintenance Type:</label>
            <p id="maintenance_type"></p>

            <label class="fw-bold" id="oil_type_label">Oil Type:</label>
            <p id="oil_type"></p>

            <label class="fw-bold" id="pms_label">PMS Services:</label>
            <p id="pms_services"></p>


            <label class="fw-bold">Cost:</label>
            <p id="cost"></p>

            <label class="fw-bold">Date Performed:</label>
            <p id="date_performed"></p>

            <label class="fw-bold">Maintenance Description:</label>
            <p id="maintenance_description"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <!--Edit Profile Image Modal -->
    <div class="modal fade" id="editProfileImg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Update Profile Image</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update_profile_image') }}" method="POST" enctype="multipart/form-data" class="container d-flex flex-column justify-content-center align-items-center mt-5">
                        @csrf
                        <label for="profile_image">
                            <div class="edit_profile_img_wrapper">
                                <img src="{{asset('Images/profile_images/'.Session::get('profile_img'))}}" alt="User Profile Image" class="img-fluid edit_profile_image" id="user_image">
                            </div>
                        </label>

                        <div class="mt-3 container">
                            <input class="form-control" type="file" id="profile_image" accept=".jpg,.jpeg,.png" name="profile_image">
                        </div>

                        <div class="btn_wrapper">
                            <button class="btn btn-dark mt-3 w-100">Set as Profile Image</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Image Updated Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="profileImgToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('profile_image') }}
            </div>
        </div>
    </div>

    <!-- Profile Details Updated Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="profileDetailsToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('details_updated') }}
            </div>
        </div>
    </div>

    <!-- Update Mileage Modal -->
    <div class="modal fade" id="milageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update your Current Mileage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="{{ route('update_milage') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="vehicle">Select Vehicle:</label>
                        <select name="milage_update" id="vehicle" class="form-select" required>
                            <option value="" disabled selected>Select a vehicle</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->vehicleID }}">
                                    {{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->year_of_manufacture }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="current_mileage">Enter Current Mileage:</label>
                        <input type="number" name="current_mileage" id="current_mileage" placeholder="Enter Current Mileage" class="form-control" required>
                    </div>
                    <br>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Skip for now</button>
                    <button type="submit" class="btn btn-dark">Update</button>
                </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function populateEditDetails(element){
            const fullname = element.getAttribute('data-fullname');
            const phone_number = element.getAttribute('data-phone');
            const username = element.getAttribute('data-username');

            document.getElementById('fullname').value=fullname;
            document.getElementById('phone').value=phone_number;
            document.getElementById('username').value=username;
        }

        function populateModal(element){
            const owner = element.getAttribute('data-owner');
            const vehicle = element.getAttribute('data-vehicle');
            const previous_milage = element.getAttribute('data-previous-milage');
            const current_milage = element.getAttribute('data-current-milage');
            const maintenance_type = element.getAttribute('data-maintenance-type');
            const oil_type = element.getAttribute('data-oil-type');
            const pms_services = element.getAttribute('data-pms-services');
            const cost = element.getAttribute('data-cost');
            const date_performed = element.getAttribute('data-date-performed');
            const maintenance_description = element.getAttribute('data-maintenance-description');

            document.getElementById('owner').innerHTML = owner;
            document.getElementById('vehicle').innerHTML = vehicle;
            document.getElementById('previous_milage').innerHTML = previous_milage;
            document.getElementById('current_milage').innerHTML = current_milage;
            document.getElementById('maintenance_type').innerHTML = maintenance_type;
            if(oil_type == ""){
                document.getElementById('oil_type_label').style.display = "none";
            }else{
                document.getElementById('oil_type_label').style.display = "block";
            }

            if(pms_services == ""){
                document.getElementById('pms_label').style.display = "none";
            }else{
                document.getElementById('pms_label').style.display = "block";
            }
            document.getElementById('oil_type').innerHTML = oil_type;
            document.getElementById('pms_services').innerHTML = pms_services;
            document.getElementById('cost').innerHTML = `₱ ${cost}`;
            document.getElementById('date_performed').innerHTML = date_performed;
            document.getElementById('maintenance_description').innerHTML = maintenance_description;
        }

       document.getElementById('profile_image').addEventListener('change', function (event) {
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
                    document.getElementById('user_image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        @if (session('profile_image'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('profileImgToast'));
            toastEl.show();
        @endif

        @if (session('details_updated'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('profileDetailsToast'));
            toastEl.show();
        @endif
    </script>
</body>
</html>