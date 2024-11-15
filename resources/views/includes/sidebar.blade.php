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
                <li><a href="{{ url('/tasks') }}" class="slide-item">Follow up</a></li>
            </ul>
        </li>



        <li>
            <h3>Doctor's</h3>
        </li>

        

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-notes-medical"></i><span class="side-menu__label">Doctor Details</span><i class="angle fa fa-angle-right"></i>
            </a>

            <ul class="slide-menu">
                <li><a href="{{ url('/docters') }}" class="slide-item">Doctor's List</a></li>
                <li><a href="{{ url('/specialities') }}" class="slide-item">Specialities</a></li>
                <li><a href="{{ url('/degrees') }}" class="slide-item">Degrees</a></li>
            </ul>
        </li>



        <li>
            <h3>Patient's</h3>
        </li>



        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-users-medical"></i><span class="side-menu__label">Patient Details</span><i class="angle fa fa-angle-right"></i>
            </a>

            <ul class="slide-menu">
                <li><a href="{{ url('/docters') }}" class="slide-item">Patient's List</a></li>
                <li><a href="{{ url('/patients') }}" class="slide-item">Register</a></li>
                <li><a href="{{ url('/specialities') }}" class="slide-item">Enquire</a></li>
            </ul>
        </li>


        <li>
            <h3>Medicine</h3>
        </li>




        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-capsules"></i><span class="side-menu__label">Treatments</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/brands') }}" class="slide-item">Disease</a></li>
                    <li><a href="{{ url('/categories') }}" class="slide-item">Categories</a></li>
                    <li><a href="{{ url('/products') }}" class="slide-item">Products</a></li>
            </ul>
        </li>


        
        <li>
            <h3>Products</h3>
        </li>



        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-prescription-bottle"></i><span class="side-menu__label">Products</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/brands') }}" class="slide-item">Brands</a></li>
                    <li><a href="{{ url('/categories') }}" class="slide-item">Categories</a></li>
                    <li><a href="{{ url('/products') }}" class="slide-item">Products</a></li>
            </ul>
        </li>

        <li>
            <h3>Vendor's</h3>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-store"></i><span class="side-menu__label">Vendor's details</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/dealers') }}" class="slide-item">Dealers</a></li>
                    <li><a href="{{ url('/distributors') }}" class="slide-item">Distributors</a></li>
                    <li><a href="{{ url('/influencers') }}" class="slide-item">Influencers</a></li>
            </ul>
        </li>

        <li>
            <h3>Administrator</h3>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">Administration</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/dealers') }}" class="slide-item">Dealers</a></li>
                    <li><a href="{{ url('/distributors') }}" class="slide-item">Distributors</a></li>
                    <li><a href="{{ url('/influencers') }}" class="slide-item">Influencers</a></li>
            </ul>
        </li>
    </ul>
</aside>
