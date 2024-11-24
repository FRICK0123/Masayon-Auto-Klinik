//Close Sidebar When a link is clicked
    function navigateAndClose(id) {
        // Close the offcanvas sidebar
        var offcanvasElement = document.getElementById(id);
        var bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasElement);
        bsOffcanvas.hide();
    }
//end

//Change Navbar Style when scrolled
    document.addEventListener('scroll', () => {
        let navbar = document.getElementById('nav');
        let links = document.getElementById('nav_links');
        let logo = document.getElementById('logo');
        let loginBtn = document.getElementById('login');

        //links
        let home = document.getElementById('home_link');
        let about = document.getElementById('about_link');
        let services = document.getElementById('services_link');
        let maintenance = document.getElementById('maintenance_link');
        let contact = document.getElementById('contact_link');

        if (window.scrollY > 500) {
            navbar.classList.add('scrolled');
            links.classList.add('scrolled');
            logo.classList.add('scrolled');
            loginBtn.classList.add('scrolled');
            
            home.classList.add('scrolled');
            about.classList.add('scrolled');
            services.classList.add('scrolled');
            maintenance.classList.add('scrolled');
            contact.classList.add('scrolled');

        } else {
            navbar.classList.remove('scrolled');
            links.classList.remove('scrolled');
            logo.classList.remove('scrolled');
            loginBtn.classList.remove('scrolled');
            
            home.classList.remove('scrolled');
            about.classList.remove('scrolled');
            services.classList.remove('scrolled');
            maintenance.classList.remove('scrolled');
            contact.classList.remove('scrolled');
        }
    });
//end
