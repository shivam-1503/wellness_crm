@extends('layouts.app')
@section('content')


@php $payment_modes = ['cash' => 'Cash', 'cheque' => 'Cheque', 'netbanking' => 'Net Banking', 'upi' => 'UPI'] @endphp
@php $payment_status = ['0' => 'No Payment', '1' => 'Partial Payment', '2' => 'Complete Payment'] @endphp

<style>

    .icon {
        width: 3rem;
        height: 3rem;
        box-shadow: 0 0 15px 5px rgba(128, 128, 128, 0.25) !important;
    }

    .icon i {
        font-size: 1.75rem;
    }

    .icon-shape {
        display: inline-flex;
        padding: 12px;
        text-align: center;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
    }

</style>

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Expense <small>Report</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
    <!-- <a class="btn btn-primary" href="{{url('lead/create')}}" id="createNewProduct"><i class="fa fa-plus"></i> Add New Lead</a> -->
    </div>

</div>
<!-- PAGE-HEADER END -->


<div class="content mt-3">


    <div class="row mb-5">

        <div class="col-lg-4 col-md-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-muted mb-2">Total Amount</h5>
                            <span class="h2 font-weight-bold mb-0" id="amountTotal"></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                <i class="fa fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-muted mb-2">Total Amount Paid</h5>
                            <span class="h2 font-weight-bold mb-0" id="amountPaidTotal"></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                <i class="fa fa-money-bill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-muted mb-2">Total Balance Amount</h5>
                            <span class="h2 font-weight-bold mb-0" id="balanceTotal"></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                <i class="fa fa-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        


    </div>



    <div class="card shadow mb-4">

        <div class="card-header">
            <strong>Expense Report</strong>
        </div>

        <div class="card-body">
            <div class="">

                <div class="row mb-3">
                
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('cat_id', [''=>'Select Category']+$cats, '', ['class'=>'standardSelect form-control', 'title'=>'Select Category', 'data-live-search'=>'true', 'id'=>'cat_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>                
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('sub_cat_id', [''=>'Select Sub Category'], '', ['class'=>'standardSelect form-control', 'title'=>'Select sub category', 'id'=>'sub_cat_id']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('vendor_id', [''=>'Select Vendor']+$vendors, '', ['class'=>'standardSelect form-control', 'title'=>'Select Property', 'id'=>'vendor_id']) }}
                    </div>
                    <!-- <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('payment_status', [''=>'Select Payment Status']+$payment_status, '', ['class'=>'standardSelect form-control', 'title'=>'Select Payment Status', 'data-live-search'=>'true', 'id'=>'payment_status' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div> -->
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('user_id', [''=>'Select Payment User']+$users, '', ['class'=>'standardSelect form-control', 'title'=>'Select Payment User', 'data-live-search'=>'true', 'id'=>'user_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3">
                        {{ Form::date('start_date','',['class'=>'form-control', 'id'=>"start_date"]) }}
                    </div>
                    <div class="col-md-3">
                        {{ Form::date('end_date','',['class'=>'form-control', 'id'=>"end_date"]) }}
                    </div>
                </div>

                <div class="table-responsive">
                <table class="table table-bordered data-table" id="file-datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20px">S.No.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Sub Cat</th>
                            <th>Vendor</th>
                            <th>Amount</th>
                            <th>Amount Paid</th>
                            <th>Payment Mode</th>
                            <th>Payment By</th>
                            <th>Transaction Date</th>
                            <th>Create Date</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right">Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>

                    <tbody>
                    </tbody>
                </table>
</div>
            </div>
        </div>

    </div>
</div>
</div>


@stop



@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#file-datatable').DataTable({
            "dom": 'Bfrtip',
		    "buttons": ['pdf', 
                        {
                            extend: 'excel',
                            text: 'Excel',
                            title: 'Expense Report | Date: '+"{{date('d M, Y')}}",
                            orientation: 'landscape',
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Expense Report | Date: '+"{{date('d M, Y')}}",
                            orientation: 'landscape',
                        },
                        'pageLength'], 	
		    "pageLength": 100,
		    "processing": false,
		    responsive: false,
            processing: true,
            serverSide: true,
            // ajax: "{{ url('getleadsData') }}",
            ajax: {
                data: function ( d ) {
                        d.vendor_id = $('#vendor_id').val();
                        d.cat_id = $('#cat_id').val();
                        d.sub_cat_id = $('#sub_cat_id').val();
                        d.payment_status = $('#payment_status').val();
                        d.user_id = $('#user_id').val();
                        d.from_date = $('#start_date').val();
                        d.to_date = $('#end_date').val();
                        d._token = "{{ csrf_token() }}";
                    },
                url: "{{ url('getExpenseReportData') }}",
                type: "POST",
                dataType: 'json',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                {data: 'title', name: 'title', orderable: false, searchable: false},
                {data: 'description', name: 'description', orderable: false, searchable: true},
                {data: 'category', name: 'category', orderable: false, searchable: true},
                {data: 'sub_category', name: 'sub_category', orderable: false, searchable: true},
                {data: 'vendor', name: 'vendor', orderable: false, searchable: true},
                {data: 'amount', name: 'amount', orderable: false, searchable: false},
                {data: 'amount_paid', name: 'amount_paid', orderable: false, searchable: false},
                {data: 'payment_mode', name: 'payment_mode', orderable: false, searchable: false},
                {data: 'payment_user', name: 'payment_user', orderable: false, searchable: false},
                {data: 'transaction_date', name: 'transaction_date', orderable: false, searchable: false},
                {data: 'date', name: 'date', orderable: false, searchable: false},
            ],

            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
      
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                amountTotal = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    } );

                amountPaidTotal = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    } );
                    
                
    
                // Total over this page
                pageTotal = api
                    .column( 6, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                
                    // Update footer
                // $( api.column( 6 ).footer() ).html(
                    
                //     '$'+pageTotal +' ( $'+ total +' total)'
                // );


                $('#amountTotal').html('Rs '+amountTotal.toLocaleString());
                $('#amountPaidTotal').html('Rs '+amountPaidTotal.toLocaleString());
                $('#balanceTotal').html('Rs '+ (amountTotal - amountPaidTotal).toLocaleString());

                $( api.column( 6 ).footer() ).html(
                    
                    amountTotal
                );

                $( api.column( 7 ).footer() ).html(
                    
                    amountPaidTotal
                );

                $( api.column( 8 ).footer() ).html(
                    
                    amountTotal - amountPaidTotal
                );
            },
            order: [[0, 'desc']]


        });

        table.buttons().container()
		.appendTo('#file-datatable_wrapper .col-md-6:eq(0)');

        table.on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({placement: 'top',});
        });


        $('#vendor_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#user_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });

        $('#cat_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#sub_cat_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#start_date').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#end_date').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        
        





    });


    $('#cat_id').change(function() {
        var cat_id = $('#cat_id').val();
        getSubCats(cat_id);
    })


    function getSubCats(cat_id, category=false)
    {
        $.ajax({
			type: "get",
			url: "{{url('getExpenseSubCatsbyCatId/')}}/"+cat_id,
			dataType: "json",
			success: function(res) {

				if (res.success) {
					var options_htm = '<option value="">Select Sub Category</option>';
					$.each(res.data, function(key, val) {
						options_htm += '<option value="' + key + '">' + val + '</option>';
					});

					$('#sub_cat_id').html(options_htm);

                    if(category) {
                        $('#sub_cat_id').val(category);
                    }
                    $('.standardSelect').selectpicker('refresh');
				}
			}
		})
    }



    function reset_modal() {
    	$("#cat_id").val("");
    	$("name").val("");
    	//$('#status').val("").trigger("chosen:updated");
    	$('#status').val("");
		$('.standardSelect').selectpicker('refresh');

        $("#name").removeClass("is-invalid");
        $("#country_id_fk").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#name-error").html("");
        $("#country_id_fk-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');
    }




</script>


@endsection
