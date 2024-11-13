@extends('layouts.app')
@section('content')

@php $categories = ['Associate'=>'Associate', 'End User'=>'End User', 'End User + Associate'=>'End User + Associate',  'Trading'=>'Trading'];  @endphp
@php $source_types = ['Inbound'=>'Inbound', 'Outbound'=>'Outbound'];  @endphp


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Lead <small>{{isset($lead_id) ? "Edit" : "Create"}}</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Lead</li>
            <li class="breadcrumb-item active">{{isset($lead_id) ? "Edit" : "Create"}} Lead</li>
        </ol>
    </div>

    <div class="float-end">
    <a class="btn btn-primary btn-sm float-right" href="{{url('leads')}}"> <i class="fa fa-arrow-left"></i> Back</a>
    </div>

</div>
<!-- PAGE-HEADER END -->


    <div class="content mt-3">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                {{isset($lead_id) ? "Edit Lead Details" : "Add New Lead"}}
            </div>

            <div class="card-body">
                {{ Form::open(['id'=>'dataForm'])}}
                {{ Form::hidden('lead_id', '', ['id'=>'lead_id']) }}

                <p class="lead">Basic Details</p>
                <div class="row mb-3">
                    <div class="col-md-3 form-group">
                        <label for="title" class="col-form-label">Title <k>*</k></label>
                        {{ Form::text('title', "Lead #", ['class'=>'form-control', 'id'=>"title"]) }}

                        <span class="text-danger" id="title-error"></span>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="stage_id_fk" class="col-form-label">Stage <k>*</k></label>
                        {{ Form::select('stage_id_fk', $stages, '', ['class'=>'standardSelect form-control', 'title'=>'Select Stage', 'data-live-search'=>'true', 'id'=>'stage_id_fk' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="stage_id_fk-error"></span>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="source_id_fk" class="col-form-label">Source <k>*</k></label>
                        {{ Form::select('source_id_fk', $sources,  '', ['class'=>'standardSelect form-control', 'title'=>'Select Source', 'data-live-search'=>'true', 'id'=>'source_id_fk', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                        <span class="text-danger" id="source_id_fk-error"></span>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Source Type</label>
                        {{ Form::select('source_type', [''=>'Select Source Type']+$source_types, '', ['class'=>'standardSelect form-control', 'title'=>'Select Source Type', 'id'=>'source_type', 'required']) }}
                        <span class="text-danger" id="category-error"></span>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Lead Category</label>
                        {{ Form::select('category', [''=>'Select category']+$categories, '', ['class'=>'standardSelect form-control', 'title'=>'Select category', 'id'=>'category', 'required']) }}
                        <span class="text-danger" id="category-error"></span>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="source_id_fk">Estimate Amount</label>
                        {{ Form::text('est_amount',  '',['class'=>'form-control', 'id'=>'est_amount']) }}

                        <span class="text-danger" id="est_amount-error"></span>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Service</label>
                        {{ Form::select('service_id', [''=>'Select Service']+$services, '', ['class'=>'standardSelect form-control', 'title'=>'Select Service', 'id'=>'service_id', 'required']) }}
                        <span class="text-danger" id="category-error"></span>
                    </div>
                </div>


                <hr class="mt-3">
                <p class="lead mb-0">Customer Details</p>
                <div class="row">

                    <div class="col-md-4">
                        <label for="first_name" class="col-form-label">First Name <k>*</k></label>
                        {{ Form::text('first_name', '',['class'=>'form-control', 'id'=>'first_name']) }}

                        <span class="text-danger" id="first_name-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="last_name" class="col-form-label">Last Name</label>
                        {{ Form::text('last_name', '',['class'=>'form-control', 'id'=>'last_name']) }}

                        <span class="text-danger" id="last_name-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="company" class="col-form-label">Company</label>
                        {{ Form::text('company', '',['class'=>'form-control', 'id'=>'company']) }}

                        <span class="text-danger" id="company-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="phone" class="col-form-label">Phone <k>*</k></label>
                        {{ Form::text('phone', '',['class'=>'form-control', 'id'=>'phone']) }}

                        <span class="text-danger" id="phone-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="email" class="col-form-label">Email</label>
                        {{ Form::text('email', '',['class'=>'form-control', 'id'=>'email']) }}

                        <span class="text-danger" id="email-error"></span>
                    </div>

                    <div class="col-md-4 mb-0 form-group">
                        <label>State</label>
                        {{ Form::select('state_id', [''=>'Select State']+$states, '', ['class'=>'standardSelect form-control', 'title'=>'Select category', 'id'=>'state_id', 'required']) }}
                        <span class="text-danger" id="category-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="address" class="col-form-label">City</label>
                        {{ Form::text('city', '',['class'=>'form-control', 'id'=>'city']) }}
                        <span class="text-danger" id="address-error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="address" class="col-form-label">Address</label>
                        {{ Form::text('address', '',['class'=>'form-control', 'id'=>'address']) }}
                        <span class="text-danger" id="address-error"></span>
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="description" class="col-form-label">Description </label>
                        {{ Form::textarea('description', '',['class'=>'form-control', 'id'=>'description', 'rows'=>2]) }}

                        <span class="text-danger" id="company-error"></span>
                    </div>


                    <div class="col-md-6">
                        <label for="remarks" class="col-form-label">Remarks </label>
                        {{ Form::textarea('remarks', '',['class'=>'form-control', 'id'=>'remarks', 'rows'=>2]) }}

                        <span class="text-danger" id="position-error"></span>
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

   $(document).ready(function() {

        $(".standardSelect").selectpicker();

        $('.standardSelect').on('change', function () {
            // $(this).selectpicker('refresh');
            $(this).removeClass('open');
        });

        // $('#dataForm').data("validator").settings.ignore = "";

        jQuery.validator.setDefaults({
          debug: true
        });

        var lead_id = "{{ isset($lead_id) ? $lead_id : false }}";

        if(lead_id)
        {
            $.ajax({
                url: "{{ url('lead/getLeadData/') }}/"+lead_id,
                type: "GET",
                dataType: 'json',

                success: function (data) {
                    console.log(data);
                    $('#dataForm').trigger("reset");

                    $('#lead_id').val(data.id);
                    $('#title').val(data.title);
                    $('#source_id_fk').val(data.source_id_fk);
                    $('#source_type').val(data.source_type);
                    $('#stage_id_fk').val(data.stage_id_fk);
                    $('#est_amount').val(data.est_amount);
                    $('#service_id').val(data.service_id);
                    
                    $('#category').val(data.category);
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#company').val(data.company);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#state_id').val(data.state_id);
                    $('#city').val(data.city);
                    $('#address').val(data.address);
                    $('#description').val(data.description);
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
            },


            rules: {
                stage_id_fk: 'required',
                first_name: 'required',
                phone: 'required',
            },

            messages: {
                stage_id_fk: "Please Select Stage.",
                first_name: "Please Enter Clien Name.",
                phone: "Please Enter Phone.",
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
                    url: "{{ url('lead/store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        swal({
                            title: "Good job!",
                            text: data.msg,
                            icon: "success",
                        })
                        .then((willDelete) => {
                            window.location.replace("{{url('leads')}}");
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
