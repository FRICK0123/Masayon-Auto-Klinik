<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Masayon Homepage</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

</head>
    <body>
        <!--Preloader-->
            <x-preloader/>
        <!--End-->

        <!--Header-->
            <header style="z-index: 1000">
                <x-homepage.navbar/>
            </header>
        <!--Header end-->


        <!--Home Section-->
            <section class="home_section container-fluid d-flex justify-content-center align-items-center flex-column" id="home">
                <h1 class="text-light text-center">RE'V UP YOUR RIDE - ULTIMATE CAR CARE AT YOUR FINGERTIPS! <br> SMART MONITORING, SMOOTH DRIVING</h1>
                {{-- <form action="{{ route('register_view') }}" method="GET">
                    <button class="btn btn-danger mt-5 car_register_btn">REGISTER YOUR CAR NOW!</button>
                </form> --}}
            </section>
        <!--Home Section Ends-->

        <!--About Us Section-->
            <section class="text-center" id="about">
                <x-homepage.about/>
            </section>
        <!--About Us Section-->

        <!--Services Section-->
            <section class="text-center mt-5" id="services">
                <x-homepage.services/>
            </section>
        <!--end-->

        <!--Maintenance Guide Section-->
            <section class="text-center mt-5" id="maintenance_guide">
                <x-homepage.maintenance-guide/>
            </section>
        <!--end-->

        <!--Contact Section-->
            <section class="text-center mt-5" id="contact_us">
                <x-homepage.contact-us/>
            </section>
        <!--end-->

        <!--Footer Section-->
        <footer class="bg-dark text-light py-3 text-center">
            <p>&copy; {{ date('Y') }} Masayon Auto Klinik. All Rights Reserved.</p>
        </footer>

        <script src="{{asset('js/homepage.js')}}"></script>

        <script src="{{ asset('/sw.js') }}"></script>
        <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded:", registration);
            },
            (error) => {
                console.error(`Service worker registration failed: ${error}`);
            },
            );
        } else {
            console.error("Service workers are not supported.");
        }

        let installPromptEvent = null; // Hold the event to trigger later

        // Listen for beforeinstallprompt event
        window.addEventListener('beforeinstallprompt', (event) => {
            // Prevent the default install prompt from showing
            event.preventDefault();
            
            // Save the event so it can be triggered later
            installPromptEvent = event;

            // Show the install button
            document.getElementById('installButton').style.display = 'block';

            // Add click event to the install button
            document.getElementById('installButton').addEventListener('click', () => {
                // Show the prompt to the user
                installPromptEvent.prompt();

                // Wait for the user to respond to the prompt
                installPromptEvent.userChoice.then((choiceResult) => {
                    console.log('User choice:', choiceResult.outcome);
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the PWA installation');
                    } else {
                        console.log('User dismissed the PWA installation');
                    }

                    // Hide the install button again after installation
                    document.getElementById('installButton').style.display = 'none';
                });
            });
        });
        </script>
    </body>
</html>