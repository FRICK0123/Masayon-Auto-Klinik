<nav class="container-fluid d-flex justify-content-between align-items-center pb-2" id="nav">
    <div class="masayon_logo">
        <img src="{{asset('Images/Masayon Auto Klinik Logo.png')}}" alt="Masayon Logo" width="100" height="100" class="img-fluid" id="logo">
    </div>

    <!--Login link/button to be directed to Login page-->
    @auth('customer')
        <form action="{{route('homepage')}}" class="text-white d-flex justify-content-center align-items-center me-lg-5" id="homepage" onclick="homePage()">
            <img src="{{asset('icons/user-circle.svg')}}" alt="Dashboard Icon" class="me-2">
            <h6 class="m-0 d-none d-lg-block">Profile</h6>
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