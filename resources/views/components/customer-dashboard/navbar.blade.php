{{-- <nav class="d-flex justify-content-between align-items-center p-2 mt-2 ms-2 me-2 border-bottom border-light" id="nav">
    <div class="masayon_logo">
        <img src="{{asset('Images/Masayon Auto Klinik Logo.png')}}" alt="Masayon Logo" width="100" height="100" class="img-fluid" id="logo">
    </div>

    <!--Login link/button to be directed to Login page-->
    @auth('customer')
        <form action="{{route('homepage')}}" class="text-white d-flex justify-content-center align-items-center me-lg-5" id="homepage" onclick="homePage()">
            <img src="{{asset('icons/house.svg')}}" alt="Dashboard Icon" class="me-2">
            <h6 class="m-0 d-none d-lg-block">Homepage</h6>
        </form>
    @endauth
    <!--Login link/button to be directed to Login page End-->
</nav> --}}

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <div class="masayon_logo">
            <img src="{{asset('Images/Masayon Auto Klinik Logo.png')}}" alt="Masayon Logo" width="80" height="80" class="img-fluid" id="logo">
        </div>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('customer_profile')}}"><img src="{{ asset('icons/user-circle-dark.svg') }}" alt="Vehicles" width="20"> <strong>Profile</strong></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('customer_dashboard')}}"><img src="{{ asset('icons/car.svg') }}" alt="Vehicles" width="20"> <strong>Vehicles</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('appointment_view') }}"><img src="{{ asset('icons/calendar-check.svg') }}" alt="Appointments" width="20"> <strong>Appointments</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer_maintenance_schedule') }}"><img src="{{ asset('icons/calendar.svg') }}" alt="Maintenance Schedule" width="20"> <strong>Maintenance Schedule</strong></a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <div id="notif"></div>
                        <a class="nav-link" href="#"><img src="{{ asset('icons/bell-ringing.svg') }}" alt="Notifications" width="20"> <strong>Notifications</strong></a>
                    </li>
                    <li class="nav-item">
                        <form action="{{route('logout')}}" method="POST" class="text-dark d-flex justify-content-between align-items-center nav-link" id="customer_logout" style="cursor: pointer" onclick="logOut()">
                            @csrf
                            <span><img src="{{ asset('icons/power.svg') }}" alt="Logout" width="20"> <strong>Logout</strong></span>
                        </form>
                    </li>
                </ul>
                <!-- Right-aligned link -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        @auth('customer')
                            <a class="nav-link" href="{{route('homepage')}}"><img src="{{ asset('icons/house.svg') }}" alt="Vehicles" width="20"> <strong>Homepage</strong></a>
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