<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{ url('/') }}">
            <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" class="header-brand-img desktop-logo"
                alt="logo">
            <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" class="header-brand-img toggle-logo"
                alt="logo">
            <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" class="header-brand-img light-logo"
                alt="logo">
            <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" class="header-brand-img light-logo1"
                alt="logo">
        </a><!-- LOGO -->
    </div>
    <ul class="side-menu">
        <li>
            <h3>Main</h3>
        </li>
        
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/')}}">
                <i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fe fe-command"></i><span class="side-menu__label">Activities</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                <li><a href="{{ url('/task-calendar') }}" class="slide-item">Calendar</a></li>
                <li><a href="{{ url('/tasks') }}" class="slide-item">Tasks</a></li>
            </ul>
        </li>



        <li>
            <h3>Wellness CRM</h3>
        </li>

        

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">Docters Details</span><i class="angle fa fa-angle-right"></i>
            </a>

            <ul class="slide-menu">
                <li><a href="{{ url('/docters') }}" class="slide-item">Docters</a></li>
                <li><a href="{{ url('/patients') }}" class="slide-item">Patients</a></li>
                <li><a href="{{ url('/specialities') }}" class="slide-item">Specialities</a></li>
                <li><a href="{{ url('/degrees') }}" class="slide-item">Degrees</a></li>
                <li><a href="{{ url('/diesease') }}" class="slide-item">Diesease</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">Patients Details</span><i class="angle fa fa-angle-right"></i>
            </a>

            <ul class="slide-menu">
                <li><a href="{{ url('/docters') }}" class="slide-item">Enquiry</a></li>
                <li><a href="{{ url('/patients') }}" class="slide-item">Register</a></li>
                <li><a href="{{ url('/specialities') }}" class="slide-item">Treatment</a></li>
                <li><a href="{{ url('/degrees') }}" class="slide-item">Diagnostic</a></li>
                <li><a href="{{ url('/diesease') }}" class="slide-item">Follow Up</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">Products</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/brands') }}" class="slide-item">Brands</a></li>
                    <li><a href="{{ url('/categories') }}" class="slide-item">Categories</a></li>
                    <li><a href="{{ url('/products') }}" class="slide-item">Products</a></li>
            </ul>
        </li>

        <li>
            <h3>Business Channel</h3>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">Channel Partners</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/dealers') }}" class="slide-item">Dealers</a></li>
                    <li><a href="{{ url('/distributors') }}" class="slide-item">Distributors</a></li>
                    <li><a href="{{ url('/influencers') }}" class="slide-item">Influencers</a></li>
            </ul>
        </li>

        <li>
            <h3>HR Management</h3>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">HR</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/designations') }}" class="slide-item">Designations</a></li>
                
                    <li><a href="{{ url('/employees') }}" class="slide-item">Employees</a></li>
            </ul>
        </li>
    </ul>
</aside>
