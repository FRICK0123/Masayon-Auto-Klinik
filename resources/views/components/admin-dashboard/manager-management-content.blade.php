@props(['users'])
<div class="container">
    <h2 class="pb-2 border-bottom">USER MANAGEMENT(manager)</h2>

    <!--Functionalities-->
        <div class="d-flex justify-content-between">
            <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#addUserBackdrop"><small>+ New Manager Account</small></button>

            <form action="#" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Manager">
                    <button class="btn btn-dark" id="basic-addon2">Search</button>
                </div>
            </form>
        </div>
        <!--Filter-->
            <div>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset('icons/funnel.svg')}}" alt="Filter">
                    </button>
                    <form id="userFilterForm" action="{{ route('user_filter') }}" method="GET" class="dropdown-menu p-2">
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
        <!--end-->
    <!--end-->

    <!--User Management Table-->
        <table class="table table-striped table-responsive">
            <tr>
                <th>FULL NAME</th>
                <th>EMAIL</th>
                <th>CONTACT #</th>
                <th>USERNAME</th>
                <th>STATUS</th>
                <th></th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user['fullname'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>0{{ $user['phone_number'] }}</td>
                    <td>{{ $user['username'] }}</td>
                    @if ($user['isVerified'] == 1)
                        <td class="bg-success text-light">verified</td>
                    @elseif($user['isVerified'] == 0 && $user['email_verified_at'] == null)
                        <td class="bg-danger text-light">deactivated</td>
                    @else
                        <td>not verified</td>
                    @endif
                    <td>
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('view_user_info',$user['customerID']) }}">View</a></li>
                                <li><a class="dropdown-item" href="{{ route('add_vehicle_view',$user['customerID']) }}">Add Vehicle</a></li>
                                <li><a class="dropdown-item" href="{{ route('view_user_vehicle_info', $user['customerID']) }}">Add Maintenance Schedule</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item bg-danger text-light" href="#">Deactivate</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
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
</script>