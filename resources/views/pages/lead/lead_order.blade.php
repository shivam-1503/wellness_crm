@extends('layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Lead <small>{{isset($lead_id) ? "Edit" : "Create"}}</small></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class="active">Dashboard</li>
                    <li class="active">Lead</li>
                    <li class="active">{{isset($lead_id) ? "Edit" : "Create"}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">

    <div class="card shadow mb-4">
        <div class="card-header">
            Lead Details
            <a class="btn btn-primary btn-sm float-right" href="{{url('lead/create')}}"> <i class="fa fa-arrow-left"></i> Add New Lead</a>
        </div>

        <div class="card-body">

            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link" href="{{ url('/lead/details/'.$lead_id) }}" role="tab">General</a>

                    <a class="nav-item nav-link active" href="{{ url('/lead/products/'.$lead_id) }}" role="tab">Products</a>

                    <a class="nav-item nav-link" href="{{ url('/lead/quote/'.$lead_id) }}" role="tab">Quotes</a>

                    <a class="nav-item nav-link" href="{{ url('/lead/products') }}" role="tab">Invoices</a>
                </div>
            </nav>

            <div class="row">

            	<div class="col-md-12">
                    <!-- Default box -->
                    {{ Form::open(['id'=>'dataForm'])}}
                    {{ Form::hidden('customer_id', '', ['id'=>'customer_id']) }}
                    {{ Form::hidden('lead_id', $lead_id) }}

                    <div class="card">

                        <div class="card-header">
                            Customer Information
                        </div>

                        <div class="card-body">

                        	<div class="row">



            	            	<div class="col-md-6 col-lg-3">
            	            		<label>Name <k>*</k></label>
            	            		{{ Form::text('name', $lead->first_name.' '.$lead->last_name, ['class'=>'form-control', 'id'=>'name', 'readonly' => TRUE]) }}
            	            		<span class="text-danger" id="name-error"></span>
            	            	</div>

                                <div class="col-md-6 col-lg-3">
            	            		<label>Phone <k>*</k></label>
            	            		{{ Form::text('phone', $lead->phone, ['class'=>'form-control', 'id'=>'company', 'readonly' => TRUE]) }}
            	            		<span class="text-danger" id="phone-error"></span>
            	            	</div>

            	            	<div class="col-md-6 col-lg-3">
            	            		<label>Company </label>
            	            		{{ Form::text('company', $lead->company, ['class'=>'form-control', 'id'=>'company']) }}
            	            		<span class="text-danger" id="company-error"></span>
            	            	</div>

                                <div class="col-md-6 col-lg-3">
                                    <label>email </label>
                                    {{ Form::text('email', $lead->email, ['class'=>'form-control', 'id'=>'email']) }}
                                    <span class="text-danger" id="name-error"></span>
                                </div>

            	            </div>



                        </div>
                    </div>


                    <div class="card">

                        <div class="card-header">
                            Product Information
                        </div>

                        <div class="card-body">

            	            <div class="pull-left" style="padding-bottom: 10px; width: 300px;">
            	                {{ Form::select('products', $products,'', ['class'=>'standardSelect form-control', 'title'=>'Select Product', 'data-live-search'=>'true', 'id'=>'products' , 'data-style'=>'btn-sp', 'data-size'=>'5']) }}
            	            </div>

            	            <div id="cart-wrapper">
            		            <table id="cart" class="table table-hover table-sm" id="example">
            		                <thead>
            		                    <tr>
            		                        <th style="width:20%">Product</th>
            		                        <th style="width:10%">Quantity</th>
            		                        <th style="width:15%">Unit Price</th>
            		                        <th style="width:10%">Tax</th>
            		                        <th style="width:10%">Tax Amt.</th>
            		                        <th style="width:15%" class="text-center">Subtotal</th>
            		                        <th style="width:10%">Action</th>
            		                    </tr>
            		                </thead>

            		                <tbody>
            		                @php
            		                    $total = 0; $cart = array();

            		                    if(session('data'))
            		                    {
            		                        $data = session('data');
            		                        $cart = $data['cart'];
            		                    }
            		                @endphp

            		                @foreach($cart as $id => $details)

            		                    <?php $total += $details['total_sales_price']  ?>

            		                    <tr>
            		                        <td data-th="Product">{{ $details['name'] }}</td>
            		                        <td data-th="Quantity">
            		                            <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" data-id="{{ $id }}" onchange="update(this)" />
            		                        </td>
            		                        <td data-th="Price">INR {{ $details['unit_price'] }}</td>
            		                        <td data-th="tax">{{ $details['tax'] }}%</td>
            		                        <td data-th="tax_amount">INR {{ $details['tax_amount'] }}</td>
            		                        <td data-th="Subtotal" class="text-center">INR {{ $details['total_sales_price'] }}</td>

            		                        <td class="actions" data-th="">
            		                            <!-- <button class="btn btn-info btn-sm update-cart" onclick="update(this)" data-id="{{ $id }}"><i class="fa fa-refresh"></i> Update </button> -->
            		                            <button type="button" class="btn btn-danger btn-sm remove-from-cart" onclick="remove(this)" data-id="{{ $id }}"><i class="fa fa-trash-o"></i> Delete </button>
            		                        </td>
            		                    </tr>
            		                @endforeach

            		                </tbody>

            		                <tfoot>
            			                <tr class="visible-xs">
            			                    <td colspan="5"></td>
            			                    <td class="text-center"><strong>Total {{ $total }}</strong></td>
            			                    <td></td>
            			                </tr>
            		                </tfoot>
            		            </table>
            	        	</div>

            			</div>
            		</div>

                    <button type="button" class="btn btn-primary btn-sm" id="save_cart"><i class="fa fa-cart-o"></i> Submit </button>

                    {{ Form::close() }}


            	</div>
            </div>
        </div>
    </div>
</div>




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


        $('#products').change(function() {
            var product_id = $(this).val();
            $.ajax({
                type:"GET",
                url:"{{url('product/add_to_cart')}}/"+product_id,
                success: function (response) {
                    refresh_cart();
                }
            })
        });
    });



    function update(ele)
    {
        $.ajax({
           url: '{{ url("product/update-cart") }}',
           method: "post",
           data: {_token: '{{ csrf_token() }}', id: $(ele).attr("data-id"), quantity: $(ele).parents("tr").find(".quantity").val()},
           success: function (response) {
           		refresh_cart();
           }
        });
    }


    function remove(ele)
    {
        if(confirm("Are you sure")) {
            $.ajax({
                url: '{{ url("product/remove-from-cart") }}',
                method: "get",
                data: {_token: '{{ csrf_token() }}', id: $(ele).attr("data-id")},
                success: function (response) {
                    refresh_cart();
                }
            });
        }
    }


    function refresh_cart()
    {
        lead_id = "{{$lead_id}}"; console.log(lead_id);
    	var url = '{{url("lead_order_ajax/")}}'+'/'+lead_id; console.log(url); //please insert the url of the your current page here, we are assuming the url is 'index.php'
        $('#cart-wrapper').load(url + ' #cart'); //note: the space before #div1 is very important
    }


    $('#save_cart').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
            data: $('#dataForm').serialize(),
            url: "{{ url('save_order') }}",
            type: "POST",
            dataType: 'json',

            success: function (data) {
                swal({
                    title: "Good job!",
                    text: data.msg,
                    icon: "success",
                });
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
    });

</script>
@stop
