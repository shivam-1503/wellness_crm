@extends('layouts.app')
@section('content')


<style>
    a {
        color: #f96332;
    }

    a:hover,
    a:focus {
        color: #f96332;
    }

    p {
        line-height: 1.61em;
        font-weight: 300;
        font-size: 1.2em;
    }

	.avatar {
		height: 100px;
		width: 100px;
	}
    .category {
        text-transform: capitalize;
        font-weight: 700;
        color: #9A9A9A;
    }

    .nav-item .nav-link,
    .nav-tabs .nav-link {
        -webkit-transition: all 300ms ease 0s;
        -moz-transition: all 300ms ease 0s;
        -o-transition: all 300ms ease 0s;
        -ms-transition: all 300ms ease 0s;
        transition: all 300ms ease 0s;
    }

    .card a {
        -webkit-transition: all 150ms ease 0s;
        -moz-transition: all 150ms ease 0s;
        -o-transition: all 150ms ease 0s;
        -ms-transition: all 150ms ease 0s;
        transition: all 150ms ease 0s;
    }


    .nav-tabs {
        border: 0;
        margin: 15px 0.7rem;
    }

    .nav-tabs:not(.nav-tabs-neutral)>.nav-item>.nav-link.active {
        box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.3);
    }

    .card .nav-tabs {
        border-top-right-radius: 0.1875rem;
        border-top-left-radius: 0.1875rem;
    }

    .nav-tabs>.nav-item>.nav-link {
        color: #888888;
        margin: 0;
        margin-right: 5px;
        background-color: transparent;
        border: 1px solid transparent;
        border-radius: 30px;
        font-size: 14px;
        padding: 10px 20px;
        line-height: 1.5;
    }

    .nav-tabs>.nav-item>.nav-link:hover {
        background-color: transparent;
    }

    .nav-tabs>.nav-item>.nav-link.active {
        /* background-color: #444; */
        background: linear-gradient(to bottom right, #9e88f5 0%, #6259ca 100%);
        border-radius: 30px;
        color: #FFF;
    }

    .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
        font-size: 14px;
        position: relative;
        top: 1px;
        margin-right: 3px;
    }

    .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
        color: #FFFFFF;
    }

    .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: #FFFFFF;
    }

    .card {
        border: 0;
        border-radius: 0.1875rem;
        display: inline-block;
        position: relative;
        width: 100%;
        /* margin-bottom: 30px; */
        box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
    }

    .card .card-header {
        background-color: transparent;
        border-bottom: 0;
        background-color: transparent;
        border-radius: 0;
        padding: 0;
    }

    .card[data-background-color="orange"] {
        background-color: #f96332;
    }

    .card[data-background-color="red"] {
        background-color: #FF3636;
    }

    .card[data-background-color="yellow"] {
        background-color: #FFB236;
    }

    .card[data-background-color="blue"] {
        background-color: #2CA8FF;
    }

    .card[data-background-color="green"] {
        background-color: #15b60d;
    }

    [data-background-color="orange"] {
        background-color: #e95e38;
    }

    [data-background-color="black"] {
        background-color: #2c2c2c;
    }

    [data-background-color]:not([data-background-color="gray"]) {
        color: #FFFFFF;
    }

    [data-background-color]:not([data-background-color="gray"]) p {
        color: #FFFFFF;
    }

    [data-background-color]:not([data-background-color="gray"]) a:not(.btn):not(.dropdown-item) {
        color: #FFFFFF;
    }

    [data-background-color]:not([data-background-color="gray"]) .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
        color: #FFFFFF;
    }

    @media screen and (max-width: 768px) {

        .nav-tabs {
            display: inline-block;
            width: 100%;
            padding-left: 100px;
            padding-right: 100px;
            text-align: center;
        }

        .nav-tabs .nav-item>.nav-link {
            margin-bottom: 5px;
        }
    }
</style>

<!-- PAGE-HEADER -->
<div class="page-header">
	<div>
		<h1>Employee <small>Profile</small></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Home</a></li>
			<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page">Employee Details</li>
		</ol>
	</div>

	<div class="float-end">
		<a class="btn btn-primary float-right" href="{{url('employees')}}"> <i class="fa fa-arrow-left"></i> Employee List</a>
	</div>

</div>
<!-- PAGE-HEADER END -->


	@if($message = Session::get("success"))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Greate Job!</strong> {{$message}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

<div class="content mt-3">

	<!-- Profile 1 - Bootstrap Brain Component -->
	<section class="bg-light py-3 py-md-5 py-xl-8">

		<div class="container">
			<div class="row gy-4 gy-lg-0">
				<div class="col-12 col-lg-4">
					<div class="row gy-4">
						<div class="col-12">
							<div class="card widget-card border-light shadow-sm">

								<div class="card-body">
									<div class="text-center mb-3">
										<img src="{{ !empty($details->profile_image) ? url('storage/'.$details->profile_image) : asset('backend_assets/images/users/default.png') }}" alt="profile-user"
													class="avatar profile-user brround cover-image">
									</div>
									<h5 class="text-center mb-1"> {{ $details->name }}</h5>
									<p class="text-center text-secondary mb-4">{{ $details->designation->title }}</p>
									<ul class="list-group list-group-flush mb-4">
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<h6 class="m-0">Email</h6>
											<span>{{ $details->email }}</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<h6 class="m-0">Phone</h6>
											<span>{{ $details->phone }}</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<h6 class="m-0">Friends</h6>
											<span>4,620</span>
										</li>
									</ul>
									<!-- <div class="d-grid m-0">
										<button class="btn btn-outline-primary" type="button">Follow</button>
									</div> -->
								</div>
							</div>
						</div>



					<!-- <div class="col-12">
						<div class="card widget-card border-light shadow-sm">
						<div class="card-header text-bg-primary">Social Accounts</div>
						<div class="card-body">
							<a href="#!" class="d-inline-block bg-dark link-light lh-1 p-2 rounded">
							<i class="bi bi-youtube"></i>
							</a>
							<a href="#!" class="d-inline-block bg-dark link-light lh-1 p-2 rounded">
							<i class="bi bi-twitter-x"></i>
							</a>
							<a href="#!" class="d-inline-block bg-dark link-light lh-1 p-2 rounded">
							<i class="bi bi-facebook"></i>
							</a>
							<a href="#!" class="d-inline-block bg-dark link-light lh-1 p-2 rounded">
							<i class="bi bi-linkedin"></i>
							</a>
						</div>
						</div>
					</div> -->


					<!-- <div class="col-12">
						<div class="card widget-card border-light shadow-sm">
						<div class="card-header text-bg-primary">About Me</div>
						<div class="card-body">
							<ul class="list-group list-group-flush mb-0">
							<li class="list-group-item">
								<h6 class="mb-1">
								<span class="bii bi-mortarboard-fill me-2"></span>
								Education
								</h6>
								<span>M.S Computer Science</span>
							</li>
							<li class="list-group-item">
								<h6 class="mb-1">
								<span class="bii bi-geo-alt-fill me-2"></span>
								Location
								</h6>
								<span>Mountain View, California</span>
							</li>
							<li class="list-group-item">
								<h6 class="mb-1">
								<span class="bii bi-building-fill-gear me-2"></span>
								Company
								</h6>
								<span>GitHub Inc</span>
							</li>
							</ul>
						</div>
						</div>
					</div> -->


					<!-- <div class="col-12">
						<div class="card widget-card border-light shadow-sm">
						<div class="card-header text-bg-primary">Skills</div>
						<div class="card-body">
							<span class="badge text-bg-primary">HTML</span>
							<span class="badge text-bg-primary">SCSS</span>
							<span class="badge text-bg-primary">Javascript</span>
							<span class="badge text-bg-primary">React</span>
							<span class="badge text-bg-primary">Vue</span>
							<span class="badge text-bg-primary">Angular</span>
							<span class="badge text-bg-primary">UI</span>
							<span class="badge text-bg-primary">UX</span>
						</div>
						</div>
					</div> -->

					</div>
				</div>



				<div class="col-12 col-lg-8">
					<div class="card">
						<div class="card-header">
							<ul class="nav nav-tabs justify-content-center" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" href="#basic" data-bs-toggle="tab" role="tab">
										Overview
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#official" data-bs-toggle="tab" role="tab">
										Change Password
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#profile" data-bs-toggle="tab" role="tab">
										Update Profile Picture
									</a>
								</li>
							</ul>
						</div>

						<div class="card-body">
							<!-- Tab panes -->
							<div class="tab-content">

								{{-- Basic Details Form --}}
								<div class="tab-pane active" id="basic" role="tabpanel">                            

									<div class="row g-0">
										<div class="col-5 col-md-3">
											<div class="p-2">Employee Name</div>
										</div>
										<div class="col-7 col-md-9">
											<div class="p-2"> {{ $details->name }}</div>
										</div>
										<div class="col-5 col-md-3">
											<div class="p-2">Gender</div>
										</div>
										<div class="col-7 col-md-9">
											<div class="p-2">{{ $details->gender }}</div>
										</div>
										<div class="col-5 col-md-3">
											<div class="p-2">date of Birth</div>
										</div>
										<div class="col-7 col-md-9">
											<div class="p-2">{{ date('d M, Y', strtotime($details->dob)) }}</div>
										</div>
										<div class="col-5 col-md-3">
											<div class="p-2">UIDAI (Aadhar)</div>
										</div>
										<div class="col-7 col-md-9">
											<div class="p-2">{{ $details->uidai }} </div>
										</div>
										<div class="col-5 col-md-3">
											<div class="p-2">PAN no</div>
										</div>
										<div class="col-7 col-md-9">
											<div class="p-2"> {{ $details->pan }} </div>
										</div>
										<div class="col-5 col-md-3">
											<div class="p-2">Experience</div>
										</div>
										<div class="col-7 col-md-9">
											<div class="p-2"> {{ $details->experience }} Years </div>
										</div>
										<div class="col-5 col-md-3">
											<div class="p-2">Joining Date</div>
										</div>
										<div class="col-7 col-md-9">
											<div class="p-2">{{ date('d M, Y', strtotime($details->joining_date)) }}</div>
										</div>
										<div class="col-5 col-md-3">
											<div class="p-2">Address</div>
										</div>
										<div class="col-7 col-md-9">
											<div class="p-2">{{ $details->address }}, {{ $details->city }} - {{ $details->pincode }}</div>
										</div>
									</div>
								
								</div>
								


								{{-- Change Password Form --}}
								<div class="tab-pane" id="official" role="tabpanel">
									{{ Form::open(array('url'=>'/employee/change_password'))}}
										@csrf
										{{ Form::hidden('employee_id', $details->id)}}
										
										<div class="form-group">
											{{Form::text('current_password','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Current Password'])}}
										</div>

										<div class="form-group">
											{{Form::text('new_password','', ['class'=>'form-control', 'required'=>'','placeholder'=>'New Password'])}}
										</div>

										<div class="form-group">
											{{Form::text('confirm_password','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Confirm Password'])}}
										</div>

										{{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
									{{ Form::close() }}
								</div>


								{{-- Profile Picture Form --}}
								<div class="tab-pane" id="profile" role="tabpanel">
									{{ Form::open(array('url'=>'/employee/upldate_profile_image', 'enctype'=>"multipart/form-data"))}}
										@csrf
										{{ Form::hidden('employee_id', $details->id)}}
										
										<div class="form-group">
											{!! Form::file('product_images', ['class'=>"form-control", 'id'=>"product_images", 'placeholder'=>"Select Project Image", 'required']); !!}
										</div>

										{{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
									{{ Form::close() }}
								</div>


							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</section>

</div>


@stop

@section('scripting')

<script type="text/javascript">

	$(document).ready(function() {

	});


</script>


@endsection
