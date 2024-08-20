<div class="container ps-1 pe-1 p-lg-0">
    <div class="container border border-1 shadow rounded-3 pb-3">
        <a href="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" target="_blank" class="profile_img_wrapper mt-5">
            <img src="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" alt="Profile Image" class="profile_image">
        </a>
        <a href="#">Edit Profile Picture</a>

        <div class="profile_details mt-3">
            <p><b>Full Name:</b> {{Session::get('fullname')}}</p>
            <p><b>Email Address:</b> {{Session::get('email')}}</p>
            <p><b>Phone Number:</b> +63{{Session::get('phone_number')}}</p>
            <p><b>Username:</b> {{Session::get('username')}}</p>
        </div>

        <button class="btn btn-dark">Edit Profile Details</button>
    </div>
</div>