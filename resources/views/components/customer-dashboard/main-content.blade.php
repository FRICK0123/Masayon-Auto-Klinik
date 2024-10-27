<div class="dashboard_sidebar bg-dark border border-light flex-column align-items-center d-none d-lg-flex">
    <div class="profile_img_wrapper mt-5">
        <img src="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" alt="Profile Image" class="profile_image">
    </div>
    <h5 class="text-light username_heading mt-3">{{Session::get('fullname')}}</h5>
    <p class="text-light email_heading">{{Session::get('email')}}</p>

    <!--dashboard links-->
        <div class="container-fluid mt-3 form_links">

            <form action="{{route('customer_profile')}}" method="GET" class="text-white d-flex justify-content-between align-items-center" id="customer_profile" onclick="profileForm()">
                <p class="m-0">Profile</p>
                <img src="{{asset('icons/user-circle.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{route('customer_dashboard')}}" class="text-white d-flex justify-content-between align-items-center" id="customer_dashboard" onclick="dashboardForm()">
                <p class="m-0">Vehicles</p>
                <img src="{{asset('icons/dashboard.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{ route('appointment_view') }}" class="text-white d-flex justify-content-between align-items-center" id="customer_schedule_appointment" onclick="appointmentForm()">
                <p class="m-0">Appointments</p> 
                <img src="{{asset('icons/calendar-check-white.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{ route('customer_maintenance_schedule') }}" class="text-white d-flex justify-content-between align-items-center" id="customer_maintenance_schedule" onclick="scheduleForm()">
                <p class="m-0">Maintenance Schedule</p>
                <img src="{{asset('icons/calendar.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{route('logout')}}" method="POST" class="text-white d-flex justify-content-between align-items-center" id="customer_logout">
                @csrf
                <p class="m-0">Logout</p>
                <img src="{{asset('icons/power.svg')}}" alt="Dashboard Icon" class="">
            </form>
            
        </div>
    <!--End-->
</div>

<div class="content mt-3">
    {{$slot}}
</div>

<!--Script-->
    <script>
        //Profile Form Submittion
        function profileForm(){
            document.getElementById('customer_profile').submit();
        }
        
        //Dashboard Form Submittion
        function dashboardForm(){
            document.getElementById('customer_dashboard').submit();
        }

        //Maintenance Schedule Form Submittion
        function scheduleForm(){
            document.getElementById('customer_maintenance_schedule').submit();
        }

        //Maintenance Schedule Appointment Form Submittion
        function appointmentForm(){
            document.getElementById('customer_schedule_appointment').submit();
        }

        //Logout Form Submittion
        const customer_logout = document.getElementById('customer_logout');
        customer_logout.addEventListener('click',()=>{
            customer_logout.submit();
        });
    </script>