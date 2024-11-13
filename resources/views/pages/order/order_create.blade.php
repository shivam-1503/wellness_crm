@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Order <small>Create</small><h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="{{url('customers')}}" id="createNewProduct"> <i class="fa fa-arrow-left"></i> Customers List</a>    
    </div>

</div>
<!-- PAGE-HEADER END -->

@php


@endphp
	

<div class="content mt-3">

	<div class="col-md-12">
        <!-- Default box -->


        <div class="card">

            <div class="card-header">
                Customer Information
            </div>

            <div class="card-body">
            	
            	<div class="row">

	            	

	            	<div class="col-md-6 col-lg-3">
	            		<label for="source_id_fk" class="col-form-label">Name <k>*</k></label>
	            		{{ Form::text('name', $customer->first_name.' '.$customer->last_name, ['class'=>'form-control', 'id'=>'name', 'readonly']) }}
	            		<span class="text-danger" id="name-error"></span>
	            	</div>

	            	<div class="col-md-6 col-lg-3">
	            		<label for="source_id_fk" class="col-form-label">City <k>*</k></label>
	            		{{ Form::text('city', $customer->city, ['class'=>'form-control', 'id'=>'city', 'readonly']) }}
	            		<span class="text-danger" id="company-error"></span>
	            	</div>

                    <div class="col-md-6 col-lg-3">
	            		<label for="source_id_fk" class="col-form-label">Phone <k>*</k></label>
	            		{{ Form::text('phone', $customer->phone, ['class'=>'form-control', 'id'=>'phone', 'readonly']) }}
	            		<span class="text-danger" id="phone-error"></span>
	            	</div>

                    <div class="col-md-6 col-lg-3">
                        <label for="source_id_fk" class="col-form-label">email <k>*</k></label>
                        {{ Form::text('email', $customer->email, ['class'=>'form-control', 'id'=>'email', 'readonly']) }}
                        <span class="text-danger" id="name-error"></span>
                    </div>

	            </div>

	           

            </div>
        </div>


        <div class="card mt-3">

            <div class="card-header">
                Product Information
            </div>

            {{ Form::open(array('id'=>'dataForm'))}}
            {{ Form::hidden('customer_id', $customer->id) }}



            <div class="card-body">
            
                <div class="form-group">
                    
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::select('project_id', $projects,'', ['class'=>'standardSelect form-control', 'title'=>'Select Project', 'data-live-search'=>'true', 'id'=>'project_id', 'data-size'=>'5']) }}
                        </div>
                        
                        <div class="col-md-4">
                            {{ Form::select('property_type_id', $property_types,'', ['class'=>'standardSelect form-control', 'title'=>'Select Property Type', 'data-live-search'=>'true', 'id'=>'property_type_id', 'data-size'=>'5']) }}
                        </div>

                        <div class="col-md-4">
                            {{ Form::select('property_id', [],'', ['class'=>'standardSelect form-control', 'title'=>'Select Property', 'data-live-search'=>'true', 'id'=>'property_id', 'data-size'=>'5']) }}
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="source_id_fk" class="col-form-label">Total Cost <k>*</k></label>
                            {{ Form::number('cost', '', ['class'=>'form-control', 'id'=>'cost']) }}
                            <span class="text-danger" id="cost-error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="source_id_fk" class="col-form-label">Advance Payment <k>*</k></label>
                            {{ Form::number('advance_payment', '', ['class'=>'form-control', 'id'=>'advance_payment']) }}
                            <span class="text-danger" id="advance_payment-error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="source_id_fk" class="col-form-label">Balance Payment<k>*</k></label>
                            {{ Form::text('balance_payment', '', ['class'=>'form-control', 'id'=>'balance_payment', 'readonly']) }}
                            <span class="text-danger" id="balance_payment-error"></span>
                        </div>
                    </div>
                </div>
                

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="source_id_fk" class="col-form-label"> No of Months <k>*</k></label>
                            {{ Form::selectRange('months', 1, 36, '', ['class'=>'standardSelect form-control', 'title'=>'Select No of Months', 'data-live-search'=>'true', 'id'=>'months', 'data-size'=>'5']) }}
                            <span class="text-danger" id="name-error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="source_id_fk" class="col-form-label">Annual Interest Rate (%) <k>*</k></label>
                            {{ Form::text('interest_rate', '0', ['class'=>'form-control', 'id'=>'interest_rate']) }}
                            <span class="text-danger" id="name-error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="source_id_fk" class="col-form-label">Monthly EMI <k>*</k></label>
                            {{ Form::text('monthly_emi', '', ['class'=>'form-control', 'id'=>'monthly_emi', 'readonly']) }}
                            <span class="text-danger" id="monthly_emi-error"></span>
                        </div>

                        
                    </div>
                </div>

                <div id="emi_panel" class="row" style="display: none;">
                    <div class="col-md-8 offset-md-2">
                        <div class="card text-white bg-primary mb-3">                            
                            <div class="card-body">
                                <h2>Great! </h2>

                                <div class="row">
                                    <div class="col-md-8" >
                                        <h4 class="card-title">Your Monthly EMI: </h4>
                                        <blockquote class="blockquote" style="font-size: 32px;">
                                            <span id="display_emi">Rs. 16667 only</span>
                                        </blockquote>
                                    </div>

                                    <div class="col-md-4">
                                        <p class="card-text">Total Amount:
                                        <strong><span id="display_amount"></span></strong></p>
                                        <p class="card-text">Total Emi Amount:
                                        <strong><span id="display_emi_amount"></span></strong></p>
                                        <p class="card-text">Total Interest:
                                        <strong><span id="display_interest"></span></strong></p>
                                    </div>
                                </div>
                                
                                <button type="button" class="btn btn-primary" id="enablePaymentFieldsBtn">Change Payment Values</button>
                                
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-4">
                    <button id="create_emi" class="btn btn-primary">GET EMI</button>
                </div>
            


			</div>
		</div>

		{{ Form::submit('submit',array('class'=>'btn btn-primary')) }}
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

        jQuery.validator.setDefaults({
          debug: true
        });

    });


    $('#property_type_id').change(function() {
        var property_type_id = $(this).val();
        var project_id = $('#project_id').val();
        $.ajax({
            type:"GET",
            url:"{{url('getPropertiesByProject')}}/"+project_id+"/"+property_type_id,
            success: function (response) {
                if(response) {
                    var html = '';                    
                    $.each(response, function( key, val ) {
                        html += "<option value='"+key+"'>"+val+"</option>";
                    });

                    console.log(html);

                    $("#property_id").html(html).selectpicker('refresh');
                }
            }
        })
    });



    $('#advance_payment').keyup(function() {
        var cost = $('#cost').val();
        var advance_payment = $('#advance_payment').val();

        var balance_payment = cost - advance_payment;

        if(balance_payment >= 0) {
            $('#balance_payment').val(balance_payment);
        }
        else {
            swal({
                title: "Error!",
                text: "Advance Payment should not greater than Cost",
                icon: "error",
            })
            .then((e) => {
                $('#advance_payment').val('');
                $('#balance_payment').val('');
            });
        }
    })


    
    
    $('#create_emi').click(function(e) {
        e.preventDefault();
        
        $("#dataForm").validate();

        if($('#dataForm').valid()){

            var amount = $('#balance_payment').val();
            var rate = $('#interest_rate').val();
            var months = $('#months').val();

            $.ajax({
                type:"post",
                url:"{{url('order/get_emi')}}",
                dataType: 'json',
                data: {"_token": "{{ csrf_token() }}", "amount": amount, "rate": rate, "months": months},
                success: function (res) {
                    if(res){
                        $('#emi_panel').show();

                        var emi = "Rs. "+res.emi+" only";
                        var emi_amount = res.emi*months;
                        var interest = emi_amount - amount;
                        var display_amount = "Rs. "+amount;
                        var display_emi_amount = "Rs. "+res.emi*months;
                        var display_interest = "Rs. "+interest;

                        $('#display_emi').html(emi);
                        $('#display_amount').html(display_amount);
                        $('#display_emi_amount').html(display_emi_amount);
                        $('#display_interest').html(display_interest);
                        $('#monthly_emi').val(res.emi);


                        // Make inputs Readonly
                        readonlyPaymentFields();
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
                    // $('#saveBtn').html('Save Changes');
                }
            })
        }
        else {
            console.log("Fail");
        }

    });

    $('#enablePaymentFieldsBtn').click(function(e) {
        e.preventDefault();
        enablePaymentFields();
        $('#emi_panel').hide();
        $('#monthly_emi').val('');
    })

    
    function readonlyPaymentFields() {
        $('#cost').attr('readonly','readonly');
        $('#advance_payment').attr('readonly','readonly');
        $('#interest_rate').attr('readonly','readonly');
        $('#months').attr('readonly','readonly');

        return true;
    } 
    
    function enablePaymentFields() {
        $('#cost').removeAttr('readonly');
        $('#advance_payment').removeAttr('readonly');
        $('#interest_rate').removeAttr('readonly');
        $('#months').removeAttr('readonly');

        return true;
    }


    function populateCustomer(){
        var phone = $('#phone').val();
        $.ajax({
            type:"GET",
            url:"{{url('order/fetch_customer')}}/"+phone,
            success: function (res) {
                if(res){
                	$('#name').val(res[0].first_name+' '+res[0].last_name);
                	$('#company').val(res[0].company);
                	$('#email').val(res[0].email);
                	$('#customer_id').val(res[0].customer_id);
                	$('.standardSelect').selectpicker('refresh');
                }
            }
        })
    }



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
            status: 'required',
            cost: {
                required: true,
                number: true,
            },
            advance_payment: {
                required: true,
                number: true,
            },
            balance_payment: {
                required: true,
                number: true,
            },
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
        },

        submitHandler: function (form) {
            // form.submit();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveBtn').html('Sending..');

            $.ajax({
                data: $('#dataForm').serialize(),
                url: "{{ url('order/store') }}",
                type: "POST",
                dataType: 'json',

                success: function (data) {
                    swal({
                        title: "Good job!",
                        text: data.msg,
                        icon: "success",
                    })
                    .then((willDelete) => {
                        window.location.replace("{{url('customers')}}");
                    });
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
    });


/*
    if ($("#dataForm").length > 0) {

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
                cost: 'required',
                status: 'required',
                cost: {
                    required: true,
                    number: true,
                },
                cost: {
                    required: true,
                    number: true,
                },
                
            },

            messages: {
                first_name: "Please Enter First Name.",
                status: "Please Select Status.",
                phone: {
                    required: "Please Enter Phone No",
                    number: "Phone No. must be a number.",
                }
            },



            submitHandler: function(form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#saveBtn').html('Sending..');

                $.ajax({
                    data: $('#dataForm').serialize(),
                    url: "{{ url('customer/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        swal({
                            title: "Good job!",
                            text: data.msg,
                            icon: "success",
                        })
                        .then((willDelete) => {
                            window.location.replace("{{url('customers')}}");
                        });
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
        })
    }
*/

</script>
@stop