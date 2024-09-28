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
            @if ($customer['isVerified'] == true)
                <p class="border-bottom border-success text-success">Verified</p>
            @else
                <p class="border-bottom border-danger text-danger">Not Verified</p>
            @endif
        </div><br>

        <form action="{{ route('view_user_vehicle_info',$customer['customerID']) }}" method="GET">
            <button class="btn btn-dark" type="button">Return</button>
        </form>
    </div>
</div>