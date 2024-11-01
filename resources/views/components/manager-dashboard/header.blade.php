<nav class="d-flex justify-content-between align-items-center p-2 mt-2 ms-2 me-2 rounded-4 bg-dark" id="nav">
    <div class="masayon_logo">
        <img src="{{ asset('Images/profile_images/'.Session::get('profile_img')) }}" alt="Masayon Logo" width="70" height="70" class="img-fluid" id="logo">
    </div>

    <!--Login link/button to be directed to Login page-->
    @auth('customer')
        <form action="{{route('homepage')}}" class="text-white d-flex justify-content-center align-items-center me-lg-5" id="homepage" onclick="homePage()">
            <img src="{{asset('icons/house-white.svg')}}" alt="Dashboard Icon" class="me-2">
            <h6 class="m-0 d-none d-lg-block">Homepage</h6>
        </form>
    @endauth
    <!--Login link/button to be directed to Login page End-->
</nav>

<!--Script-->
<script>
    const homepage = document.getElementById('homepage');

    function homePage(){
        homepage.submit();
    }
</script>