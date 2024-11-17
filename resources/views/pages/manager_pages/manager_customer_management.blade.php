<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/manager_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!--Preloader-->
        <x-preloader/>
    <!--End-->

    <!--Header-->
        <header>
            <x-manager-dashboard.header/>
        </header>
    <!--Header end-->
    
    <!--Main Content-->
        <main>            
            <x-manager-dashboard.manager-content>
                <div class="container">
                        <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm mt-5 mt-lg-0">
                            <h5 class="pt-2">CUSTOMERS</h5>
                            
                            <form action="{{ route('customer_management') }}" method="GET" class="search-box">
                                @csrf
                                {{-- <input type="text" class="form-control rounded-5" placeholder="Search Customers" name="search_customers" autocomplete="off"> --}}

                                <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Customer" width="30"></button>
                                <input type="text" class="input-search" placeholder="Search Customer" name="search_customers">
                            </form>
                        </div>
                        <br>
                        <!--Functionalities-->
                            <!--Filter-->
                                <div class="d-flex justify-content-between">
                                    <div class="container d-flex mt-2">
                                        <div class="d-flex align-items-baseline">
                                            <h6>Customers:</h6>
                                            <p>{{ $customerCount }}</p>
                                        </div>

                                        <div class="d-flex align-items-baseline ms-3">
                                            <h6>Active Customers:</h6>
                                            <p>{{ $onlineCount }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="{{asset('icons/bars-filter.svg')}}" alt="Filter">
                                            </button>
                                            <form id="userFilterForm" action="{{ route('customer_management') }}" method="GET" class="dropdown-menu p-2">
                                                <input type="radio" id="by_fullname" name="filter_users" class="form-check-input border border-1 border-dark" value="by_fullname">
                                                <label for="by_fullname" class="ms-2">By Fullname</label><br><br>

                                                <input type="radio" id="by_username" name="filter_users" class="form-check-input border border-1 border-dark" value="by_username">
                                                <label for="by_username" class="ms-2">By Username</label><br><br>

                                                <input type="radio" id="by_creation" name="filter_users" class="form-check-input border border-1 border-dark" value="by_creation">
                                                <label for="by_creation" class="ms-2">By Latest</label><br><br>

                                                <button type="submit" class="btn btn-dark">Filter</button>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            <!--end-->
                        <!--end-->
                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addUserBackdrop" data-bs-toggle="tooltip" title="Add New Customer"><small>+ <img src="{{ asset('icons/user-circle.svg') }}" alt="Customer"></small></button>
                        <!--User Management Table-->
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>USERS</th>
                                    <th class="hide-mobile">CONTACT #</th>
                                    <th class="hide-mobile">USERNAME</th>
                                    <th>STATUS</th>
                                    <th class="hide-mobile">DATE REGISTERED</th>
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
                                        <td class="hide-mobile">0{{ $user['phone_number'] }}</td>
                                        <td class="hide-mobile">{{ $user['username'] }}</td>
                                        @if ($user['isVerified'] == 1 && $user['email_verified_at'] !== null)
                                            <td><span class="badge bg-success p-2">verified</span></td>
                                        @elseif($user['isVerified'] == 0 && $user['email_verified_at'] == null)
                                            <td><span class="badge bg-danger p-2">deactivated</span></td>
                                        @else
                                            <td>not verified</td>
                                        @endif
                                        <td class="hide-mobile">{{ \Carbon\Carbon::parse($user['created_at'])->format('F j, Y') }}</td>

                                        <td>
                                            <a href="{{ route('manager_view_customer_info',$user['customerID']) }}" class="btn btn-primary btn-sm"><img src="{{ asset('icons/eye.svg') }}" alt="View Customer" width="20"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                            {{ $users->appends(request()->input())->links() }}
                        <!--End-->
                    </div>

                    <!--Add New User Modal-->
                        <div class="modal fade" id="addUserBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New User</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('store_customer') }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="password" class="form-control mt-1 border border-1 border-dark" name="register_password" id="register_password" placeholder="********" autocomplete="off" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password must contain at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters long.">
                                        <div class="container d-flex mt-2">
                                            <input type="checkbox" id="showPassword" class="me-2" onclick="showP()">
                                            <label for="showPassword">Show Password</label>
                                        </div><br>  

                                        <button type="button" class="btn border border-dark" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Add User</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    <!--end-->

                    <!-- Customer Added Toast Notification -->
                    <div class="toast-container position-fixed top-0 end-0 p-3">
                        <div id="customerAddedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header bg-success">
                                <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                {{ session('customer_added') }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-manager-dashboard.manager-content>
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

        @if (session('customer_added'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('customerAddedToast'));
            toastEl.show();
        @endif
        
    </script>
</body>
</html>