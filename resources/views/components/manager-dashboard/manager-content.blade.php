<div class="dashboard_sidebar bg-dark flex-column align-items-center d-none d-lg-flex" style="height:80%;">
    <!--dashboard links-->
        <div class="container-fluid mt-3 form_links">

            <form action="{{ route('manager_dashboard') }}" method="GET" class="text-white d-flex justify-content-between align-items-center" id="manager_dashboard" onclick="managerDashboard()">
                <p class="m-0">Overview</p>
                <img src="{{asset('icons/newspaper-white.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{ route('customer_management') }}" class="text-white d-flex justify-content-between align-items-center" id="customer_management" onclick="customerManagement()">
                <p class="m-0">Customers</p>
                <img src="{{asset('icons/user-circle.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="{{ route('maintenance_task_view') }}" class="text-white d-flex justify-content-between align-items-center" id="maintenance_tasks" onclick="maintenanceTask()">
                <p class="m-0">Maintenance Tasks</p>
                <img src="{{asset('icons/calendar.svg')}}" alt="Dashboard Icon" class="">
            </form>

            <form action="#" class="text-white d-flex justify-content-between align-items-center">
                <p class="m-0">Reports</p>
                <img src="{{asset('icons/newspaper-white.svg')}}" alt="Dashboard Icon" class="">
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
        function customerManagement(){
            document.getElementById('customer_management').submit();
        }

        function managerDashboard(){
            document.getElementById('manager_dashboard').submit();
        }

        function maintenanceTask(){
            document.getElementById('maintenance_tasks').submit();
        }

        //Logout Form Submittion
        const customer_logout = document.getElementById('customer_logout');
        customer_logout.addEventListener('click',()=>{
            customer_logout.submit();
        });
    </script>