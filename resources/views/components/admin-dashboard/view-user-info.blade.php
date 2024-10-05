@props(['customer','vehicles','previous_maintenance'])
<div class="container">
    <h2 class="pb-2 border-bottom">USER</h2>

    <div class="container border border-1 shadow pb-3 d-flex">
        <!--User Profile-->
        <div class="d-flex flex-column">
            <!--Profile Image-->
            <div class="customer_img_wrapper mt-1">
                <img src="{{ asset('Images/profile_images/'.$customer['profile_img']) }}" alt="Car Image" class="customer_image" id="car_image">
            </div>
            <!--User Profile Information-->
            <div class="container">
                <div class="d-flex align-items-baseline">
                    <small class="fw-bold me-2">Fullname:</small>
                    <p class="border-bottom">{{ $customer['fullname'] }}</p>
                </div>

                <div class="d-flex align-items-baseline">
                    <small class="fw-bold me-2">Email:</small>
                    <p class="border-bottom">{{ $customer['email'] }}</p>
                </div>

                <div class="d-flex align-items-baseline">
                    <small class="fw-bold me-2">Phone Number:</small>
                    <p class="border-bottom">+63{{ $customer['phone_number'] }}</p>
                </div>

                <div class="d-flex align-items-baseline">
                    <p class="fw-bold me-2">Username:</p>
                    <p class="border-bottom">{{ $customer['username'] }}</p>
                </div>

                <div class="d-flex align-items-baseline">
                    <p class="fw-bold me-2">Account Status:</p>
                    @if ($customer['isVerified'] == true && $customer['email_verified_at'] !== null)
                        <p class="border-bottom border-success text-success">Verified</p>
                    @elseif($customer['isVerified'] == false && $customer['email_verified_at'] == null)
                        <p class="border-bottom border-danger text-danger">Deactivated</p>
                    @else
                        <p class="border-bottom border-secondary text-secondary">Not Verified</p>
                    @endif
                </div>

                <form action="{{ route('view_user_vehicle_info',$customer['customerID']) }}" method="GET">
                    <button class="btn btn-primary" type="submit">View Vehicles</button>
                    <button class="btn btn-dark" type="button" id="returnBtn">Return</button>
                </form>
            </div>
        </div>

        <div class="container shadow-sm mt-2">
            <p class="fw-bold d-flex justify-content-between">
                {{ $customer['fullname'] }} Cars
                <button class="btn btn-dark">+<img src="{{ asset('icons/car_white.svg') }}" alt="Add Car"></button>
            </p>
            <table class="table table-responsive">
                <tr>
                    <th><small>IMAGE</small></th>
                    <th><small>MAKE</small></th>
                    <th><small>MODEL</small></th>
                    <th><small>YEAR OF MANUFACTURE</small></th>
                    <th><small>ENGINE TYPE</small></th>
                </tr>

                @foreach ($vehicles as $vehicle)
                    <tr>
                        <td><a href="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}"><img src="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}" alt="Vehicle Image" width="80" height="80"></a></td>
                        <td>{{ $vehicle['make'] }}</td>
                        <td>{{ $vehicle['model'] }}</td>
                        <td>{{ $vehicle['year_of_manufacture'] }}</td>
                        <td>{{ $vehicle['engine_type'] }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
  
    <div class="container border border-1 shadow pb-3 mt-4">
        <h5>Previous Vehicle Transactions</h5>
        <table class="table table-responsive">
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