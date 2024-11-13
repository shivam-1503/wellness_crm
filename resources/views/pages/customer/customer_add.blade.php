@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Customers <small>{{isset($customer_id) ? "Edit" : "Create"}}</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">{{isset($customer_id) ? "Edit" : "Create"}} Customer</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="{{url('customers')}}"> <i class="fa fa-arrow-left"></i> Back</a>
    </div>

</div>
<!-- PAGE-HEADER END -->



    <div class="content mt-3">

        <div class="card shadow mb-4">

            <div class="card-header">
            {{isset($customer_id) ? "Edit" : "Create New"}} Customer
            </div>

            <div class="card-body">
                {{ Form::open(['id'=>'dataForm'])}}
                {{ Form::hidden('customer_id', '', ['id'=>'customer_id']) }}

                
                <p class="lead"> Account Details:</p>
                <div class="row">

                    <div class="col-md-6">
                        <label for="source_id_fk" class="col-form-label">Account Manager <k>*</k></label>
                        {{ Form::select('account_manager_id', $account_managers, '', ['class'=>'standardSelect form-control', 'title'=>'Select Account Manager', 'data-live-search'=>'true', 'id'=>'account_manager_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="account_manager_id-error"></span>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="source_id_fk" class="col-form-label">Source <k>*</k></label>
                        {{ Form::select('source_id', $sources, '', ['class'=>'standardSelect form-control', 'title'=>'Select Source', 'data-live-search'=>'true', 'id'=>'source_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="source_id-error"></span>
                    </div>

                </div>


                <p class="lead"> Personal Details:</p>
                <div class="row">

                    <div class="col-md-4">
                        <label for="first_name" class="col-form-label">First Name <k>*</k></label>
                        {{ Form::text('first_name','',['class'=>'form-control', 'id'=>'first_name']) }}

                        <span class="text-danger" id="first_name-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="last_name" class="col-form-label">Last Name</label>
                        {{ Form::text('last_name','',['class'=>'form-control', 'id'=>'last_name']) }}

                        <span class="text-danger" id="last_name-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="dob" class="col-form-label">Date of Birth</label>
                        {{ Form::date('dob','',['class'=>'form-control', 'id'=>'dob']) }}

                        <span class="text-danger" id="dob-error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                    <label for="last_name" class="col-form-label">UIDAI <em>(AADHAR)</em></label>
                        {{ Form::text('uidai','',['class'=>'form-control', 'id'=>'uidai']) }}
                        <span class="text-danger" id="uidai-error"></span>
                    </div>
                    
                    <div class="col-md-4">
                    <label for="last_name" class="col-form-label">PAN Number</label>
                        {{ Form::text('pan','',['class'=>'form-control', 'id'=>'pan']) }}
                        <span class="text-danger" id="pan-error"></span>
                    </div>
                </div>


                <p class="lead">Contact Details:</p>
                <div class="row">
                    <div class="col-md-4">
                        <label for="state_id" class="col-form-label">State </label>
                        {{ Form::select('state_id',$states,'',['class'=>'standardSelect form-control', 'title'=>'Select State', 'data-live-search'=>'true', 'id'=>'state_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="state_id-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="city" class="col-form-label">City</label>
                        {{ Form::text('city','',['class'=>'form-control', 'id'=>'city']) }}

                        <span class="text-danger" id="city-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="address" class="col-form-label">Address </label>
                        {{ Form::text('address','',['class'=>'form-control', 'id'=>'address']) }}

                        <span class="text-danger" id="address-error"></span>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="pincode" class="col-form-label">Pincode </label>
                        {{ Form::text('pincode','',['class'=>'form-control', 'id'=>'pincode']) }}

                        <span class="text-danger" id="pincode-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="phone" class="col-form-label">Phone <k>*</k></label>
                        {{ Form::text('phone','',['class'=>'form-control', 'id'=>'phone']) }}

                        <span class="text-danger" id="phone-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="email" class="col-form-label">Email</label>
                        {{ Form::text('email','',['class'=>'form-control', 'id'=>'email']) }}

                        <span class="text-danger" id="email-error"></span>
                    </div>
                </div>





                <p class="lead"> Company Details:</p>
                <div class="row">
                    <div class="col-md-4">
                        <label for="company" class="col-form-label">Company </label>
                        {{ Form::text('company','',['class'=>'form-control', 'id'=>'company']) }}

                        <span class="text-danger" id="company-error"></span>
                    </div>


                    <div class="col-md-4">
                        <label for="position" class="col-form-label">Position </label>
                        {{ Form::text('position','',['class'=>'form-control', 'id'=>'position']) }}

                        <span class="text-danger" id="position-error"></span>
                    </div>


                    <div class="col-md-4">
                        <label for="website" class="col-form-label">Website </label>
                        {{ Form::text('website','',['class'=>'form-control', 'id'=>'website']) }}

                        <span class="text-danger" id="website-error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <label for="status" class="col-form-label">Remarks</label>
                        {{ Form::textarea('remarks','',['class'=>'form-control','rows'=>2, 'id'=>'remarks']) }}

                        <span class="text-danger" id="remarks-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="col-form-label">Status <k>*</k></label>
                        {{ Form::select('status',array('1'=>'Active','0'=>'Inactive'),'',['class'=>'form-control', 'id'=>'status']) }}

                        <span class="text-danger" id="status-error"></span>
                    </div>
                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-12" align="right">
                       {{ Form::submit('Submit', array('class'=>'btn btn-primary', 'id'=>'saveBtn')) }}
                    </div>
                </div>
            </form>
        </div>

    </div>


</div>

@stop

@section('scripting')

<script type="text/javascript">

    $(document).ready(function( $ ) { 

        $(".standardSelect").selectpicker();

        $('.standardSelect').on('change', function () {
            $(this).removeClass('open');
        });

        jQuery.validator.setDefaults({
          debug: true
        });


        var customer_id = "{{ isset($customer_id) ? $customer_id : false }}";

        if(customer_id)
        {
            $.ajax({
                url: "{{ url('customer/details/') }}/"+customer_id,
                type: "GET",
                dataType: 'json',

                success: function (data) {
                    console.log(data);
                    $('#dataForm').trigger("reset");

                    $('#customer_id').val(data.id);
                   
                    $('#first_name').val(data.first_name);
                    $('#account_manager_id').val(data.account_manager_id);
                    $('#source_id').val(data.source_id);
                    $('#last_name').val(data.last_name);
                    $('#dob').val(data.dob);
                    $('#uidai').val(data.uidai);
                    $('#pan').val(data.pan);
                    $('#state_id').val(data.state_id);
                    $('#city').val(data.city);
                    $('#address').val(data.address);
                    $('#pincode').val(data.pincode);
                    $('#company').val(data.company);
                    $('#position').val(data.position);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#website').val(data.website);
                    $('#status').val(data.status);
                    $('#remarks').val(data.remarks);

                    $('.standardSelect').selectpicker('refresh');
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
                first_name: 'required',
                status: 'required',
                phone: {
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
                            window.location.replace("{{url('order/create')}}/"+data.customer_id);
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

</script>

@endsection
