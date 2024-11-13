@extends('layouts.app')
@section('content')


    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1>Invoices <small>Details</small></h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Customer Details</li>
            </ol>
        </div>

        <div class="float-end">
            <a class="btn btn-primary float-right" href="{{ url('customers') }}"> <i class="fa fa-arrow-left"></i> Invoices
                List</a>
        </div>

    </div>
    <!-- PAGE-HEADER END -->


    @php $periods = [1 => 'Current Month', 2 => 'Last Month', 3 => 'Date Range'] @endphp
    

    <div class="content mt-3">

        <div class="card shadow mb-4">
            
            {{-- <div class="card-header">
                Customer List
            </div> --}}

            <div class="card-body">

                <div class="row mb-5">
                    <div class="col-md-4">
                        {{ Form::select('order_id', [''=>'Select Customer']+$customers, '', ['class' => 'standardSelect form-control mt-3', 'title' => 'Select Customer', 'data-live-search' => 'true', 'id' => 'customer_id', 'data-size' => '5']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::select('project_id', $projects, '', ['class' => 'standardSelect form-control mt-3', 'title' => 'Select Project', 'id' => 'project_id', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::select('property_type_id', $property_types, '', ['class' => 'standardSelect form-control mt-3', 'title' => 'Select Property Type', 'id' => 'property_type_id', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        {{ Form::select('period_id', $periods, '', ['class' => 'standardSelect form-control', 'title' => 'Select Time Period', 'id' => 'period_id', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                    </div>

                    <div class="col-md-3">
                        {{ Form::date('from_date', '', ['class' => 'form-control', 'id' => 'from_date']) }}
                    </div>

                    <div class="col-md-3">
                        {{ Form::date('to_date', '', ['class' => 'form-control', 'id' => 'to_date']) }}
                    </div>

                    <div class="col-md-2">
                        {{ Form::submit('Get Payments!', ['class' => 'btn btn-primary float-end', 'id' => 'submit']) }}
                    </div>
                </div>


                <hr>

                <div class="table-responsive">
                    <table
                        class="table table-design table-bordered text-nowrap border-bottom dt-responsive no-footer data-table"
                        id="dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>EMI</th>
                                <th>Amount</th>
                                <th>Invoice Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>


        <!-- Invoice Modal Starts -->
        <div class="modal fade" tabindex="-1" role="dialog" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Receipt</h5>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            <a  href="#" class="btn btn-primary download_link"><i class="fa fa-file-pdf"></i> &nbsp; Download PDF</a>
                        </div>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Invoice Modal Ends -->
        

    @include('view-modals/add_details');
    @include('view-modals/invoice_activities_timeline');


@stop

@section('scripting')

    <script type="text/javascript">
        $(document).ready(function() {


            $('body').tooltip({
                selector: '[data-bs-toggle="tooltip"]'
            });


            $(".standardSelect").selectpicker();

            // var order_id = $('#order_id').val();
            // get_order_details(order_id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.customer_id = $('#customer_id').val();
                        d.project_id = $('#project_id').val();
                        d.property_type_id = $('#property_type_id').val();
                        d.period_id = $('#period_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    },
                    url: "{{ url('getInvoicesData') }}",
                    type: "POST",
                    dataType: 'json',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'months',
                        name: 'months',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'emi_amount',
                        name: 'emi_amount'
                    },
                    {data: 'invoice_date', name: 'invoice_date',orderable: false, searchable: false},
                    {data: 'due_date', name: 'due_date', orderable: false,  searchable: false},
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });

            table.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip({
                    placement: 'top',
                });
            });


            $('#submit').click(function(e) {
                // e.preventDefault();
                $(".data-table").DataTable().ajax.reload();
            });



            // Initiate Activity Modal
            $('body').on('click', '.addDetails', function() {
                var emi_id = $(this).data('id');
                $('#addDetailsModel').modal('show');
                $('.emi_id').val(emi_id);

                $('#customer_name').html($(this).data('customer_name'));

                const amount = $(this).data('amount');

                let rupee = new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                });

                $('#customer_emi_amount').html(rupee.format(amount));
            });


            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#dataForm').serialize(),
                    url: "{{ url('category/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(data) {
                        $('#dataForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        swal({
                            title: "Good job!",
                            text: data.msg,
                            icon: "success",
                        });
                    },
                    error: function(data) {
                        if (data.status == 422) {
                            var x = data.responseJSON;
                            $.each(x.errors, function(index, value) {
                                $("#" + index).addClass("is-invalid");
                                $("#" + index + "-error").html(value[0]);
                            });
                        }
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });


        });



        function get_order_details(id) {
            $.ajax({
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                url: "{{ url('order/get_order_details') }}",
                type: "POST",
                dataType: 'json',

                success: function(data) {
                    // console.log(data);

                    $('#advance').html(data.advance);
                    $('#amount').html(data.amount);
                    $('#emi_amount').html(data.emi_amount);
                    $('#location').html(data.location);
                    $('#months').html(data.months);
                    $('#order_date').html(data.order_date);
                    $('#order_ref').html(data.order_ref);
                    $('#project').html(data.project);
                    $('#property').html(data.property);
                    $('#property_type').html(data.property_type);
                    $('#emi_paid').html(data.emi_paid);
                    $('#upcoming_emi_date').html(data.upcoming_emi_date);

                    $('#order_ref_span').html('- ' + $("#order_id option:selected").text());
                },

                error: function(data) {
                    if (data.status == 422) {
                        var x = data.responseJSON;
                        $.each(x.errors, function(index, value) {
                            $("#" + index).addClass("is-invalid");
                            $("#" + index + "-error").html(value[0]);
                        });
                    }
                    $('#saveBtn').html('Save Changes');
                }
            });
        }


        function show_receipt(payment_id) {
            var id = payment_id;
            $.ajax({
                type: 'GET',
                url: '{{ url('generate-receipt') }}?e=' + id,

                success: function(result, url) {
                    var link = '{{ url('generate-pdf') }}?e=' + id;
                    $("a.download_link").attr("href", link + '&export=pdf');

                    $('.modal-title').html("Payment Receipt");
                    $('.modal-body').html(result);
                    $('#myModal').modal('show');

                    $('.modal-container').load($(this).data('path'), function(result) {
                        $('#myModal').modal({
                            show: true
                        });
                    });
                }
            });
        }







        // Add Comment Activity
        $('#commentBtn').click(function(e) {
            e.preventDefault();

            swal({
                    title: "Are you sure?",
                    text: "You want to add comment!",
                    icon: "warning",
                    dangerMode: true,

                    buttons: {
                        cancel: "Cancel",
                        confirm: {
                            text: "Submit Comment!",
                            closeModal: false,
                        }
                    },
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#commentForm').submit();
                    } else {
                        swal("Please Correct the Details!");
                    }
                });
        })


        $("#commentForm").validate({

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
                emi_id: 'required',
                comment: 'required',
            },

            messages: {
                emi_id: 'Invalid Data. Please refresh and try again.',
                comment: 'Please enter comment',
            },

            submitHandler: function(form) {
                // form.submit();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#commentBtn').prop('disabled', true);

                $.ajax({
                    data: $('#commentForm').serialize(),
                    url: "{{ url('invoice/comment/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(response) {

                        if (response.success) {
                            swal({
                                    title: "Good job!",
                                    text: response.msg,
                                    icon: "success",
                                })
                                .then((willDelete) => {
                                    $('#addDetailsModel').modal('hide');
                                });
                        } else {
                            swal({
                                    title: "Sorry!",
                                    text: response.msg,
                                    icon: "error",
                                })
                                .then((willDelete) => {
                                    $('#addDetailsModel').modal('hide');
                                });
                        }
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
                        $('#commentBtn').prop('disabled', false);

                    }
                });
            }
        });



        // Add Wait Activity
        $('#waitingBtn').click(function(e) {
            e.preventDefault();

            swal({
                    title: "Are you sure?",
                    text: "You want to add Waiting Days!",
                    icon: "warning",
                    dangerMode: true,

                    buttons: {
                        cancel: "Cancel",
                        confirm: {
                            text: "Submit Waiting Days!",
                            closeModal: false,
                        }
                    },
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#waitingForm').submit();
                    } else {
                        swal("Please Correct the Details!");
                    }
                });
        })

        $("#waitingForm").validate({

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
                emi_id: 'required',
                waiting_days: 'required',
                description: 'required',
            },

            messages: {
                emi_id: 'Invalid Data. Please refresh and try again.',
                waiting_days: 'Please enter Waiting Days',
                description: 'Please enter Description',
            },

            submitHandler: function(form) {
                // form.submit();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#waitingBtn').prop('disabled', true);

                $.ajax({
                    data: $('#waitingForm').serialize(),
                    url: "{{ url('invoice/waiting/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(response) {

                        if (response.success) {
                            swal({
                                    title: "Good job!",
                                    text: response.msg,
                                    icon: "success",
                                })
                                .then((willDelete) => {
                                    $('#addDetailsModel').modal('hide');
                                });
                        } else {
                            swal({
                                    title: "Sorry!",
                                    text: response.msg,
                                    icon: "error",
                                })
                                .then((willDelete) => {
                                    $('#addDetailsModel').modal('hide');
                                });
                        }
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
                        $('#waitingBtn').prop('disabled', false);

                    }
                });
            }
        });




        // Add Call Activity
        $('#callBtn').click(function(e) {
            e.preventDefault();

            swal({
                    title: "Are you sure?",
                    text: "You want to add call!",
                    icon: "warning",
                    dangerMode: true,

                    buttons: {
                        cancel: "Cancel",
                        confirm: {
                            text: "Submit call!",
                            closeModal: false,
                        }
                    },
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#callForm').submit();
                    } else {
                        swal("Please Correct the Details!");
                    }
                });
        })

        $("#callForm").validate({

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
                emi_id: 'required',
                call_time: 'required',
                call_with: 'required',
                description: 'required',
            },

            messages: {
                emi_id: 'Invalid Data. Please refresh and try again.',
                call_time: 'Please enter call Time',
                call_with: 'Please enter Name of Person',
                description: 'Please enter Description',
            },

            submitHandler: function(form) {
                // form.submit();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#callBtn').prop('disabled', true);

                $.ajax({
                    data: $('#callForm').serialize(),
                    url: "{{ url('invoice/call/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(response) {

                        if (response.success) {
                            swal({
                                    title: "Good job!",
                                    text: response.msg,
                                    icon: "success",
                                })
                                .then((willDelete) => {
                                    $('#addDetailsModel').modal('hide');
                                });
                        } else {
                            swal({
                                    title: "Sorry!",
                                    text: response.msg,
                                    icon: "error",
                                })
                                .then((willDelete) => {
                                    $('#addDetailsModel').modal('hide');
                                });
                        }
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
                        $('#callBtn').prop('disabled', false);

                    }
                });
            }
        });




        // Add Wait Activity
        $('#meetingBtn').click(function(e) {
            e.preventDefault();

            swal({
                    title: "Are you sure?",
                    text: "You want to add meeting!",
                    icon: "warning",
                    dangerMode: true,

                    buttons: {
                        cancel: "Cancel",
                        confirm: {
                            text: "Submit Meeting!",
                            closeModal: false,
                        }
                    },
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#meetingForm').submit();
                    } else {
                        swal("Please Correct the Details!");
                    }
                });
        })

        $("#meetingForm").validate({

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
                emi_id: 'required',
                meeting_time: 'required',
                meeting_with: 'required',
                location: 'required',
                description: 'required',
            },

            messages: {
                emi_id: 'Invalid Data. Please refresh and try again.',
                meeting_time: 'Please enter meeting time',
                meeting_with: 'Please enter name of person',
                location: 'Please enter meeting location',
                description: 'Please enter Description',
            },

            submitHandler: function(form) {
                // form.submit();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#meetingBtn').prop('disabled', true);

                $.ajax({
                    data: $('#meetingForm').serialize(),
                    url: "{{ url('invoice/meeting/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(response) {

                        if (response.success) {
                            swal({
                                    title: "Good job!",
                                    text: response.msg,
                                    icon: "success",
                                })
                                .then((willDelete) => {
                                    $('#addDetailsModel').modal('hide');
                                });
                        } else {
                            swal({
                                    title: "Sorry!",
                                    text: response.msg,
                                    icon: "error",
                                })
                                .then((willDelete) => {
                                    $('#addDetailsModel').modal('hide');
                                });
                        }
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
                        $('#meetingBtn').prop('disabled', false);

                    }
                });
            }
        });





        // Get All Activity
        $('body').on('click', '.showDetails', function() {
            var emi_id = $(this).data('id');
            var id = emi_id;
            $.ajax({
                type: 'GET',
                url: '{{ url('invoice/get_activities') }}?e=' + id,

                success: function(result) {

                    $('.modal-title').html("All Activities");

                    // var data = '';

                    // console.log(result);

                    // $.each(result.msg, function(key, value) {

                    //     data = data + '<div class="col-md-12 mt-3 bg-success">'+value.comment+'</div>';

                    // })

                    // console.log(data);



                    $('#timeline-content').html(result.msg);
                    $('#activityModal').modal('show');

                }
            });

            // $('#customer_name').html($(this).data('customer_name'));

            // const amount = $(this).data('amount');

            // let rupee = new Intl.NumberFormat('en-IN', {
            //     style: 'currency',
            //     currency: 'INR',
            // });

            // $('#customer_emi_amount').html(rupee.format(amount));
        });
    </script>


@endsection
