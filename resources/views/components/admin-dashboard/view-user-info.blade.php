@props(['customer','vehicles','previous_maintenance'])
<div class="container">
    <h4 class="p-2 border rounded-3 shadow-sm">USER</h4>

    <div class="container row">
        <div class="col-md-4 border rounded-3 p-2">
            <!--Profile Image-->
            <div class="customer_img_wrapper mt-1">
                <img src="{{ asset('Images/profile_images/'.$customer['profile_img']) }}" alt="Car Image" class="customer_image" id="car_image">
            </div>

            <small class="fw-bold me-2">Fullname:</small>
            <p class="border-bottom" style="text-overflow: ellipsis; overflow:hidden;">{{ $customer['fullname'] }}</p>

            <small class="fw-bold me-2">Email:</small>
            <p class="border-bottom" style="text-overflow: ellipsis; overflow:hidden;">{{ $customer['email'] }}</p>

            <small class="fw-bold me-2">Phone Number:</small>
            <p class="border-bottom" style="text-overflow: ellipsis; overflow:hidden;">+63{{ $customer['phone_number'] }}</p>

            <small class="fw-bold me-2">Username:</small>
            <p class="border-bottom" style="text-overflow: ellipsis; overflow:hidden;">{{ $customer['username'] }}</p>

            <small class="fw-bold me-2">Account Status:</small>
            @if ($customer['isVerified'] == true && $customer['email_verified_at'] !== null)
                <p class="badge text-bg-success">Verified</p>
            @elseif($customer['isVerified'] == false && $customer['email_verified_at'] == null)
                <p class="badge text-bg-danger">Deactivated</p>
            @else
                <p class="badge text-bg-secondary">Not Verified</p>
            @endif

            <form action="{{ route('view_user_vehicle_info',$customer['customerID']) }}" method="GET">
                <button class="btn btn-primary" type="submit">View Vehicles</button>
                <button class="btn btn-dark" type="button" id="returnBtn">Return</button>
            </form>
        </div>

        <div class="col-md-8 rounded-3 table-responsive border">
            <p class="fw-bold d-flex justify-content-between">
                {{ $customer['fullname'] }} Cars
                
                <form action="{{ route('add_vehicle_view',$customer['customerID']) }}" method="get">
                    <button class="btn btn-dark">+<img src="{{ asset('icons/car_white.svg') }}" alt="Add Car"></button>
                </form>
            </p>
            <table class="table">
                <tr>
                    <th><small>IMAGE</small></th>
                    <th><small>MAKE</small></th>
                    <th><small>MODEL</small></th>
                    <th><small>YEAR OF MANUFACTURE</small></th>
                    <th><small>ENGINE TYPE</small></th>
                </tr>

                @foreach ($vehicles as $vehicle)
                    <tr>
                        <td><a href="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}" target="_blank"><img src="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}" alt="Vehicle Image" width="80" height="80" style="border-radius: 50%;"></a></td>
                        <td>{{ $vehicle['make'] }}</td>
                        <td>{{ $vehicle['model'] }}</td>
                        <td>{{ $vehicle['year_of_manufacture'] }}</td>
                        <td>{{ $vehicle['engine_type'] }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
  
    <div class="container border border-1 shadow pb-3 mt-4 table-responsive">
        <h5>Previous Owner Transactions</h5>
        <table class="table">
            <tr>
                <th>VEHICLE</th>
                <th>MAINTENANCE TYPE</th>
                <th>COST</th>
                <th>DATE PERFORMED</th>
                <th></th>
            </tr>

            @foreach ($previous_maintenance as $item)
                <tr>
                    <td>{{ $item['vehicle'] }}</td>
                    <td>{{ $item['maintenance_type'] }}</td>
                    <td>{{ $item['cost'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['date_performed'])->format('F j, Y') }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<script>
    document.getElementById('returnBtn').addEventListener('click',function(){
        window.history.back();
    });
</script>