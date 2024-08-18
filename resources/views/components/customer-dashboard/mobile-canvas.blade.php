  <div class="collapse collapse-horizontal" id="mobile_sidebar">
    <!--dashboard links-->
        <div class="form_links_mobile card card-body bg-dark w-75">

            <div>
                <button>Close</button>
            </div>

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
    const customer_logout_mobile = document.getElementById('customer_logout_mobile');
    function logOut(){
        customer_logout_mobile.submit();
    }
</script>