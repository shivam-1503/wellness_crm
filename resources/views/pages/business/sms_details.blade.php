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
                            <a class="nav-link" href="{{ url('business/social_details') }}">
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
                            <a class="nav-link active" href="{{ url('business/sms_details') }}">
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
                                            id="updateSmsDetails"><i class="fa fa-plus"></i> Update Details</a>
                                    </div>
                                </div>
                            </div>


                            <h5 class="text-muted">SMS ACCOUNT DETAILS</h5>
                            <table class="table table-hover">

                                <tr>
                                    <td>SMS Host Endpoint</td>
                                    <td>{{$data->endpoint}}</td>
                                </tr>

                                <tr>
                                    <td>Username</td>
                                    <td>{{$data->username}}</td>
                                </tr>

                                <tr>
                                    <td>Password</td>
                                    <td>{{$data->password}}</td>
                                </tr>

                                <tr>
                                    <td>Bearer Token</td>
                                    <td>{{$data->bearer_token}}</td>
                                </tr>

                                <tr>
                                    <td>Sender Name</td>
                                    <td>{{$data->sender_name}}</td>
                                </tr>
                            </table>

                        </div>


                      
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('view-modals/business/sms_details')

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
        $('body').on('click', '#updateSmsDetails', function() {

            // reset_modal();
            $.get("{{ url('business/edit_sms_details') }}", function(data) {
                $('#smsDetailModalHeading').html("Edit Basic Details:");
                $('#smsDetailsModal').modal('show');

                // Populate field details
                $('#endpoint').val(data.endpoint);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#bearer_token').val(data.bearer_token);
                $('#sender_name').val(data.sender_name);
            })
        });

        // Basic Details :: Update Function
        $("#smsForm").validate({

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
                sender_name: 'required',
                endpoint: {
                    required: true,
                    url: true,
                },
            },

            messages: {
                sender_name: "Please Enter Sender Name.",
                endpoint: {
                    required: "Please Enter Endpoint",
                    url: "Please Enter Valid Endpoint",
                },
            },

            submitHandler: function(form) {
                // form.submit();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#smsDetailsSaveBtn').html('Sending..');

                $.ajax({
                    data: $('#smsForm').serialize(),
                    url: "{{ url('business/sms_details/store') }}",
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
                        $('#smsDetailsSaveBtn').html('Save Changes');
                    }
                });
            }
        });


    </script>
@stop
