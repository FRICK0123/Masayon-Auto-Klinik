<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm d-none d-md-flex">
    <div class="container-fluid">
        <a href="{{route('homepage')}}" class="masayon_logo">
            <img src="{{asset('Images/Masayon Auto Klinik Logo.png')}}" alt="Masayon Logo" width="80" height="80" class="img-fluid" id="logo">
        </a>

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

                    @php
                        $unconfirmedCount = 0;
                        if (Auth::guard('customer')->check()) {
                            $unconfirmedCount = \App\Models\Notification::where('customerID', Auth::guard('customer')->id())
                                ->where('isConfirmed', false)
                                ->count();
                        }
                    @endphp
                    <li class="nav-item d-flex align-items-center">
                        @if($unconfirmedCount > 0)
                            <div id="notif">
                            </div>
                        @endif
                        <a class="nav-link" href="{{ route('customer_notification_view') }}"><img src="{{ asset('icons/bell-ringing.svg') }}" alt="Notifications" width="20"> <strong>Notifications</strong></a>
                    </li>
                    <li class="nav-item">
                        <form action="{{route('logout')}}" method="POST" class="text-dark d-flex justify-content-between align-items-center nav-link" id="customer_logout" style="cursor: pointer" onclick="logOut()">
                            @csrf
                            <span><img src="{{ asset('icons/power.svg') }}" alt="Logout" width="20"> <strong>Logout</strong></span>
                        </form>
                    </li>
                </ul>
            </div>
    </div>
</nav>

<nav class="bg-white d-flex d-md-none justify-content-between align-items-center ps-3 pe-3" id="mobile_navbar">
    <a href="{{route('homepage')}}" class="masayon_logo">
        <img src="{{asset('Images/Masayon Auto Klinik Logo.png')}}" alt="Masayon Logo" width="80" height="80" class="img-fluid" id="logo">
    </a>

    <a href="{{ route('customer_notification_view') }}">
        @if($unconfirmedCount > 0)
            <div id="notif_mobile"></div>
        @endif
        <img src="{{ asset('icons/bell-ringing.svg') }}" alt="Notifications">
    </a>
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