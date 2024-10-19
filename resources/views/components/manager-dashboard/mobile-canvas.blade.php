<button class="btn btn-light d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobile_sidebar" aria-expanded="false" aria-controls="mobile_sidebar" id="bars">
    <img src="{{asset('icons/hamburger_black.svg')}}" alt="Bars">
</button>
  <div class="collapse collapse-horizontal" id="mobile_sidebar">
    <!--dashboard links-->
        <div class="form_links_mobile card card-body bg-dark">

            <div class="container-fluid d-flex justify-content-end mb-3">
                <button type="button" id="closeSidebarBtn" class="btn btn-light">Close</button>
            </div>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Overview</p>
                <img src="{{asset('icons/newspaper-white.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Customers</p>
                <img src="{{asset('icons/user-circle.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Appointments</p> 
                <img src="{{asset('icons/calendar-check-white.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Maintenance Schedule</p>
                <img src="{{asset('icons/calendar.svg')}}" alt="Dashboard Icon" class="">
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