@props(['customer'])
<div class="container">
    <h2 class="pb-2 border-bottom">USER</h2>

    <div class="container border border-1 shadow pb-3">
        <!--Profile Image-->
        <div class="car_img_wrapper mt-5">
            <img src="{{ asset('Images/profile_images/'.$customer['profile_img']) }}" alt="Car Image" class="car_image" id="car_image">
        </div><br>

        <div class="d-flex align-items-baseline">
            <p class="fw-bold me-2">Fullname:</p>
            <p class="border-bottom">{{ $customer['fullname'] }}</p>
        </div>

        <div class="d-flex align-items-baseline">
            <p class="fw-bold me-2">Email:</p>
            <p class="border-bottom">{{ $customer['email'] }}</p>
        </div>

        <div class="d-flex align-items-baseline">
            <p class="fw-bold me-2">Phone Number:</p>
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
        </div><br>

        <form action="{{ route('view_user_vehicle_info',$customer['customerID']) }}" method="GET">
            <button class="btn btn-primary" type="submit">View Vehicles</button>
            <button class="btn btn-dark" type="button" id="returnBtn">Return</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('returnBtn').addEventListener('click',function(){
        window.history.back();
    });
</script>