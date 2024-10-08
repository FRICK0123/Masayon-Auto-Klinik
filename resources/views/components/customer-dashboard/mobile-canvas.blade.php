<button class="btn d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobile_sidebar" aria-expanded="false" aria-controls="mobile_sidebar" id="bars">
    <img src="{{asset('icons/hamburger_black.svg')}}" alt="Bars">
</button>
  <div class="collapse collapse-horizontal" id="mobile_sidebar">
    <!--dashboard links-->
        <div class="form_links_mobile card card-body bg-dark">

            <div class="container-fluid d-flex justify-content-end mb-3">
                <button type="button" id="closeSidebarBtn" class="btn btn-light">Close</button>
            </div>

            <form action="{{route('customer_profile')}}" class="text-white d-flex justify-content-between align-items-center" id="customer_profile" onclick="profile()">
                <p class="m-0">Profile</p>
                <img src="{{asset('icons/user-circle.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{route('customer_dashboard')}}" class="text-white d-flex justify-content-between align-items-center" id="customer_dashboard" onclick="dashBoard()">
                <p class="m-0">Dashboard</p>
                <img src="{{asset('icons/dashboard.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{ route('appointment_view') }}" class="text-white d-flex justify-content-between align-items-center" id="customer_schedule_appointment" onclick="appointmentForm()">
                <p class="m-0">Appointments</p> 
                <img src="{{asset('icons/calendar-check-white.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{route('customer_maintenance_schedule')}}" class="text-white d-flex justify-content-between align-items-center" id="customer_maintenance_schedule" onclick="maintenanceSchedule()">
                <p class="m-0">Maintenance Schedule</p>
                <img src="{{asset('icons/calendar.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Maintenance History</p>
                <img src="{{asset('icons/history.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{route('logout')}}" method="POST" class="text-white d-flex justify-content-between align-items-center" id="customer_logout_mobile" onclick="logOut()">
                @csrf
                <p class="m-0">Logout</p>
                <img src="{{asset('icons/power.svg')}}" alt="Dashboard Icon" class="">
            </form>
        </div>
    <!--End-->
  </div>

<!--Script-->
<script>
    //Mobile
    //Customer Profile
        const customer_profile_mobile = document.getElementById('customer_profile');
        function profile(){
            customer_profile_mobile.submit();
        }

   //Customer Dashboard
        const customer_dashboard_mobile = document.getElementById('customer_dashboard');
        function dashBoard(){
            customer_dashboard_mobile.submit();
        }

    //Customer Maintenance Dashboard
    const customer_maintenance_schedule = document.getElementById('customer_maintenance_schedule');
    function maintenanceSchedule(){
        customer_maintenance_schedule.submit();
    }

    //logout
        const customer_logout_mobile = document.getElementById('customer_logout_mobile');
        function logOut(){
            customer_logout_mobile.submit();
        }

    // Add event listener to the "Close" button
        document.getElementById('closeSidebarBtn').addEventListener('click', function() {
            const mobileSidebar = document.getElementById('mobile_sidebar');
            const bsCollapse = new bootstrap.Collapse(mobileSidebar, {
                toggle: true
            });
            bsCollapse.hide();  // This will hide the collapse
        });
</script>