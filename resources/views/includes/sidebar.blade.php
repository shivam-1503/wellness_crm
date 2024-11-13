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
            <h3>Work Flow</h3>
        </li>

        

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fas fa-hourglass-half"></i><span class="side-menu__label">Leads</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            @php

            $arr = [
                1 => 'Raw',
                2 => 'Prospecting',
                3 => 'Follow-Up',
                4 => 'Create Papers',
                5 => 'Lead Credit',
                6 => 'Archive',
                7 => 'R&D',
                8 => 'Lead Lost',
                ];
            @endphp



            <ul class="slide-menu">
                <li><a href="{{ url('/leads') }}" class="slide-item">All Leads</a></li>


                @foreach($arr as $key => $stage)
                <li><a href="{{ url('/leads?s='.$key) }}" class="slide-item">{{$stage}} Leads</a></li>
                @endforeach

                <li><a href="{{ url('/leads?s=15') }}" class="slide-item">Archive Leads</a></li>
                <li><a href="{{ url('/report/leads') }}" class="slide-item">Lead Reports</a></li>
                <li><a href="{{ url('/lost_leads') }}" class="slide-item">All Lost Lead</a></li>
            </ul>
        </li>

        
        {{--
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Customer</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                <li><a href="{{ url('/customers') }}" class="slide-item">Customers</a></li>
            </ul>
        </li>
        --}}

        <li>
            <h3>Product Management</h3>
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

        <!-- <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-building"></i><span class="side-menu__label">Services</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                <li><a href="{{ url('/services') }}" class="slide-item">Services</a></li>
            </ul>
        </li> -->


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

        {{--
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">KYC</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/kyc-details') }}" class="slide-item">Manage KYC</a></li>
            </ul>
        </li>
        --}}





        

        
        <li>
            <h3>Promotion Management</h3>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">Promotion</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/gifts') }}" class="slide-item">Gifts</a></li>
                    <li><a href="{{ url('/offers') }}" class="slide-item">Offers</a></li>
                    <li><a href="{{ url('/generate-codes') }}" class="slide-item">Generate Codes</a></li>
            </ul>
        </li>
        

       
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-user-tie"></i><span class="side-menu__label">Redemption</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/redeem-requests') }}" class="slide-item">Redeem Requests</a></li>
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




        {{--
        <li>
            <h3>Accounts Management</h3>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-wallet"></i><span class="side-menu__label">Payments </span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                <li><a href="{{ url('/receive_payments') }}" class="slide-item">Recieve Payments</a></li>
                <li><a href="{{ url('/confirm_payments') }}" class="slide-item">Confirm Payments</a></li>
                <li><a href="{{ url('/payments') }}" class="slide-item">All Payments</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-money-bill"></i><span class="side-menu__label">Accounts </span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                    <li><a href="{{ url('/expanse_categories') }}" class="slide-item">Expense Headers</a></li>
                
                    <li><a href="{{ url('/expense_titles') }}" class="slide-item">Expense Titles</a></li>
                <!-- <li><a href="{{ url('/expanses') }}" class="slide-item">Expenses</a></li>
                <li><a href="{{ url('/expanse_requests?s=1') }}" class="slide-item">Expenses Requests</a></li>
                <li><a href="{{ url('/expanse_requests?s=2') }}" class="slide-item">Requests Approved</a></li>
                <li><a href="{{ url('/expanse_requests?s=3') }}" class="slide-item">Requests Rejected</a></li> -->
                    <li><a href="{{ url('/vendors') }}" class="slide-item">Vendors</a></li>
                
                    <li><a href="{{ url('/vendor_report') }}" class="slide-item">Vendor Report</a></li>
              
                    <li><a href="{{ url('/expense_report') }}" class="slide-item">Expense Report</a></li>
            </ul>
        </li>
        --}}

        <li>
            <h3>Administration</h3>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-lock"></i><span class="side-menu__label">Administration</span><i class="angle fa fa-angle-right"></i>
            </a>
            
            <ul class="slide-menu">
                <li><a href="{{ url('/notices') }}" class="slide-item">Notice</a></li>
                <li><a href="{{ url('/business/basic_details') }}" class="slide-item">Business Details</a></li>
            </ul>
        </li>



    </ul>

</aside>
