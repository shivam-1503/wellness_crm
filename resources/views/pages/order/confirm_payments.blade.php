@extends('layouts.app')

@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Payments <small>View & Confirm</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Payments Confirm</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="{{url('receive_payments')}}"> <i class="fa fa-arrow-left"></i> Recieve Payments</a>
    </div>

</div>
<!-- PAGE-HEADER END -->

    <div class="content mt-3">

        <div class="card shadow mb-4">
        <!-- Default Card Example -->
            <div class="card-header">
                Payments List 
            </div>
            

            <div class="card-body">

                

                <div class="">
                    <table class="table table-design table-bordered text-nowrap border-bottom dt-responsive no-footer data-table" id="dataTable" cellspacing="0" width="100%" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Mode</th>
                                <th>Payment Ref</th>
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
                    <h5 class="modal-title">Invoice</h5>
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


@stop

@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {


        $('body').tooltip({selector: '[data-bs-toggle="tooltip"]'});


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
                url: "{{ url('getAwaitedPaymentsData') }}",
                type: "POST",
                dataType: 'json',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'months', name: 'months', orderable: false, searchable: false},
                {data: 'amount_paid', name: 'amount_paid'},
                {data: 'payment_date', name: 'payment_date'},
                {data: 'payment_mode', name: 'payment_mode'},
                {data: 'payment_ref_no', name: 'payment_ref_no', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });

        table.on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({placement: 'top',});
        });
        
    });


    function view_payment(payment_id)
    {
        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to approove this payment?',
            content: {
                element: "input",
                attributes: {
                    placeholder: "Enter Your Remarks Here..",
                },
            },

            //buttons: true,
            
            // button: {
            //     text: "Approove Payment!",
            //     closeModal: false,
            // },

            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "Approove Payment!",
                    closeModal: false,
                }
            },

        })
        .then(remarks => {

            if(remarks != null) {
                var id = payment_id;
                $.ajax({
                    data: {"_token": "{{ csrf_token() }}", 'id': id, 'remarks': remarks},
                    url: "{{ url('comfirm_payment_store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        swal({
                            title: "Good job!",
                            text: data.msg,
                            icon: "success",
                        }).then(refresh => {
                            $(".data-table").DataTable().ajax.reload();
                        })
                    },

                    error: function (data) {
                        if (data.status == 422) {
                            var x = data.responseJSON;
                            $.each(x.errors, function( index, value ) {
                                console.log(index);
                                $("#"+index).addClass("is-invalid");
                                $('.standardSelect').selectpicker('refresh');
                                $("#"+index+"-error").html(value[0]);
                            });
                        }
                        $('#saveBtn').html('Save Changes');
                    }
                });
            }
            else {
                swal("Oh noes!", "Process Cancelled!", "error"); 
            }
        })
        .catch(err => {
            if (err) {
                swal("Oh noes!", "The AJAX request failed!", "error");
            } else {
                swal.stopLoading();
                swal.close();
            }
        });        
    }




    function reject_payment(payment_id)
    {
        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to Reject this payment?',
            dangerMode: true,
            content: {
                element: "input",
                attributes: {
                    placeholder: "Enter Your Remarks Here..",
                },
            },
            button: {
                text: "Approove Payment!",
                closeModal: false,
            },
        })
        .then(remarks => {
            var id = payment_id;
            $.ajax({
                data: {"_token": "{{ csrf_token() }}", 'id': id, 'remarks': remarks},
                url: "{{ url('reject_payment_store') }}",
                type: "POST",
                dataType: 'json',

                success: function (data) {
                    swal({
                        title: "Good job!",
                        text: data.msg,
                        icon: "success",
                    }).then(refresh => {
                        $(".data-table").DataTable().ajax.reload();
                    })
                },

                error: function (data) {
                    if (data.status == 422) {
                        var x = data.responseJSON;
                        $.each(x.errors, function( index, value ) {
                            console.log(index);
                            $("#"+index).addClass("is-invalid");
                            $('.standardSelect').selectpicker('refresh');
                            $("#"+index+"-error").html(value[0]);
                        });
                    }
                    $('#saveBtn').html('Save Changes');
                }
            });
        })
        .catch(err => {
            if (err) {
                swal("Oh noes!", "The AJAX request failed!", "error");
            } else {
                swal.stopLoading();
                swal.close();
            }
        });   
    }


</script>


@endsection
