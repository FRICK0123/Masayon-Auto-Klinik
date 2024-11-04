<nav class="navbar navbar-expand-lg navbar-light bg-dark shadow-sm">
    <div class="container-fluid">
        <div class="masayon_logo">
            <img src="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" alt="Masayon Logo" width="70" height="70" class="img-fluid" id="logo">
        </div>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('manager_dashboard') }}"><img src="{{ asset('icons/newspaper-white.svg') }}" alt="Overview" width="20"> <strong>Overview</strong></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('customer_management') }}"><img src="{{ asset('icons/user-circle.svg') }}" alt="Customers" width="20"> <strong>Customers</strong></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('manager_appointment') }}"><img src="{{ asset('icons/calendar-check-white.svg') }}" alt="Appointments" width="20"> <strong>Appointments</strong></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('maintenance_task_view') }}"><img src="{{ asset('icons/calendar-white.svg') }}" alt="Maintenance Tasks" width="20"> <strong>Maintenance Tasks</strong></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('manager_reports_view') }}"><img src="{{ asset('icons/newspaper-white.svg') }}" alt="Maintenance Tasks" width="20"> <strong>Reports</strong></a>
                    </li>

                    <li class="nav-item">
                        <form action="{{route('logout')}}" method="POST" class="text-light d-flex justify-content-between align-items-center nav-link" id="customer_logout" style="cursor: pointer" onclick="logOut()">
                            @csrf
                            <span><img src="{{ asset('icons/power-white.svg') }}" alt="Logout" width="20"> <strong>Logout</strong></span>
                        </form>
                    </li>
                </ul>
                <!-- Right-aligned link -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        @auth('customer')
                            <a class="nav-link text-light" href="{{route('homepage')}}"><img src="{{ asset('icons/house-white.svg') }}" alt="Vehicles" width="20"> <strong>Homepage</strong></a>
                        @endauth
                    </li>
                </ul>
            </div>
    </div>
</nav>

<!--Script-->
<script>
    const homepage = document.getElementById('homepage');

    function homePage(){
        homepage.submit();
    }

    const customer_logout_mobile = document.getElementById('customer_logout');
    function logOut(){
        customer_logout_mobile.submit();
    }
</script>