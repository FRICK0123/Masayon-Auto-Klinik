@props(['schedules'])
<div class="container row">
    <h2 class="pb-2 border-bottom">DASHBOARD</h2>

    <div class="col-md-3">
        <div class="border border-success d-flex flex-column align-items-center mt-3" style="height: 200px">
            <img src="{{ asset('icons/users.svg') }}" alt="Customers" width="100" height="100">
            <h3>CUSTOMERS:</h3>
            <h5>0</h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-secondary d-flex flex-column align-items-center mt-3" style="height: 200px">
            <img src="{{ asset('icons/car.svg') }}" alt="Customers" width="100" height="100">
            <h3>CUSTOMER CARS:</h3>
            <h5>0</h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-danger d-flex flex-column align-items-center mt-3" style="height: 200px">
            <img src="{{ asset('icons/gear-fine.svg') }}" alt="Customers" width="100" height="100">
            <h5 class="text-center">UPCOMING MAINTENANCE TASKS:</h5>
            <h5>0</h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="border border-warning d-flex flex-column align-items-center mt-3" style="height: 200px">
            <img src="{{ asset('icons/bell-ringing.svg') }}" alt="Customers" width="100" height="100">
            <h5 class="text-center">NOTIFICATIONS SENT:</h5>
            <h5>0</h5>
        </div>
    </div>
</div>
<br><br>
<div class="container">
   <!--Cars table-->
        <table class="table table-striped table-responsive">
            <tr>
                <th>VEHICLE</th>
                <th>OWNER</th>
                <th>MAINTENANCE TYPE</th>
                <th>SCHEDULED DATE</th>
                <th>SCHEDULED MILAGE</th>
                <th></th>
            </tr>
        </table>
    <!--End-->
</div>