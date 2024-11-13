<?php echo asset('backend_assets/images/login.png'); ?>

<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<!-- META DATA -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">


	<!-- TITLE -->
	<title>Real Estate Agency Management | Syntorix Consulting</title>

	<!-- FAVICON -->


	<!-- BOOTSTRAP CSS -->
	<link href="../public/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

	<!-- STYLE CSS -->
	<link href="../public/assets/css/style.css" rel="stylesheet" />
	<link href="../public/assets/css/dark-style.css" rel="stylesheet" />
	<link href="../public/assets/css/skin-modes.css" rel="stylesheet" />

	<!-- SIDE-MENU CSS -->
	<link href="../public/assets/css/sidemenu.css" rel="stylesheet" id="sidemenu-theme">

	<!-- P-scroll bar css-->
	<link href="../public/assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet" />


	<!-- SELECT2 CSS -->
	<link href="../public/assets/plugins/select2/select2.min.css" rel="stylesheet" />

	<!-- INTERNAL Data table css -->
	<link href="../public/assets/plugins/datatable/css/dataTables.bootstrap5.css" rel="stylesheet" />
	<link href="../public/assets/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />


	<!--- FONT-ICONS CSS -->
	<link href="../public/assets/css/icons.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
		integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
	<!-- SIDEBAR CSS -->
	<link href="../public/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

	<!-- COLOR SKIN CSS -->
	<link id="theme" rel="stylesheet" type="text/css" media="all" href="../public/assets/colors/color1.css" />


</head>

<body class="app sidebar-mini">


	<!-- PAGE -->
	<div class="page">
		<div class="page-main">

		<!--APP-SIDEBAR-->
		<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
		<aside class="app-sidebar">
			<div class="side-header">
				<a class="header-brand1" href="index.html">
					<img src="../public/assets/images/brand/logo.png" class="header-brand-img desktop-logo"
						alt="logo">
					<img src="../public/assets/images/brand/logo-1.png" class="header-brand-img toggle-logo"
						alt="logo">
					<img src="../public/assets/images/brand/logo-2.png" class="header-brand-img light-logo"
						alt="logo">
					<img src="../public/assets/images/brand/logo-3.png" class="header-brand-img light-logo1"
						alt="logo">
				</a><!-- LOGO -->
			</div>
			<ul class="side-menu">
				<li>
					<h3>Main</h3>
				</li>
				<li class="slide">
					<a class="side-menu__item" data-bs-toggle="slide" href="index.html"><i
							class="side-menu__icon fe fe-home"></i><span
							class="side-menu__label">Dashboard</span></a>
				</li>
				<li>
					<h3>Projects</h3>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-bs-toggle="slide" href="#"><i
							class="side-menu__icon fe fe-command"></i><span class="side-menu__label">ENBD 2.0</span><i class="angle fa fa-angle-right"></i></a>
					<ul class="slide-menu">
						<li><a href="enbd-dashboard.html" class="slide-item"> ENBD Dashboard</a></li>
						



						<li class="sub-slide">
							<a class="slide-item" data-bs-toggle="sub-slide" href="#"><span class="side-menu__label"> Golf Booking Management</span><i class="angle fa fa-angle-right"></i>
							</a>
							
							<ul class="sub-slide-menu">
							<li><a href="pending-booking.html" class="sub-slide-item"> Pending Bookings</a></li>

							<li><a href="confirm-booking.html" class="sub-slide-item"> Confirmed Bookings</a></li>
							<li><a href="cancelled-booking.html" class="sub-slide-item"> Cancelled Bookings</a></li>
							<li><a href="block-dates.html" class="sub-slide-item"> Block Dates</a></li>
							<li><a href="date-range.html" class="sub-slide-item"> Reports By Date Range</a></li>
						</ul>
						</li>
						<li class="sub-slide">
							<a class="slide-item" data-bs-toggle="sub-slide" href="#"><span class="side-menu__label"> Airport Transfer Management</span><i class="angle fa fa-angle-right"></i>
							</a>
							
							<ul class="sub-slide-menu">
							<li><a href="airport-pending-booking.html" class="sub-slide-item"> Pending Bookings</a></li>

							<li><a href="airport-confirm-booking.html" class="sub-slide-item"> Confirmed Bookings</a></li>
							<li><a href="airport-cancelled-booking.html" class="sub-slide-item"> Cancelled Bookings</a></li>
							<li><a href="airport-date-range.html" class="sub-slide-item"> Reports By Date Range</a></li>
						</ul>
						</li>
						<li class="sub-slide">
							<a class="slide-item" data-bs-toggle="sub-slide" href="#"><span class="side-menu__label"> Local Courier Management</span><i class="angle fa fa-angle-right"></i>
							</a>
							
							<ul class="sub-slide-menu">
							<li><a href="courier-pending-booking.html" class="sub-slide-item"> Pending Bookings</a></li>

							<li><a href="courier-confirm-booking.html" class="sub-slide-item"> Confirmed Bookings</a></li>
							<li><a href="courier-cancelled-booking.html" class="sub-slide-item"> Cancelled Bookings</a></li>
							<li><a href="courier-date-range.html" class="sub-slide-item"> Reports By Date Range</a></li>
						</ul>
						</li>
						<li class="sub-slide">
							<a class="slide-item" data-bs-toggle="sub-slide" href="#"><span class="side-menu__label"> Car Servicing Management</span><i class="angle fa fa-angle-right"></i>
							</a>
							
							<ul class="sub-slide-menu">
							<li><a href="service-pending-booking.html" class="sub-slide-item"> Pending Bookings</a></li>

							<li><a href="service-confirm-booking.html" class="sub-slide-item"> Confirmed Bookings</a></li>
							<li><a href="service-cancelled-booking.html" class="sub-slide-item"> Cancelled Bookings</a></li>
							<li><a href="service-date-range.html" class="sub-slide-item"> Reports By Date Range</a></li>
						</ul>
						</li>
						<li class="sub-slide">
							<a class="slide-item" data-bs-toggle="sub-slide" href="#"><span class="side-menu__label"> Car Registration Management</span><i class="angle fa fa-angle-right"></i>
							</a>
							
							<ul class="sub-slide-menu">
							<li><a href="registration-pending-booking.html" class="sub-slide-item"> Pending Bookings</a></li>

							<li><a href="registration-confirm-booking.html" class="sub-slide-item"> Confirmed Bookings</a></li>
							<li><a href="registration-cancelled-booking.html" class="sub-slide-item"> Cancelled Bookings</a></li>
							<li><a href="registration-date-range.html" class="sub-slide-item"> Reports By Date Range</a></li>
						</ul>
						</li>
						<li><a href="customer-management.html" class="slide-item"> Customer Management</a></li>

					</ul>
				</li>
				<li class="slide">
					<a class="side-menu__item" href="user-management.html"><i
							class="side-menu__icon fe fe-command"></i><span class="side-menu__label">User
							Management</span></a>

				</li>
				<li class="slide">
					<a class="side-menu__item" href="change-password.html"><i
							class="side-menu__icon fe fe-command"></i><span class="side-menu__label">Change
							Password</span></a>

				</li>

				<li class="slide">
					<a class="side-menu__item" href="index.html"><i
							class="side-menu__icon fe fe-command"></i><span
							class="side-menu__label">Logout</span></a>

				</li>

			</ul>
		</aside>
		<!--/APP-SIDEBAR-->
			<!-- Mobile Header -->
			<div class="app-header header">
				<div class="container-fluid">
					<div class="d-flex">
						<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="#"></a>
						<!-- sidebar-toggle-->
						<a class="header-brand1 d-flex d-md-none" href="index.html">
							<img src="../public/assets/images/brand/logo.png" class="header-brand-img desktop-logo"
								alt="logo">
							<img src="../public/assets/images/brand/logo-1.png" class="header-brand-img toggle-logo"
								alt="logo">
							<img src="../public/assets/images/brand/logo-2.png" class="header-brand-img light-logo"
								alt="logo">
							<img src="../public/assets/images/brand/logo-3.png" class="header-brand-img light-logo1"
								alt="logo">
						</a><!-- LOGO -->

						<div class="d-flex order-lg-2 ms-auto header-right-icons">




							<div class="dropdown  d-md-flex profile-1">
								<a href="#" data-bs-toggle="dropdown" class="nav-link pe-2 leading-none d-flex">
									<span>
										<img src="../public/assets/images/users/8.jpg" alt="profile-user"
											class="avatar  profile-user brround cover-image">
									</span>
								</a>
								<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
									<div class="drop-heading">
										<div class="text-center">
											<h5 class="text-dark mb-0">ENBD Admin</h5>
											<small class="text-muted">Administrator</small>
										</div>
									</div>
									<div class="dropdown-divider m-0"></div>
									<a class="dropdown-item" href="profile.html">
										<i class="dropdown-icon fe fe-user"></i> Profile
									</a>

									<a class="dropdown-item" href="change-password.html">
										<i class="dropdown-icon fe fe-unlock"></i> Change Password
									</a>
									<a class="dropdown-item" href="login.html">
										<i class="dropdown-icon fe fe-alert-circle"></i> Sign out
									</a>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<!-- /Mobile Header -->
			<!--app-content open-->
			<div class="app-content">
				<div class="side-app">


					<!-- PAGE-HEADER -->
					<div class="page-header">
						<div>
							<h1 class="page-title">Dashboard</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
							</ol>
						</div>

					</div>
					<!-- PAGE-HEADER END -->
					
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="card">
								<div class="card-body text-center">

									<i class="fas fa-hourglass-end text-primary fa-3x"></i>
									<h6 class="mt-4 mb-2">Pending Bookings</h6>
									<h4 class="mb-2 number-font">834</h4>

								</div>
							</div>
						</div><!-- COL END -->
						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="card">
								<div class="card-body text-center">
									<i class="fas fa-ban text-secondary fa-3x"></i>
									<h6 class="mt-4 mb-2">Cancelled Booking (24 hours)</h6>
									<h4 class="mb-2  number-font">20</h4>

								</div>
							</div>
						</div><!-- COL END -->
						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="card">
								<div class="card-body text-center">
									<i class="far fa-user text-success fa-3x"></i>
									<h6 class="mt-4 mb-2">New Registration (24 hours)</h6>
									<h4 class="mb-2 number-font">20</h4>

								</div>
							</div>
						</div><!-- COL END -->
						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="card">
								<div class="card-body text-center">
									<i class="far fa-list-ol text-info fa-3x"></i>
									<h6 class="mt-4 mb-2">Upcoming Booking (Upcoming)</h6>
									<h4 class="mb-2  number-font">70k</h4>

								</div>
							</div>
						</div><!-- COL END -->

						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="card">
								<div class="card-body text-center">
									<i class="fal fa-times-square text-danger fa-3x"></i>
									<h6 class="mt-4 mb-2">Alternative (Unconfirmed)</h6>
									<h4 class="mb-2 number-font">20</h4>

								</div>
							</div>
						</div><!-- COL END -->
						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="card">
								<div class="card-body text-center">
									<i class="far fa-users text-info fa-3x"></i>
									<h6 class="mt-4 mb-2">Total Customers</h6>
									<h4 class="mb-2  number-font">70k</h4>

								</div>
							</div>
						</div><!-- COL END -->
					</div>







			</div>
		</div>
		<!-- main-content closed -->
	</div>



	<!-- FOOTER -->
	<footer class="footer">
		<div class="container">
			<div class="row align-items-center flex-row-reverse">
				<div class="col-md-12 col-sm-12 text-center">
					Copyright © 2021 <a href="#">Thriwe</a>.All rights reserved
				</div>
			</div>
		</div>
	</footer>
	<!-- FOOTER CLOSED -->
	</div>
	<!-- End Page -->

	<!-- BACK-TO-TOP -->
	<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

	<!-- JQUERY JS -->
	<script src="../public/assets/js/jquery.min.js"></script>

	<!-- BOOTSTRAP JS -->
	<script src="../public/assets/plugins/bootstrap/js/popper.min.js"></script>
	<script src="../public/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!-- INPUT MASK JS-->
	<script src="../public/assets/plugins/input-mask/jquery.mask.min.js"></script>

	<!-- SIDE-MENU JS -->
	<script src="../public/assets/plugins/sidemenu/sidemenu.js"></script>

	<!-- SIDEBAR JS -->
	<script src="../public/assets/plugins/sidebar/sidebar.js"></script>

	<!-- Perfect SCROLLBAR JS-->
	<script src="../public/assets/plugins/p-scroll/perfect-scrollbar.js"></script>
	<script src="../public/assets/plugins/p-scroll/pscroll.js"></script>
	<script src="../public/assets/plugins/p-scroll/pscroll-1.js"></script>


	<!-- INTERNAL SELECT2 JS -->
	<script src="../public/assets/plugins/select2/select2.full.min.js"></script>

	<!-- INTERNAL Data tables js-->
	<script src="../public/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="../public/assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
	<script src="../public/assets/plugins/datatable/dataTables.responsive.min.js"></script>

	<!-- ECHART JS-->
	<script src="../public/assets/plugins/echarts/echarts.js"></script>

	<!-- APEXCHART JS -->
	<!-- <script src="../public/assets/js/apexcharts.js"></script> -->

	<!-- INDEX JS -->
	<script src="../public/assets/js/index1.js"></script>


	<!-- CUSTOM JS-->
	<script src="../public/assets/js/custom.js"></script>

	<!-- Switcher js -->
	<!-- <script src="../public/assets/switcher/js/switcher.js"></script> -->
</body>


</html>