<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/admin_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <!--Preloader-->
        <x-preloader/>
    <!--End-->
    <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Do you want to log out?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log out</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    <!--end-->

    <!--Header-->
        <header style="position: fixed; width: 100%; z-index: 100;">
            <x-admin-dashboard.header/>
        </header>
    <!--Header end-->

    <!--Main Content-->
    <main>
        <x-admin-dashboard.admin-content>
            <div class="container">
                <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
                    <h5 class="pt-2">USER MANAGEMENT(manager)</h5>
    
                    <form action="#" method="GET" class="search-box">
                        @csrf
                        {{-- <input type="text" class="form-control rounded-5" placeholder="Search Customers" name="search_customers" autocomplete="off"> --}}

                        <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Customer" width="30"></button>
                        <input type="text" class="input-search" placeholder="Search Customer" name="search_customers">
                    </form>
                </div><br>

                <!--Functionalities-->
                    <div class="d-flex justify-content-between">
                        <div class="d-flex w-100">
                            <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#addUserBackdrop"><small>+ <img src="{{ asset('icons/user-gear-white.svg') }}" alt="Manager"></small></button>

                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset('icons/bars-filter.svg')}}" alt="Filter">
                                </button>
                                <form id="userFilterForm" action="{{ route('manager_filter') }}" method="GET" class="dropdown-menu p-2">
                                    <input type="radio" id="by_fullname" name="filter_managers" class="form-check-input border border-1 border-dark" value="by_fullname">
                                    <label for="by_fullname" class="ms-2">By Fullname</label><br><br>

                                    <input type="radio" id="by_username" name="filter_managers" class="form-check-input border border-1 border-dark" value="by_username">
                                    <label for="by_username" class="ms-2">By Username</label><br><br>

                                    <input type="radio" id="by_creation" name="filter_managers" class="form-check-input border border-1 border-dark" value="by_creation">
                                    <label for="by_creation" class="ms-2">By Latest</label><br><br>

                                    <button type="submit" class="btn btn-dark">Filter</button>
                                </form>
                            </div>
                        </div>
                        <div class="container d-flex justify-content-end mt-2">
                            <div class="d-flex align-items-baseline">
                                <h6>Managers:</h6>
                                <p>{{ $managerCount }}</p>
                            </div>

                            <div class="d-flex align-items-baseline ms-3">
                                <h6>Active Managers:</h6>
                                <p>{{ $onlineCount }}</p>
                            </div>
                        </div>
                    </div>
                <!--end-->
                <div class="mt-2">
                    <!--User Management Table-->
                        <table class="table">
                            <tr>
                                <th>USERS</th>
                                <th>CONTACT #</th>
                                <th>USERNAME</th>
                                <th>STATUS</th>
                                <th>DATE REGISTERED</th>
                                <th></th>
                            </tr>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="d-flex">
                                        @php
                                            $lastSeen = \Carbon\Carbon::parse($user['last_seen']);
                                            $isOnline = $lastSeen->diffInMinutes(now()) <= 3; // Check if last seen is within 3 minutes
                                        @endphp

                                        @if ($isOnline)
                                            <small><img src="{{ asset('icons/online_dot.png') }}" alt="Online" width="15"></small>
                                        @else
                                            <small><img src="{{ asset('icons/offline_dot.png') }}" alt="Online" width="10"></small>
                                        @endif
                                        
                                        <img src="{{ asset('Images/profile_images/'.$user['profile_img']) }}" alt="Profile Icon" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
                                        <div class="d-flex flex-column ms-3">
                                            <span>{{ $user['fullname'] }}</span>
                                            <span style="font-size: 13px">{{ $user['email'] }}</span>
                                        </div>
                                    </td>
                                    <td>0{{ $user['phone_number'] }}</td>
                                    <td>{{ $user['username'] }}</td>
                                    @if ($user['isVerified'] == 1 && $user['email_verified_at'] !== null)
                                        <td><span class="badge bg-success p-2">verified</span></td>
                                    @elseif($user['isVerified'] == 0 && $user['email_verified_at'] == null)
                                        <td><span class="badge bg-danger p-2">deactivated</span></td>
                                    @else
                                        <td>not verified</td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('F j, Y') }}</td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('view_manager_info',$user['customerID']) }}">View</a></li>

                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePassword" data-customerID="{{ $user['customerID'] }}" data-fullname="{{ $user['fullname'] }}" onclick="populatePass(this)">Change Password</a></li>

                                                <li><a class="dropdown-item" href="{{ route('edit_user_info_view',$user['customerID']) }}">Edit</a></li>

                                                <li>
                                                    @if ($user['isVerified'] == 1 && $user['email_verified_at'] !== null)
                                                        <a class="dropdown-item bg-danger text-light" href="#">Deactivate</a>
                                                    @else
                                                        <a class="dropdown-item bg-success text-light" href="#">Activate</a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    <!--End-->
                </div>
            </div>

            <!--Change User Password-->
                <div class="modal fade" id="changePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Change Password for <span id="fullname"></span></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" id="changePassForm">
                            @csrf
                            <!--New Password-->
                            <label for="new_password">New Password:</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="********">
                            <div class="container d-flex mt-2">
                                <input type="checkbox" id="new_password_checkbox" class="me-2" onclick="showNewPass()">
                                <label for="new_password_checkbox">Show Password</label>
                            </div>

                            <!--Confirm Password-->
                            <label for="new_confirm_password" class="fw-bold mt-4">Confirm Password:</label>
                            <input type="password" class="form-control mt-1 border border-1 border-dark" name="new_confirm_password" id="new_confirm_password" placeholder="********" autocomplete="off">
                            <div class="container d-flex mt-2">
                                <input type="checkbox" id="showNewConfirmPassword" class="me-2" onclick="showNewConfirm()">
                                <label for="showNewConfirmPassword">Show Password</label>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            <!--end-->

            <!--Add New User Modal-->
                <div class="modal fade" id="addUserBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('store_manager') }}" method="POST">
                                @csrf
                                <!--Profile Image-->
                                <div class="car_img_wrapper mt-5">
                                    <img src="{{ asset('Images/profile_images/default_user.png') }}" alt="Car Image" class="car_image" id="car_image">
                                </div>

                                <div class="mt-3 container">
                                    <label class="fw-bold">Upload profile image:</label>
                                    <input class="form-control" type="file" id="car_image_file" accept=".jpg,.jpeg,.png" name="profile_image">
                                </div><br><br>

                                <!--Full Name-->
                                <label for="register_fullname" class="fw-bold">Full Name:</label>
                                <input type="text" class="form-control mt-1 border border-1 border-dark" name="register_fullname" id="register_fullname" placeholder="Enter Full Name" autocomplete="on" required><br>

                                <!--Email-->
                                <label for="register_email" class="fw-bold">Email:</label>
                                <input type="email" class="form-control mt-1 border border-1 border-dark" name="register_email" id="register_email" placeholder="Enter Email Address" autocomplete="on" required>

                                <!--Phone Number-->
                                <label for="register_phone" class="fw-bold mt-4">Phone Number:</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">+63</span>
                                    <input type="text" class="form-control" placeholder="9705678909" id="register_phone" pattern="[9][0-9]{9}" name="register_phone" required>
                                </div>

                                <!--Username-->
                                <label for="register_username" class="fw-bold">Username:</label>
                                <input type="text" class="form-control mt-1 border border-1 border-dark" name="register_username" id="register_username" placeholder="Enter Username" autocomplete="on" required>

                                <!--Password-->
                                <label for="register_password" class="fw-bold mt-4">Password:</label>
                                <input type="password" class="form-control mt-1 border border-1 border-dark" name="register_password" id="register_password" placeholder="********" autocomplete="off" required>
                                <div class="container d-flex mt-2">
                                    <input type="checkbox" id="showPassword" class="me-2" onclick="showP()">
                                    <label for="showPassword">Show Password</label>
                                </div><br>  

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            <!--end-->
        </x-admin-dashboard.admin-content>
    </main>
    <!--End-->

    <script>
        let password_field = document.getElementById('register_password');
        let confirm_password_field = document.getElementById('confirm_password');
        let password_checkbox = document.getElementById('showPassword');
        let confirm_password_checkbox = document.getElementById('showConfirmPassword');
        function showP(){
            if(password_checkbox.checked == true){
                password_field.type = "text";
            } else {
                password_field.type = "password"
            }
        }

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

        //Show Password Functions (modal of change password)
        let new_password = document.getElementById('new_password');
        let new_confirm_password = document.getElementById('new_confirm_password');
        let new_password_checkbox = document.getElementById('new_password_checkbox');
        let new_confirm_password_checkbox = document.getElementById('showNewConfirmPassword');


        function showNewPass(){
            if(new_password_checkbox.checked == true){
                new_password.type = "text";
            } else {
                new_password.type = "password"
            }
        }

        function showNewConfirm(){
            if(new_confirm_password_checkbox.checked == true){
                new_confirm_password.type = "text";
            } else {
                new_confirm_password.type = "password"
            }
        }

        //Change Password Modal Script
        function populatePass(element){
            const customerID = element.getAttribute('data-customerID');
            const fullname = element.getAttribute('data-fullname');

            document.getElementById('fullname').innerHTML = fullname;
            document.getElementById('changePassForm').action = `/change_password/${customerID}`;
        }
    </script>
</body>

</html>