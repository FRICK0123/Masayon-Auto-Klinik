@props(['customer'])
<div class="container row">
    <h2 class="pb-2 border-bottom">EDIT {{ $customer['fullname'] }} INFO</h2>
    
    <div class="container mt-3 w-75 mb-3">
        <form action="{{route('edit_user_info',$customer['customerID'])}}" method="post">
            @csrf
            <!--Profile Image-->
            <label for="profile_image">
                <div class="car_img_wrapper">
                    <img src="{{asset('Images/profile_images/'.$customer['profile_img'])}}" alt="User Profile Image" class="car_image" id="user_image">
                </div>
            </label>
            <br>

            <!--Fullname-->
            <label for="full_name" class="fw-bold">Full Name: </label>
            <input type="text" class="form-control" value="{{ $customer['fullname'] }}" id="full_name" name="fullname">
            <br>

            <!--Email Address-->
            <label for="email_address" class="fw-bold">Email Address: </label>
            <input type="text" class="form-control" value="{{ $customer['email'] }}" id="email_address" name="email_address">
            <br>

            <!--Phone Number-->
            <label for="phone_number" class="fw-bold">Phone Number: </label>
            <div class="input-group">
                <span class="input-group-text">+63</span>
                <input type="text" class="form-control" value="{{ $customer['phone_number'] }}" id="phone_number" pattern="[9][0-9]{9}" title="(e.g. 9098763245)" name="phone_number">
            </div>
            <br>

            <!--Username-->
            <label for="username" class="fw-bold">Username: </label>
            <input type="text" class="form-control" value="{{ $customer['username'] }}" id="username" name="username">
            <br>

            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" id="return" class="btn btn-dark">Return</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('return').addEventListener('click',function(){
        window.history.back();
    });
</script>