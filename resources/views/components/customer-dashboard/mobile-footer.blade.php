<div class="p-3 bg-white shadow-sm d-flex justify-content-around">
    <form action="{{route('logout')}}" method="POST" id="customer_logout" style="cursor: pointer" onclick="logOut()">
        @csrf
        <img src="{{ asset('icons/power.svg') }}" alt="Logout">
    </form>

    <a href="{{route('appointment_view')}}">
        <img src="{{ asset('icons/calendar-check.svg') }}" alt="Appointments">
    </a>

    <a href="{{route('customer_dashboard')}}">
        <img src="{{ asset('icons/house.svg') }}" alt="Home">
    </a>

    <a href="{{route('customer_maintenance_schedule')}}">
        <img src="{{ asset('icons/calendar.svg') }}" alt="Maintenance Schedule">
    </a>

    <a href="{{route('customer_profile')}}" class="profile_icon_wrapper">
        <img src="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" alt="profile" class="profile_icon">
    </a>
</div>

<!--Script-->
<script>
    const customer_logout_app = document.getElementById('customer_logout');
    function logOut(){
        customer_logout_app.submit();
    }
</script>