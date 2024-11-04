

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

        function managerAppointment(){
            document.getElementById('appointments').submit();
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