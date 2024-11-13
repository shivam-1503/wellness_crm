@extends('layouts.app')
@section('content')

                        
<style>
.text_profile {
  font-size: .9rem;
  margin-bottom: 1rem;
}
</style>

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Payments <small>Receive</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="{{url('payments')}}" id="createNewProduct"> <i class="fa fa-arrow-left"></i> Payments List</a>    
    </div>

</div>
<!-- PAGE-HEADER END -->

	@php
        $payment_modes = ['cash' => 'Cash', 'cheque' => 'Cheque', 'netbanking' => 'Net Banking', 'upi' => 'UPI']

    @endphp

<div class="content mt-3">

        <div class="card shadow mb-4">

            <div class="card-header">
                Customer Information
            </div>

            {{ Form::open(array('id'=>'dataForm'))}}
            {{ Form::hidden('emi_id', '', ['id' => 'emi_id']) }}
            {{ Form::hidden('emi_amount', '', ['id' => 'emi_amount']) }}
            {{ Form::hidden('previous_balance', '', ['id' => 'previous_balance']) }}

            <div class="card-body">

                <div class="row">
                    <div class="col-md-4">
                    


                        <div class="card">
                            <!-- <div class="card-header">
                                Customer EMI Details
                            </div> -->
                            
                            <div class="card-body">
                                <img class="mx-auto mb-4 d-block rounded-circle" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="https://www.w3schools.com/bootstrap4/paris.jpg" width="200"/>

                                <h4 class="m-5 "><center><span id="customer_name"></span></center></h4>
                                <div class="text_profile">
                                    <i class="fa fa-phone"></i> <span class="float-end" id="customer_phone"></span>
                                </div>
                                <div class="text_profile">
                                    <i class="fa fa-envelope"></i> <span class="float-end" id="customer_email"></span>
                                </div>
                                <div class="text_profile">
                                    <i class="fa fa-home"></i> <span class="float-end" id="customer_address"></span>
                                </div>

                                
                                
                                
                            
                            </div>
                        </div>


                    </div>
                    
                    <div class="col-md-8">

                        <div class="form-group">                    
                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::select('customer_id', $customers,'', ['class'=>'standardSelect form-control', 'title'=>'Select Customer', 'data-live-search'=>'true', 'id'=>'customer_id', 'data-size'=>'5']) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">                    
                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::select('order_id', [], '', ['class'=>'standardSelect form-control mt-3', 'title'=>'Select Order', 'id'=>'order_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                                    <span class="text-danger" id="source_id-error"></span>
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-md-12">
                                
                                <center>
                                <h4 class="mb-1"><span id="project"></span></h4>
                                <p class="lead" id="project_address"></p>
                                </center>
                                
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h4 class="card-title">Property Details: </h4>
                                    </div>
                                    <div class="ml-auto p-2">
                                        <span class="badge bg-primary text-end" id="property_type"></span>
                                    </div>
                                </div>
                                <h6 class="card-subtitle mb-3 text-muted" id="property"></h6>

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Due Date</th>
                                            <th>EMI</th>
                                            <th>Amount</th>
                                            <th>Previous Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="invoice"></td>
                                            <td id="due_date"></td>
                                            <td id="emi"></td>
                                            <td id="amount"></td>
                                            <td id="previous_balance_amount"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="source_id_fk" class="col-form-label">Total Amount <k>*</k></label>
                                    {{ Form::number('total_amount', '', ['class'=>'form-control', 'id'=>'total_amount']) }}
                                    <span class="text-danger" id="total_amount-error"></span>
                                </div>

                                <div class="col-md-4">
                                    <label for="source_id_fk" class="col-form-label">Extra Charges (if any) </label>
                                    {{ Form::number('extra_charges', '', ['class'=>'form-control', 'id'=>'extra_charges']) }}
                                    <span class="text-danger" id="extra_charges-error"></span>
                                </div>

                                <div class="col-md-4">
                                    <label for="source_id_fk" class="col-form-label">Net Payable<k>*</k></label>
                                    {{ Form::text('net_payable', '', ['class'=>'form-control', 'id'=>'net_payable', 'readonly']) }}
                                    <span class="text-danger" id="net_payable-error"></span>
                                </div>

                                <div class="col-md-4">
                                    <label for="source_id_fk" class="col-form-label">Amount Paid <k>*</k></label>
                                    {{ Form::number('amount_paid', '', ['class'=>'form-control', 'id'=>'amount_paid']) }}
                                    <span class="text-danger" id="advance_payment-error"></span>
                                </div>

                                <div class="col-md-4">
                                    <label for="source_id_fk" class="col-form-label">Mode of Payment <k>*</k></label>
                                    {{ Form::select('payment_mode', $payment_modes,'', ['class'=>'standardSelect form-control', 'title'=>'Select Mode', 'id'=>'payment_mode']) }}
                                    <span class="text-danger" id="payment_mode-error"></span>
                                </div>

                                <div class="col-md-4">
                                    <label for="source_id_fk" class="col-form-label">Payment Reference No. </label>
                                    {{ Form::text('payment_ref_no', '', ['class'=>'form-control', 'id'=>'payment_ref_no']) }}
                                    <span class="text-danger" id="payment_ref_no-error"></span>
                                </div>

                                <div class="col-md-4">
                                    <label for="source_id_fk" class="col-form-label">Date of Payment </label>
                                    {{ Form::date('payment_date', '', ['class'=>'form-control', 'id'=>'payment_date']) }}
                                    <span class="text-danger" id="payment_date-error"></span>
                                </div>

                                <div class="col-md-8">
                                    <label for="source_id_fk" class="col-form-label">Remarks </label>
                                    {{ Form::text('remarks', '', ['class'=>'form-control', 'id'=>'remarks']) }}
                                    <span class="text-danger" id="remarks-error"></span>
                                </div>


                            </div>
                        </div>

                        <div>
                            {{ Form::submit('Make Payment',array('class'=>'btn btn-primary float-end', 'id'=>'saveBtn')) }}
                        </div>

                    </div>
                </div>

                
                {{ Form::close()}}
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

        var cid = '{{ $cid }}';
        
        if(cid != false) {
            $('#customer_id').val(cid);
            $('.standardSelect').selectpicker('refresh');
            getUserOrdersData();
        }

        jQuery.validator.setDefaults({
          debug: true
        });

    });

    $('#customer_id').change(function() {
        
        getUserOrdersData();
        
    });


    $('#order_id').change(function(){
        publish_order_data();
    })


    function getUserOrdersData() {
        var customer_id = $('#customer_id').val();
        $.ajax({
            type:"GET",
            url:"{{url('getCustomerOrdersData')}}/"+customer_id,
            success: function (response) {
                if(response.success) {
                    
                    $("#order_id").empty()
                    
                    $.each(response.data, function(key, value) {
                        $("#order_id").append('<option value = "' + key + '">' + value + '</option>');
                    })
                    
                    $('.standardSelect').selectpicker('refresh');
                }
                else {

                    swal({
                        title: "Sorry!",
                        text: response.msg,
                        icon: "error",
                    });
                }
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
                }ß
                // $('#saveBtn').html('Save Changes');
            }
        })
    }


    function publish_order_data() {
        var order_id = $('#order_id').val();
        $.ajax({
            type:"GET",
            url:"{{url('getOrderEmiDetails')}}/"+order_id,
            success: function (response) {
                if(response.success) {
                    var customer = response.data.customer;
                    var order = response.data.order;
                    var emi = response.data.emi;

                    $('#customer_name').html(customer.first_name +' '+customer.last_name);
                    $('#customer_phone').html(customer.phone);
                    $('#customer_email').html(customer.email);
                    $('#customer_address').html(customer.address + ', ' + customer.city);
                    
                    $('#project').html(order.project.title);
                    $('#project_address').html(order.project.address + ', ' + order.project.city + ', ' + order.project.pincode);
                    $('#property').html(order.property.title +' ('+ order.property.size +')');
                    $('#property_type').html(order.property_type.name);
                    
                    $('#invoice').html(emi.invoice_code);
                    $('#due_date').html(emi.due_date);
                    $('#emi').html(emi.month +' / '+order.months);
                    $('#amount').html('Rs. '+ emi.emi_amount);
                    $('#previous_balance_amount').html('Rs. '+ order.current_balance);

                    
                    var emi_amount = parseFloat(emi.emi_amount);
                    var previous_balance = parseFloat(order.current_balance);
                    var total_amount = emi_amount + previous_balance;
                    
                    $('#emi_amount').val(emi_amount);
                    $('#previous_balance').val(previous_balance);
                    $('#emi_id').val(emi.id);
                    
                    $('#total_amount').val(total_amount);
                    $('#net_payable').val(total_amount);
                    $('#amount_paid').val(total_amount);
                }
                else {
                    swal({
                        title: "Sorry!",
                        text: response.msg,
                        icon: "error",
                    })
                    .then((willDelete) => {
                        window.location.replace("{{url('receive_payments')}}");
                    });
                }
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
                }ß
                // $('#saveBtn').html('Save Changes');
            }
        })
    }


    $('#extra_charges').keyup(function() {
       
        var total_amount = parseFloat($('#total_amount').val());
        var extra_charges = parseFloat($('#extra_charges').val());
        
        if(isNaN(extra_charges)) {
            extra_charges = 0;
        }
        var net_payable = total_amount + extra_charges;

        $('#net_payable').val(net_payable);
        $('#amount_paid').val(net_payable);
    })



    $('#saveBtn').click(function(e) {

        e.preventDefault();

        const amount = $('#amount_paid').val();


        let rupee = new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
        });

        swal({
            title: "Are you, You Received "+ rupee.format(amount) +"?",
            text: "Once confirmed, Payment will move for approval!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $('#dataForm').submit();
            } else {
                swal("Please Correct the Payment Details!");
            }
        });


    })




    $("#dataForm").validate({

        errorClass: "is-invalid",

        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass);
            $(element).parent().removeClass(errorClass);
        },

        errorPlacement: function(error, element) {
            element.parent().append( error );
            $('.standardSelect').selectpicker('refresh');
        },


        rules: {
            emi_id: 'emi_id',
            customer_id: 'required',
            order_id: 'required',
            emi_amount: {
                required: true,
                number: true,
            },
            total_amount: {
                required: true,
                number: true,
            },
            net_payable: {
                required: true,
                number: true,
            },
            amount_paid: {
                required: true,
                number: true,
            },
            payment_mode: 'required',
            payment_date: 'required',
            
        },

        messages: {
            cost: {
                required: "Please Enter Cost",
                number: "Cost must be a number.",
            },
            advance_payment: {
                required: "Please Enter Advance Payment",
                number: "Cost must be a number.",
            },
            emi_id: 'Invalid Data. Please refresh and try again.',
            customer_id: 'Invalid Data. Please refresh and try again.',
            emi_amount: {
                required: "Invalid EMI. Please refresh and try again.",
            },
            total_amount: {
                required: "Please enter Total Amount",
                number: "Total Amount must be a number",
            },
            net_payable: {
                required: "Please enter Total Amount",
                number: "Total Amount must be a number",
            },
            amount_paid: {
                required: "Please enter Total Amount",
                number: "Total Amount must be a number",
            },
            payment_mode: 'Please select payment mode',
            payment_date: 'Please enter payment date',
        },

        submitHandler: function (form) {
            // form.submit();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveBtn').prop('disabled', true);

            $.ajax({
                data: $('#dataForm').serialize(),
                url: "{{ url('payment/store') }}",
                type: "POST",
                dataType: 'json',

                success: function (response) {
                    
                    if(response.success) {
                        swal({
                            title: "Good job!",
                            text: response.msg,
                            icon: "success",
                        })
                        .then((willDelete) => {
                            window.location.replace("{{url('receive_payments')}}");
                        });
                    }
                    else {
                        swal({
                            title: "Sorry!",
                            text: response.msg,
                            icon: "error",
                        })
                        .then((willDelete) => {
                            window.location.replace("{{url('receive_payments')}}");
                        });
                    }

                
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
                    $('#saveBtn').prop('disabled', false);
                    
                }
            });
        }
    });




</script>
@stop