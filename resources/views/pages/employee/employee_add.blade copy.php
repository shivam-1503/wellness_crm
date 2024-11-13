@extends('layouts.app')
@section('content')

@php $genders = ["Male"=>"Male", "Female"=>"Female", "Transgender"=>"Transgender"]; @endphp

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Employees <small>{{isset($employee_id) ? "Edit" : "Create"}}</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">{{isset($employee_id) ? "Edit" : "Create"}} Customer</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="{{url('employees')}}"> <i class="fa fa-arrow-left"></i> Back</a>
    </div>

</div>
<!-- PAGE-HEADER END -->



    <div class="content mt-3">

        <div class="card shadow mb-4">

            <div class="card-header">
            {{isset($employee_id) ? "Edit" : "Create New"}} Customer
            </div>

            <div class="card-body">
                {{ Form::open(['id'=>'dataForm'])}}
                {{ Form::hidden('employee_id', '', ['id'=>'employee_id']) }}

        
                <p class="lead"> Personal Details:</p>
                <div class="row">

                    <div class="col-md-4">
                        <label for="first_name" class="col-form-label">Name <k>*</k></label>
                        {{ Form::text('name','',['class'=>'form-control', 'id'=>'name']) }}

                        <span class="text-danger" id="name-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="state_id" class="col-form-label">Gender </label>
                        {{ Form::select('gender',$genders,'',['class'=>'standardSelect form-control', 'title'=>'Select Gender', 'data-live-search'=>'true', 'id'=>'gender', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="state_id-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="dob" class="col-form-label">Date of Birth</label>
                        {{ Form::date('dob','',['class'=>'form-control', 'id'=>'dob']) }}

                        <span class="text-danger" id="dob-error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="source_id_fk" class="col-form-label">Designation <k>*</k></label>
                        {{ Form::select('designation_id', $designations, '', ['class'=>'standardSelect form-control', 'title'=>'Select Designation', 'data-live-search'=>'true', 'id'=>'designation_id', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="designation_id-error"></span>
                    </div>

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


                <p class="lead mt-5">Contact Details:</p>
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


                <div class="row">
                    <div class="col-md-4">
                        <label for="status" class="col-form-label">Status <k>*</k></label>
                        {{ Form::selectRange('experience', 0, 10,'',['class'=>'standardSelect form-control', 'title'=>'Select Experience (Years)', 'data-live-search'=>'true', 'id'=>'experience', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="experience-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="dob" class="col-form-label">Joining Date</label>
                        {{ Form::date('joining_date','',['class'=>'form-control', 'id'=>'joining_date']) }}

                        <span class="text-danger" id="joining_date-error"></span>
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


        var employee_id = "{{ isset($employee_id) ? $employee_id : false }}";

        if(employee_id)
        {
            $.ajax({
                url: "{{ url('employee/details/') }}/"+employee_id,
                type: "GET",
                dataType: 'json',

                success: function (data) {
                    console.log(data);
                    $('#dataForm').trigger("reset");

                    $('#employee_id').val(data.id);
                   
                    $('#name').val(data.name);
                    $('#gender').val(data.gender);
                    $('#designation_id').val(data.designation_id);
                    $('#dob').val(data.dob);
                    $('#uidai').val(data.uidai);
                    $('#pan').val(data.pan);
                    $('#state_id').val(data.state_id);
                    $('#city').val(data.city);
                    $('#address').val(data.address);
                    $('#pincode').val(data.pincode);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#experience').val(data.experience);
                    $('#joining_date').val(data.joining_date);
                    $('#status').val(data.status);

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
                name: 'required',
                designation_id: 'required',
                state_id: 'required',
                city: 'required',
                status: 'required',
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                    number: true,
                },
            },

            messages: {
                name: "Please Enter First Name.",
                designation_id: "Please Select Designation",
                status: "Please Select Status.",
                state_id: "Please Select State You Belong.",
                city: "Please Enter Your City.",
                email: {
                    required: "Please Enter Email Id",
                    email: "Please Enter Valid Email Id",
                },
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
                    url: "{{ url('employee/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        swal({
                            title: "Good job!",
                            text: data.msg,
                            icon: "success",
                        })
                        .then((willDelete) => {
                            window.location.replace("{{url('employees')}}");
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
