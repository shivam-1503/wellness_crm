<style>
    .top-text-block{
  display: block;
  padding: 3px 20px;
  clear: both;
  font-weight: 400;
  line-height: 1.42857143;
  color: #333;
  white-space: inherit !important;
  border-bottom:1px solid #f4f4f4;
  position:relative;
  &:hover {
        &:before {
        content: '';
        width: 4px;
        background: #6259ca;
        left: 0;
        top: 0;
        bottom: 0;
        position: absolute;
    }
  }
  &.unread {
    background:#ffc;
    
    // &:hover {
    //   background:#ffd;
    // }
  }
  
  .top-text-light {
    // color:#ccc;
    color: #999;
    font-size: 0.8em;
  }
}   

.top-head-dropdown {
  .dropdown-menu {
   width: 250px;
    height:300px;
    overflow:auto;
  }
  
  li:last-child{
    .top-text-block {
      border-bottom:0;
    }
  }
}
.topbar-align-center {
  text-align: center;
}
.loader-topbar {
  margin: 5px auto;
  border: 3px solid #ddd;
  border-radius: 50%;
  border-top: 3px solid #666;
  width: 22px;
  height: 22px;
  -webkit-animation: spin-topbar 1s linear infinite;
  animation: spin-topbar 1s linear infinite;
}

@-webkit-keyframes spin-topbar {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin-topbar {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.icon-button {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  color: #333333;
  background: #dddddd;
  border: none;
  outline: none;
  border-radius: 50%;
  padding: 9px;
}

.icon-button:hover {
  cursor: pointer;
}

.icon-button:active {
  background: #cccccc;
}

.icon-button__badge {
  position: absolute;
  top: -5px;
  right: -5px;
  width: 18px;
  height: 18px;
  background: red;
  color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  font-size: 11px;
}

</style>


@php $tasks = Session::get("notifications")  @endphp

<div class="app-header header">
    <div class="container-fluid">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="#"></a>
            <!-- sidebar-toggle-->
            <a class="header-brand1 d-flex d-md-none" href="{{ url('/') }}">
                <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" class="header-brand-img desktop-logo"
                    alt="logo">
                <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" class="header-brand-img toggle-logo"
                    alt="logo">
                <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" class="header-brand-img light-logo"
                    alt="logo">
                <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" class="header-brand-img light-logo1"
                    alt="logo">
            </a><!-- LOGO -->

            <div class="d-flex order-lg-2 ms-auto header-right-icons">

            

            <div class="dropdown  d-md-flex profile-1 mt-3 top-head-dropdown">
                    <a href="#" data-bs-toggle="dropdown" class="nav-link icon-button leading-none d-flex">
                        <!-- <span>
                            <img src="{{ asset('backend_assets/images/users/notifications.png') }}" alt="profile-user"
                                class="avatar  profile-user brround cover-image">
                            <span class="btn__badge pulse-button ">4</span>
                        </span> -->

                        <span>
                            <i class="fa fa-bell" aria-hidden="true"></i> 
                            <span class="icon-button__badge">@if($tasks) {{ count($tasks) }} @endif</span>
                        <span>
                    </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                        
                        @if($tasks)

                            @foreach($tasks as $task)
                            <li>
                                <a href="{{ url('tasks') }}" class="top-text-block">
                                    <div class="top-text-heading">{{$task->title}}</div>
                                    <div class="top-text-light">{{$task->start_date }}</div>
                                </a> 
                            </li>
                            @endforeach

                        @endif
                            
                        <!-- <li>
                            <div class="loader-topbar"></div>
                        </li> -->
                   </ul>
                </div>


                <div class="dropdown  d-md-flex profile-1">
                    <a href="#" data-bs-toggle="dropdown" class="nav-link pe-2 leading-none d-flex">
                        <span>
                            <img src="{{ asset('backend_assets/images/users/default.png') }}" alt="profile-user"
                                class="avatar  profile-user brround cover-image">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <div class="drop-heading">
                            <div class="text-center">
                                <h5 class="text-dark mb-0">Welcome {{ Auth::user()->name }}!</h5>
                                <small class="text-muted">Administrator</small>
                            </div>
                        </div>
                        <div class="dropdown-divider m-0"></div>
                        <a class="dropdown-item" href="{{ url('employee/details/'.Auth::user()->id) }}">
                            <i class="dropdown-icon fe fe-user"></i> Profile
                        </a>

                        <a class="dropdown-item" href="{{ url('employee/details/'.Auth::user()->id) }}">
                            <i class="dropdown-icon fe fe-unlock"></i> Change Password
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="dropdown-icon fe fe-alert-circle"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>

                

            </div>
        </div>
    </div>
</div>