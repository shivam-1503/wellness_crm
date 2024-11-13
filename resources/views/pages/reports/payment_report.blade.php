@extends('layouts.app')

@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Customer <small>Details</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Customer Details</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="{{url('customers')}}"> <i class="fa fa-arrow-left"></i> Customer List</a>
    </div>

</div>
<!-- PAGE-HEADER END -->

@php $periods = [1 => 'Current Month', 2 => 'Last Month', 3 => 'Date Range'] @endphp

    <div class="content mt-3">

        <div class="card shadow mb-4">
        <!-- Default Card Example -->
            <div class="card-header">
                EMI List &nbsp;<span id="order_ref_span"></span> 
            </div>
            

            <div class="card-body">

                <div class="row mb-5">
                    <div class="col-md-4">
                        {{ Form::select('order_id', $customers, '', ['class'=>'standardSelect form-control mt-3', 'title'=>'Select Customer', 'data-live-search'=>'true', 'id'=>'customer_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::select('project_id', $projects, '', ['class'=>'standardSelect form-control mt-3', 'title'=>'Select Project', 'id'=>'project_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::select('property_type_id', $property_types, '', ['class'=>'standardSelect form-control mt-3', 'title'=>'Select Property Type', 'id'=>'property_type_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        {{ Form::select('period_id', $periods, '', ['class'=>'standardSelect form-control', 'title'=>'Select Time Period', 'id'=>'period_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>

                    <div class="col-md-3">
                        {{ Form::date('from_date', '', ['class'=>'form-control', 'id'=>'from_date']) }} 
                    </div>

                    <div class="col-md-3">
                        {{ Form::date('to_date', '', ['class'=>'form-control', 'id'=>'to_date']) }}           
                    </div>

                    <div class="col-md-2">
                        {{ Form::submit('Get Payments!',array('class'=>'btn btn-primary float-end', 'id' => 'submit')) }}
                    </div>
                </div>

            
                <hr>

                <div class="">
                    <table class="table table-design table-bordered text-nowrap border-bottom dt-responsive no-footer data-table" id="dataTable" cellspacing="0" width="100%" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Emi Months</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Payment Status</th>
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
                data: function ( d ) {
                        d._token = "{{ csrf_token() }}";
                        d.customer_id = $('#customer_id').val();
                        d.project_id = $('#project_id').val();
                        d.property_type_id = $('#property_type_id').val();
                        d.period_id = $('#period_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    },
                url: "{{ url('getPaymentsData') }}",
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
                {data: 'status', name: 'status', orderable: false, searchable: false},
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


        $('#submit').click(function (e) {
            // e.preventDefault();
            $(".data-table").DataTable().ajax.reload();
        });
        
    });


    function get_order_details(id)
    {
        $.ajax({
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            url: "{{ url('order/get_order_details') }}",
            type: "POST",
            dataType: 'json',

            success: function (data) {
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

                $('#order_ref_span').html('- '+$( "#order_id option:selected" ).text());
            }, 
            
            error: function (data) {
                if (data.status == 422) {
                    var x = data.responseJSON;
                    $.each(x.errors, function( index, value ) {
                        $("#"+index).addClass("is-invalid");
                        $("#"+index+"-error").html(value[0]);
                    });
                }
                $('#saveBtn').html('Save Changes');
            }
        });
    }


    function show_receipt(payment_id)
    {
        var id = payment_id;
        $.ajax({
            type : 'GET',
            url : '{{ url("generate-receipt") }}?e='+id,

            success: function(result, url) {
                var link =  '{{ url("generate-pdf") }}?e='+id;
                $("a.download_link").attr("href", link + '&export=pdf');

                $('.modal-title').html("Payment Receipt");
                $('.modal-body').html(result);
                $('#myModal').modal('show');

                $('.modal-container').load($(this).data('path'),function(result){
                    $('#myModal').modal({show:true});
                });
            }
        });
    }

</script>


@endsection
