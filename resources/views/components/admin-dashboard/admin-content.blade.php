<!--Sidebar-->
    <div class="admin_sidebar d-flex flex-column d-none d-lg-flex">
        <div class="d-flex align-items-center">
            <img src="{{ asset('Images/Masayon Auto Klinik Logo.png') }}" alt="Masayon Auto Klinik Logo" width="100">
            <div class="ms-3">
                <h4 class="m-0 p-0">Admin</h4>
                <small class="m-0 p-0 text-success"><img src="{{ asset('icons/online_dot.png') }}" alt="Online" width="15">online</small>
            </div>
        </div>

        <!--dashboard links-->
            <div class="container-fluid mt-4 form_links">
                <form action="{{ route('admin_dashboard') }}"  method="GET" class="d-flex align-items-center {{ request()->routeIs('admin_dashboard') ? 'active' : '' }}" id="admin_dashboard" onclick="adminDashboard()">
                    <img src="{{asset('icons/dashboard_black.svg')}}" alt="Dashboard Icon" class="me-2">
                    <p class="m-0">Dashboard</p>
                </form>

                <a class="d-flex align-items-center justify-content-between maintenance_container" data-bs-toggle="collapse" href="#user_management" role="button" aria-expanded="false" aria-controls="user_management">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('icons/gear-fine.svg')}}" alt="Maintenance Overview" class="me-2">
                        <p class="m-0">User Management</p>
                    </div>

                    <p class="m-0 fs-5">></p>
                </a>
                <!--User Management collapsible items-->
                    <div class="collapse ms-2" id="user_management">                        
                        <form action="{{ route('users_view') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('users_view') ? 'active' : '' }}" id="admin_user_management" onclick="adminUserManagement()">
                            <img src="{{asset('icons/users.svg')}}" alt="Users Icon" class="me-2">
                            <p class="m-0">Customers</p>
                        </form>

                        <form action="{{ route('managers_view') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('managers_view') ? 'active' : '' }}" id="admin_manager_management" onclick="adminManagerManagement()">
                            <img src="{{asset('icons/user-gear.svg')}}" alt="Users Icon" class="me-2">
                            <p class="m-0">Managers</p>
                        </form>
                    </div>
                <!--end-->

                <form action="{{ route('admin_cars') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('admin_cars') ? 'active' : '' }}" id="admin_cars" onclick="adminCars()">
                    <img src="{{asset('icons/car-profile.svg')}}" alt="Cars Icon" class="me-2">
                    <p class="m-0">Cars</p>
                </form>

                <form action="{{ route('admin_appointment_view') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('admin_appointment_view') ? 'active' : '' }}" id="appointment" onclick="adminAppointment()">
                    <img src="{{asset('icons/calendar-check.svg')}}" alt="Reports" class="me-2">
                    <p class="m-0">Appointments</p>
                </form>

                <a class="d-flex align-items-center justify-content-between maintenance_container" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('icons/gear-fine.svg')}}" alt="Maintenance Overview" class="me-2">
                        <p class="m-0">Maintenance</p>
                    </div>

                    <p class="m-0 fs-5">></p>
                </a>

                <!--Maintenance collapsible items-->
                    <div class="collapse ms-2" id="collapseExample">            
                        <form action="{{ route('maintenance_overview') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('maintenance_overview') ? 'active' : '' }}" id="maintenance_overview" onclick="adminMaintenanceOverview()">
                            <img src="{{asset('icons/gear-fine.svg')}}" alt="Maintenance Overview" class="me-2">
                            <p class="m-0">Maintenance Overview</p>
                        </form>

                        <form action="{{ route('maintenance_status_view') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('maintenance_status_view') ? 'active' : '' }}" id="maintenance_status" onclick="adminMaintenanceStatus()">
                            <img src="{{asset('icons/pulse.svg')}}" alt="Maintenance Status" class="me-2">
                            <p class="m-0">Maintenance Status</p>
                        </form>
                    </div>
                <!--end-->

                <a class="d-flex align-items-center justify-content-between maintenance_container" data-bs-toggle="collapse" href="#report" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('icons/newspaper.svg')}}" alt="Maintenance Overview" class="me-2">
                        <p class="m-0">Reports</p>
                    </div>

                    <p class="m-0 fs-5">></p>
                </a>

                <!--Reports Collapsibble items-->
                    <div class="collapse ms-2" id="report">            
                        <form action="{{ route('reports_view') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('reports_view') ? 'active' : '' }}" id="reports" onclick="adminReports()">
                            <img src="{{asset('icons/newspaper.svg')}}" alt="Reports" class="me-2">
                            <p class="m-0">Transactions</p>
                        </form>

                        <form action="{{ route('customer_reports_view') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('customer_reports_view') ? 'active' : '' }}" id="customer_reports" onclick="adminCustomerReports()">
                            <img src="{{asset('icons/newspaper.svg')}}" alt="Maintenance Status" class="me-2">
                            <p class="m-0">Customer Registrations</p>
                        </form>
                    </div>
                <!--end-->

                <form action="{{ route('notification_view') }}" method="GET" class="d-flex align-items-center {{ request()->routeIs('notification_view') ? 'active' : '' }}" id="admin_notifications" onclick="adminNotifications()">
                    <img src="{{asset('icons/bell-ringing.svg')}}" alt="Notifications" class="me-2">
                    <p class="m-0">Notifications</p>
                </form>
            </div>
        <!--End-->
    </div>
<!--end-->

<!--Content-->
    <div class="admin_content">
        {{$slot}}
    </div>
<!--End-->

<!--script-->
    <script>
        function adminDashboard(){
            document.getElementById('admin_dashboard').submit();
        }

        function adminCars(){
            document.getElementById('admin_cars').submit();
        }

        function adminUserManagement(){
            document.getElementById('admin_user_management').submit();
        }

        function adminManagerManagement(){
            document.getElementById('admin_manager_management').submit();
        }

        function adminMaintenanceOverview(){
            document.getElementById('maintenance_overview').submit();
        }

        function adminMaintenanceStatus(){
            document.getElementById('maintenance_status').submit();
        }

        function adminReports(){
            document.getElementById('reports').submit();
        }

        function adminCustomerReports(){
            document.getElementById('customer_reports').submit();
        }

        function adminAppointment(){
            document.getElementById('appointment').submit();
        }

        function adminNotifications(){
            document.getElementById('admin_notifications').submit();
        }
    </script>
<!--end-->