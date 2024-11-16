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
                        <h5 class="pt-2">Admin Profile</h5>
                    </div>

                    <div class="container">
                        <img src="{{ asset('Images/'.Session::get('admin_logo')) }}" alt="Admin Logo" width="250">

                        <div class="container">
                            <p><strong>Username: </strong>{{Session::get('username')}}</p>
                            <p><strong>Email Account: </strong>{{ Session::get('email') }}</p>
                            <p><strong>Contact Number: </strong>+63{{Session::get('phone_number')}}</p>
                            <p><strong>Password: </strong><a href="#" data-bs-toggle="modal" data-bs-target="#changePassword" data-adminID="{{ Session::get('adminID') }}" onclick="populatePass(this)">change password</a></p>
                        </div>
                    </div>
                </div>
            </x-admin-dashboard.admin-content>
        </main>

            <!--Change User Password-->
                <div class="modal fade" id="changePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Change Password</h1>
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
                                    <input type="password" class="form-control mt-1 border border-1 border-dark" name="new_confirm_password" id="new_confirm_password" placeholder="********" autocomplete="off" required>
                                    <div class="container d-flex mt-2">
                                        <input type="checkbox" id="showNewConfirmPassword" class="me-2" onclick="showNewConfirm()" required>
                                        <label for="showNewConfirmPassword">Show Password</label>
                                    </div><br>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <!--end-->
    <!--End-->

            <!-- Admin Change Password Toast Notification -->
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div id="changePassToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success">
                        <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('password_changed') }}
                    </div>
                </div>
            </div>
    
    <script>
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

        function populatePass(element){
            const adminID = element.getAttribute('data-adminID');

            document.getElementById('changePassForm').action = `/admin-change-password/${adminID}`;
        }

        @if (session('password_changed'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('changePassToast'));
            toastEl.show();
        @endif
    </script>
</body>

</html>