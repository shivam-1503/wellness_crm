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

        .category {
            text-transform: capitalize;
            font-weight: 700;
            color: #9A9A9A;
        }

        body {
            color: #2c2c2c;
            font-size: 14px;
            font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
            overflow-x: hidden;
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
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
            box-shadow: 0px 5px 35px 0px rgba(0, 0, 0, 0.3);
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
            padding: 11px 30px;
            line-height: 1.5;
        }

        .nav-tabs>.nav-item>.nav-link:hover {
            background-color: transparent;
        }

        .nav-tabs>.nav-item>.nav-link.active {
            background-color: #444;
            border-radius: 30px;
            color: #ccc;
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
            margin-bottom: 30px;
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



        footer {
            margin-top: 50px;
            color: #555;
            background: #fff;
            padding: 25px;
            font-weight: 300;
            background: #f7f7f7;

        }

        .footer p {
            margin-bottom: 0;
        }

        footer p a {
            color: #555;
            font-weight: 400;
        }

        footer p a:hover {
            color: #e86c42;
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
            <h1>My Business Details <small>Update</small>
                <h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
        </div>

        <div class="float-end">
            <a class="btn btn-primary float-right" href="{{ url('/') }}" id="createNewProduct"> <i
                    class="fa fa-arrow-left"></i> Go to Dashboard</a>
        </div>

    </div>
    <!-- PAGE-HEADER END -->

    @php
        
    @endphp


    <div class="content mt-3">

        <div class="col-md-12 ml-aut mr-auto">
            <!-- Nav tabs -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('business/basic_details') }}">
                                Basic Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('business/social_details') }}">
                                Social Media Details
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('business/logo_details') }}">
                                Logo
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('business/email_details') }}">
                                Email Account Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('business/sms_details') }}">
                                Bulk SMS Details
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('business/preferances') }}">
                                Preferences
                            </a>
                        </li> -->
                    </ul>
                </div>
                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="tab-content">

                        {{-- Social Media Details Form --}}
                        <div class="tab-pane active" id="social_settings" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="float-end">
                                        <a class="btn btn-primary float-end" href="javascript:void(0)"
                                            id="updateSocialDetails"><i class="fa fa-plus"></i> Update Details</a>
                                    </div>
                                </div>
                            </div>


                            <h5 class="text-muted">SOCIAL MEDIA ACCOUNTS</h5>
                            <table class="table table-hover">

                                <tr>
                                    <td>Facebook</td>
                                    <td>{{$data->facebook}}</td>
                                </tr>

                                <tr>
                                    <td>Google +</td>
                                    <td>{{$data->google_plus}}</td>
                                </tr>

                                <tr>
                                    <td>Instagram</td>
                                    <td>{{$data->instagram}}</td>
                                </tr>

                                <tr>
                                    <td>LinkedIn</td>
                                    <td>{{$data->linkedin}}</td>
                                </tr>

                                <tr>
                                    <td>Youtube</td>
                                    <td>{{$data->youtube}}</td>
                                </tr>

                                <tr>
                                    <td>Google My Business</td>
                                    <td>{{$data->google_business}}</td>
                                </tr>

                                <tr>
                                    <td>Twitter</td>
                                    <td>{{$data->twitter}}</td>
                                </tr>
                            </table>

                        </div>


                      
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{ Form::hidden('company_id', '', ['id' => 'company_id']) }}

    @include('view-modals/business/social_details')

@stop


@section('scripting')

    <script type="text/javascript">
        $(document).ready(function() {

            $(".standardSelect").selectpicker();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.validator.setDefaults({
                debug: true
            });

        });


        //  Basic Details :: Click Event
        $('body').on('click', '#updateBasicDetails', function() {

            // reset_modal();
            $.get("{{ url('business/edit_basic_details') }}", function(data) {
                $('#basicDetailModalHeading').html("Edit Basic Details:");
                $('#basicDetailsModal').modal('show');
                $('#company_id').val(data.id);

                // Populate field details
                $('#name').val(data.name);
                $('#full_name').val(data.full_name);
                $('#established_in').val(data.established_in);
                $('#state_id').val(data.state_id);
                $('#address').val(data.address);
                $('#city').val(data.city);
                $('#pincode').val(data.pincode);
                $('#landline').val(data.landline);
                $('#fax').val(data.fax);
                $('#email').val(data.email);
                $('#phone').val(data.phone);

                $('.standardSelect').selectpicker('refresh');
            })
        });

        // Basic Details :: Update Function
        $("#basicForm").validate({

            errorClass: "is-invalid",

            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass);
                $(element).parent().removeClass(errorClass);
            },

            errorPlacement: function(error, element) {
                element.parent().append(error);
                $('.standardSelect').selectpicker('refresh');
            },


            rules: {
                full_name: 'required',
                name: 'required',
                state_id: 'required',
                city: 'required',
                pincode: 'required',
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                    number: true,
                },
            },

            messages: {
                full_name: "Please Enter Company Full Legal Name.",
                name: "Please Enter Company Name.",
                pincode: "Please Enter Pincode.",
                state_id: "Please Select State You Belong.",
                city: "Please Enter Your City.",
                email: {
                    required: "Please Enter Email Id",
                    email: "Please Enter Valid Email Id",
                },
                phone: {
                    required: "Please Enter Phone No",
                    number: "Phone No. must be a number.",
                }
            },

            submitHandler: function(form) {
                // form.submit();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#basicDetailsSaveBtn').html('Sending..');

                $.ajax({
                    data: $('#basicForm').serialize(),
                    url: "{{ url('business/basic_details/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(data) {
                        swal({
                                title: "Good job!",
                                text: data.msg,
                                icon: "success",
                            })
                            .then((willDelete) => {
                                window.location.reload();
                            });
                    },

                    error: function(data) {
                        if (data.status == 422) {
                            var x = data.responseJSON;
                            $.each(x.errors, function(index, value) {
                                console.log(index);
                                $("#" + index).addClass("is-invalid");
                                $('.standardSelect').selectpicker('refresh');
                                $("#" + index + "-error").html(value[0]);
                            });
                        }
                        $('#basicDetailsSaveBtn').html('Save Changes');
                    }
                });
            }
        });


//  Basic Details :: Click Event
        $('body').on('click', '#updateBasicDetails', function() {

            // reset_modal();
            $.get("{{ url('business/edit_basic_details') }}", function(data) {
                $('#basicDetailModalHeading').html("Edit Basic Details:");
                $('#basicDetailsModal').modal('show');
                $('#company_id').val(data.id);

                // Populate field details
                $('#name').val(data.name);
                $('#full_name').val(data.full_name);
                $('#established_in').val(data.established_in);
                $('#state_id').val(data.state_id);
                $('#address').val(data.address);
                $('#city').val(data.city);
                $('#pincode').val(data.pincode);
                $('#landline').val(data.landline);
                $('#fax').val(data.fax);
                $('#email').val(data.email);
                $('#phone').val(data.phone);

                $('.standardSelect').selectpicker('refresh');
            })
        });

        // Basic Details :: Update Function
        $("#basicForm").validate({

            errorClass: "is-invalid",

            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass);
                $(element).parent().removeClass(errorClass);
            },

            errorPlacement: function(error, element) {
                element.parent().append(error);
                $('.standardSelect').selectpicker('refresh');
            },


            rules: {
                full_name: 'required',
                name: 'required',
                state_id: 'required',
                city: 'required',
                pincode: 'required',
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                    number: true,
                },
            },

            messages: {
                full_name: "Please Enter Company Full Legal Name.",
                name: "Please Enter Company Name.",
                pincode: "Please Enter Pincode.",
                state_id: "Please Select State You Belong.",
                city: "Please Enter Your City.",
                email: {
                    required: "Please Enter Email Id",
                    email: "Please Enter Valid Email Id",
                },
                phone: {
                    required: "Please Enter Phone No",
                    number: "Phone No. must be a number.",
                }
            },

            submitHandler: function(form) {
                // form.submit();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#basicDetailsSaveBtn').html('Sending..');

                $.ajax({
                    data: $('#basicForm').serialize(),
                    url: "{{ url('business/basic_details/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(data) {
                        swal({
                                title: "Good job!",
                                text: data.msg,
                                icon: "success",
                            })
                            .then((willDelete) => {
                                window.location.reload();
                            });
                    },

                    error: function(data) {
                        if (data.status == 422) {
                            var x = data.responseJSON;
                            $.each(x.errors, function(index, value) {
                                console.log(index);
                                $("#" + index).addClass("is-invalid");
                                $('.standardSelect').selectpicker('refresh');
                                $("#" + index + "-error").html(value[0]);
                            });
                        }
                        $('#basicDetailsSaveBtn').html('Save Changes');
                    }
                });
            }
        });



        //  Social Details :: Click Event
        $('body').on('click', '#updateSocialDetails', function() {

            // reset_modal();
            $.get("{{ url('business/edit_social_details') }}", function(data) {
                $('#socialDetailModalHeading').html("Edit Social Details:");
                $('#socialDetailsModal').modal('show');

                // Populate field details
                $('#facebook').val(data.facebook);
                $('#google_plus').val(data.google_plus);
                $('#instagram').val(data.instagram);
                $('#linkedin').val(data.linkedin);
                $('#youtube').val(data.youtube);
                $('#google_business').val(data.google_business);
                $('#twitter').val(data.twitter);
            })
        });



        // Social Details :: Update Function
        $("#socialForm").validate({

            errorClass: "is-invalid",

            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass);
                $(element).parent().removeClass(errorClass);
            },

            errorPlacement: function(error, element) {
                element.parent().append(error);
                $('.standardSelect').selectpicker('refresh');
            },


            rules: {
                facebook: 'url',
                instagram: 'url',
            },

            messages: {
                facebook: "Please Enter Valid URL.",
                instagram: "Please Enter Valid URL.",
            },

            submitHandler: function(form) {
                // form.submit();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#socialDetailsSaveBtn').html('Sending..');

                $.ajax({
                    data: $('#socialForm').serialize(),
                    url: "{{ url('business/social_details/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(data) {
                        swal({
                                title: "Good job!",
                                text: data.msg,
                                icon: "success",
                            })
                            .then((willDelete) => {
                                window.location.reload();
                            });
                    },

                    error: function(data) {
                        if (data.status == 422) {
                            var x = data.responseJSON;
                            $.each(x.errors, function(index, value) {
                                console.log(index);
                                $("#" + index).addClass("is-invalid");
                                $('.standardSelect').selectpicker('refresh');
                                $("#" + index + "-error").html(value[0]);
                            });
                        }
                        $('#socialDetailsSaveBtn').html('Save Changes');
                    }
                });
            }
        });







    </script>
@stop
