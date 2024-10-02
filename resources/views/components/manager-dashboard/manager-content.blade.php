<!--Sidebar-->
    <div class="manager_sidebar d-flex flex-column d-none d-lg-flex">
        <div class="d-flex align-items-center">
            <img src="{{ asset('Images/Masayon Auto Klinik Logo.png') }}" alt="Masayon Auto Klinik Logo" width="100">
            <h4 class="ms-3">Manager</h4>
        </div>

        <!--dashboard links-->
            <div class="container-fluid mt-4 form_links">
                <form action="{{ route('admin_dashboard') }}" method="GET" class="d-flex align-items-center" id="admin_dashboard" onclick="adminDashboard()">
                    <img src="{{asset('icons/dashboard_black.svg')}}" alt="Dashboard Icon" class="me-2">
                    <p class="m-0">Dashboard</p>
                </form>
            </div>
        <!--End-->
    </div>
<!--end-->

<!--Content-->
    <div class="manager_content">
        {{$slot}}
    </div>
<!--End-->

<!--script-->
    <script>
        // function adminDashboard(){
        //     document.getElementById('admin_dashboard').submit();
        // }
    </script>
<!--end-->