<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<!-- META DATA -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">


	<!-- TITLE -->
    <title>{{ config('app.name', 'Codeigniter') }}</title>


	
    <!-- FAVICON -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend_assets/images/favicon/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend_assets/images/favicon/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend_assets/images/favicon/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('backend_assets/images/favicon/site.webmanifest') }}">



	<!-- BOOTSTRAP CSS -->
	<link href="{{ asset('backend_assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

	<!-- STYLE CSS -->
	<link href="{{ asset('backend_assets/css/style.css') }}" rel="stylesheet" />
	{{-- <link href="{{ asset('backend_assets/css/dark-style.css') }}" rel="stylesheet" />
	<link href="{{ asset('backend_assets/css/skin-modes.css') }}" rel="stylesheet" /> --}}

	<!-- SIDE-MENU CSS -->
	<link href="{{ asset('backend_assets/css/sidemenu.css') }}" rel="stylesheet" id="sidemenu-theme">

	<!-- P-scroll bar css-->
	<link href="{{ asset('backend_assets/plugins/p-scroll/perfect-scrollbar.css') }}" rel="stylesheet" />


	<!-- SELECT2 CSS -->
	<link href="{{ asset('backend_assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

	<!-- INTERNAL Data table css -->
	<link href="{{ asset('backend_assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
	<link href="{{ asset('backend_assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
	
	<link href="{{ asset('backend_assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" />


	<!--- FONT-ICONS CSS -->
	<link href="{{ asset('backend_assets/css/icons.css') }}" rel="stylesheet" />
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
		integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

	<!-- SIDEBAR CSS -->
	<link href="{{ asset('backend_assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

	<!-- COLOR SKIN CSS -->
	<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('backend_assets/colors/color1.css') }}" />


	<style>

		.title h3{
			font-weight:300;
			font-size:25px;
			margin-top:25px;
			color: #3C4858;
		}

		.modal-dialog .modal-content{
			box-shadow: 0 27px 24px 0 rgba(0, 0, 0, 0.2), 0 40px 77px 0 rgba(0, 0, 0, 0.22);
			border-radius: 6px;
			border: none;
		}
		.modal-dialog .modal-header{
			border-bottom: none;
		}

		.modal-dialog .modal-footer{
			border-top: none;
			padding-top: 0px !important;
			/* padding: 24px !important; */
		}

		.modal-dialog {
			margin-top: 50px;
		}


		.modal-dialog .modal-header .card-header{
			width: 100%;
		}

		.modal-dialog .modal-header .close {
			color: #fff;
			right: 40px;
			text-shadow: none;
			position: absolute;
			border: none;
			background: none;
		}

		.modal-dialog .modal-header .close i{
			color: #fff;
		}

		.modal-dialog .modal-header .close i:hover{
			color: #7ED50E !important;
		}


		.modal-dialog .card .card-title{
			color: #fff;
			font-size: 16px !important;
			/* font-weight: 700 !important; */
			/* margin-top:10px; */
		}

		.modal-dialog .card .card-header{
			border-radius: 3px !important;
			padding: 1rem 15px;
			margin-top: -30px;
			border: 0;
		}

		.modal-dialog .card .card-header-primary {
			/* box-shadow: 0 5px 20px 0 rgba(0,0,0,.2), 0 13px 24px -11px rgba(156,39,176,.6); */
			box-shadow: 0 5px 20px 0 rgba(0,0,0,.2), 0 13px 24px -11px rgba(108,96,209,.6);
			/* background: linear-gradient(60deg,#ab47bc,#7b1fa2) */
			background: linear-gradient(60deg,#9e88f5,#6359ca)
		}

		/* .modal-dialog .modal-footer button {
			margin: 0;
			padding-left: 16px;
			padding-right: 16px;
			width: auto;
		} */


		label.is-invalid {
			color: #a94442;
		}


	</style>



</head>