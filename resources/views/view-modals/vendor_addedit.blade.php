@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-signup card-plain">


                {{ Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class' => 'form-horizontal']) }}

                {{ Form::hidden('vendor_id', '', ['id' => 'vendor_id']) }}
                {{ csrf_field() }}
                

                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <h4 class="card-title" id="ajaxModalHeading"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    <!-- <p class="lead"> Project Details:</p> -->
                    <div class="row">

                        <div class="col-md-12">
                            <label for="full_name" class="col-form-label">Business Name <k>*</k></label>
                            {{ Form::text('business_name', '', ['class' => 'form-control', 'id' => 'business_name']) }}
                            <span class="text-danger" id="business_name-error"></span>
                        </div>

                    </div>

                    <!-- <p class="lead">Contact Details:</p> -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="col-form-label">Contact Person Name <k>*</k></label>
                            {{ Form::text('name', '', ['class' => 'form-control', 'id' => 'name']) }}
                            <span class="text-danger" id="name-error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="source_id_fk" class="col-form-label">Contact Person Position</label>
                            {{ Form::text('position', '', ['class' => 'form-control', 'id' => 'position']) }}
                            <span class="text-danger" id="position-error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="email" class="col-form-label">Email
                            </label>
                            {{ Form::text('email', '', ['class' => 'form-control', 'id' => 'email']) }}
                            <span class="text-danger" id="email-error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="col-form-label">Phone </label>
                            {{ Form::number('phone', '', ['class' => 'form-control', 'id' => 'phone']) }}
                            <span class="text-danger" id="phone-error"></span>
                        </div>
                    </div>

                    <!-- <p class="lead">Contact Details:</p> -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="state_id" class="col-form-label">State </label>
                            {{ Form::select('state_id', $states, '', ['class' => 'standardSelect form-control', 'title' => 'Select State', 'data-live-search' => 'true', 'id' => 'state_id', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                            <span class="text-danger" id="state_id-error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="col-form-label">Address </label>
                            {{ Form::text('address', '', ['class' => 'form-control', 'id' => 'address']) }}
                            <span class="text-danger" id="address-error"></span>
                        </div>
                    </div>


                    <!-- <p class="lead">Contact Details:</p> -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="city" class="col-form-label">City</label>
                            {{ Form::text('city', '', ['class' => 'form-control', 'id' => 'city']) }}
                            <span class="text-danger" id="city-error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="pincode" class="col-form-label">Pincode </label>
                            {{ Form::text('pincode', '', ['class' => 'form-control', 'id' => 'pincode']) }}
                            <span class="text-danger" id="pincode-error"></span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <label for="landline" class="col-form-label">PAN Number <k>*</k></label>
                            {{ Form::text('pan', '', ['class' => 'form-control', 'id' => 'pan']) }}
                            <span class="text-danger" id="pan-error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="website" class="col-form-label">Website </label>
                            {{ Form::text('website', '', ['class' => 'form-control', 'id' => 'website']) }}
                            <span class="text-danger" id="website-error"></span>
                        </div>

                        <div class="col-sm-4">
                            <label for="website" class="col-form-label">Status </label>
                            {!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                    

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'saveBtn']) !!}

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
