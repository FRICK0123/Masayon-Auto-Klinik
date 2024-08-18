<div class="dashboard_sidebar bg-dark flex-column align-items-center d-none d-lg-flex">
    <div class="profile_img_wrapper mt-5">
        <img src="{{asset('Images/profile_images/default_user.png')}}" alt="Profile Image" class="profile_image">
    </div>
    <h5 class="text-light username_heading mt-3">Freak123</h5>
    <p class="text-light email_heading">paculbafrick1@gmail.com</p>

    <!--dashboard links-->
        <div class="container-fluid mt-5 form_links">

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Profile</p>
                <img src="{{asset('icons/user-circle.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Dashboard</p>
                <img src="{{asset('icons/dashboard.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Maintenance Schedule</p>
                <img src="{{asset('icons/calendar.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Maintenance History</p>
                <img src="{{asset('icons/history.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{route('logout')}}" method="POST" class="text-white d-flex justify-content-between align-items-center" id="customer_logout">
                @csrf
                <p class="m-0">Logout</p>
                <img src="{{asset('icons/power.svg')}}" alt="Dashboard Icon" class="">
            </form>
        </div>
    <!--End-->
</div>

<div class="dashboard_content">

</div>

<!--Script-->
    <script>
        const customer_logout = document.getElementById('customer_logout');
        customer_logout.addEventListener('click',()=>{
            customer_logout.submit();
        });
    </script>