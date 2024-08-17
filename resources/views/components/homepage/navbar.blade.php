<nav class="container mt-3 d-flex justify-content-between align-items-baseline pb-2" id="nav">
    <div class="masayon_logo">
        <img src="{{asset('Images/Masayon Auto Klinik Logo.png')}}" alt="Masayon Logo" width="110" height="110" class="img-fluid" id="logo">
    </div>

    <!--Navigation Links-->
        <div class="links d-none d-lg-flex" id="nav_links">
            <a href="#home" id="home_link">HOME</a>
            <a href="#about" id="about_link">ABOUT US</a>
            <a href="#" id="services_link">SERVICES</a>
            <a href="#" id="maintenance_link">MAINTENANCE GUIDE</a>
            <a href="#" id="contact_link">CONTACT US</a>
        </div>
    <!--Navigation Links End-->


    <!--Login link/button to be directed to Login page-->
        <form action="{{route('login_view')}}" method="GET" class="d-none d-lg-block">
            <button class="btn" id="login">LOGIN</button>
        </form>
    <!--Login link/button to be directed to Login page End-->

    <!--Sidebar/Offcanvas-->
        <button class="btn d-lg-none" data-bs-toggle="offcanvas" role="button" href="#homepage_sidebar" aria-controls="homepage_sidebar"><img src="{{asset('icons/hamburger_white.svg')}}" alt="Sidebar"></button>

        <!--Sidebar Contents-->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="homepage_sidebar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="homepage_sidebar container d-flex flex-column">
                        <a href="#home" onclick="navigateAndClose('homepage_sidebar');">HOME</a>
                        <a href="#about" onclick="navigateAndClose('homepage_sidebar');">ABOUT US</a>
                        <a href="#" onclick="navigateAndClose('homepage_sidebar');">SERVICES</a>
                        <a href="#" onclick="navigateAndClose('homepage_sidebar');">MAINTENANCE GUIDE</a>
                        <a href="#" onclick="navigateAndClose('homepage_sidebar');">CONTACT US</a>

                        <form action="{{route('login_view')}}" method="get" class="mt-3">
                            <button class="btn btn-secondary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        <!--Sidebar Contents End-->
    <!--Sidebar/Offcanvas End-->

</nav>