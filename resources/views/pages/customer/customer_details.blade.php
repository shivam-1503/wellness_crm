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


    <div class="content mt-3">

        <div class="card shadow mb-4">
            <div class="card-header">
                Customer Details
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="card mt-3">
                            <div class="card-header">Personal Details: </div>
                            <div class="card-body">
                                <table class="table table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td class="float-end">{{ $details->first_name.' '.$details->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth</td>
                                        <td class="float-end">{{ date('d M, Y', strtotime($details->dob)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>UIDAI <em>(AADHAR)</em></td>
                                        <td class="float-end">{{ $details->uidai }}</td>
                                    </tr>
                                    <tr>
                                        <td>PAN Number</td>
                                        <td class="float-end">{{ $details->pan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td class="float-end">{{ $details->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td class="float-end">{{ $details->phone }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>

                        <!-- <div class="card mt-3">
                            <div class="card-header">Other Details: </div>
                            <div class="card-body">

                            </div>
                        </div> -->
                    </div>

                    <div class="col-sm-8 side-content">
                        
                    @if(!empty($orders))

                        {{ Form::select('order_id', $orders, '', ['class'=>'standardSelect form-control mt-3', 'title'=>'Select Order', 'id'=>'order_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="source_id-error"></span>


                        <hr>


                        <div class="card mt-3">
                            <div class="card-body">
                                <center>
                                <h4 class="mb-1"><span id="project"></span></h4>
                                <p class="lead" id="location"></p>
                                </center>

                                <!-- <small>Property</small> -->

                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h4 class="card-title">Property Details: </h4>
                                    </div>
                                    <div class="ml-auto p-2">
                                        <span class="badge bg-primary text-end" id="property_type"></span>
                                    </div>
                                </div>
                                <h6 class="card-subtitle mb-3 text-muted" id="property"></h6>
                                
                                
    
                                <hr>


                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h4 class="card-title">Order Details: </h4>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="badge bg-primary text-end">Order Ref: <span id="order_ref"></span></span>
                                    </div>
                                </div>

                                <table class="table table-design table-bordered text-nowrap border-bottom dt-responsive no-footer mt-3" cellspacing="0" width="100%" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Total Amount</th>
                                            <th>Advance</th>
                                            <th>Monthly EMI</th>
                                            <th>Months</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td><span id="amount"></span></td>
                                            <td><span id="advance"></span></td>
                                            <td><span id="emi_amount"></span></td>
                                            <td><span id="months"></span></td>
                                            <td><span id="emi_paid"></span></td>
                                        </tr>
                                    </tbody>

                                </table>



                            </div>
                        </div>`

                        @else 
                            <center>
                                <p><em>No Orders Found</em></p>
                            </center>
                            
                        @endif



                    </div>


                </div>



                


            </div>

        </div>





        @if(!empty($orders))
        <div class="card shadow mb-4">
        <!-- Default Card Example -->
            <div class="card-header">
                EMI List &nbsp;<span id="order_ref_span"></span> 
            </div>

            <div class="card-body">
                <div class="">
                    <table class="table table-design table-bordered text-nowrap border-bottom dt-responsive no-footer data-table" id="dataTable" cellspacing="0" width="100%" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Emi</th>
                                <th>Emi No</th>
                                <th>Emi Amount</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Last Modified</th>
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

    @endif



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
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice Modal Ends -->


@stop

@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

        var order_id = $('#order_id').val();
        if(order_id != null) {
            get_order_details(order_id);
        }
        

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
                        d.id = $('#order_id').val();
                        d._token = "{{ csrf_token() }}";
                    },
                url: "{{ url('order/get_emi_details') }}",
                type: "POST",
                dataType: 'json',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'emi_month', name: 'emi_month'},
                {data: 'month', name: 'month'},
                {data: 'emi_amount', name: 'emi_amount'},
                {data: 'due_date', name: 'due_date'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
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


        $('#order_id').change(function (e) {
            // e.preventDefault();
            var order_id = $('#order_id').val();
            get_order_details(order_id);
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



    function show_invoice(emi_id)
    {
        var id = emi_id;
        $.ajax({
            type : 'GET',
            url : '{{ url("generate-pdf") }}?e='+id,

            success: function(result, url) {
                var link =  '{{ url("generate-pdf") }}?e='+id;
                $("a.download_link").attr("href", link + '&export=pdf');

                
                $('.modal-title').html("EMI Invoice");
                $('.modal-body').html(result);
                $('#myModal').modal('show');

                $('.modal-container').load($(this).data('path'),function(result){
                    $('#myModal').modal({show:true});
                });
            }
        });
    }


    function show_receipt(emi_id)
    {
        var id = emi_id;
        $.ajax({
            type : 'GET',
            url : '{{ url("generate-receipt") }}?e='+id,

            success: function(result, url) {
                var link =  '{{ url("generate-receipt") }}?e='+id;
                $("a.download_link").attr("href", link + '&export=pdf');

                $('.modal-title').html("EMI Payment Receipt");
                $('.modal-body').html(result);
                $('#myModal').modal('show');

                $('.modal-container').load($(this).data('path'),function(result){
                    $('#myModal').modal({show:true});
                });
            }
        });
    }




    



    $('.modellink').click(function(e){
        e.preventDefault();

        $.ajax({
            type : 'GET',
            url : '{{ url('generate-pdf') }}',

            success: function(result, url) {

                $('.modal-body').html(result);
                $('#myModal').modal('show');

                $('.modal-container').load($(this).data('path'),function(result){
                    $('#myModal').modal({show:true});
                });
            }
        });
    });



</script>


@endsection
