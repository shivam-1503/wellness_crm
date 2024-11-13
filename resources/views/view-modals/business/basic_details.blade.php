<div class="modal fade" id="basicDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-signup card-plain">


                {{ Form::open(['id' => 'basicForm', 'name' => 'dataForm', 'class' => 'form-horizontal']) }}
                {{ csrf_field() }}
                

                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-close"></i></button>
                        <h4 class="card-title" id="basicDetailModalHeading"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    <!-- <p class="lead"> Project Details:</p> -->
                    <div class="row">

                        <div class="col-md-12">
                            <label for="full_name" class="col-form-label">Company Full Name <k>*</k></label>
                            {{ Form::text('full_name', '', ['class' => 'form-control', 'id' => 'full_name']) }}
                        </div>

                    </div>

                    <!-- <p class="lead">Contact Details:</p> -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="col-form-label">Company Name <k>*</k></label>
                            {{ Form::text('name', '', ['class' => 'form-control', 'id' => 'name']) }}
                        </div>

                        <div class="col-md-6">
                            <label for="source_id_fk" class="col-form-label">Established In</label>
                            {{ Form::text('established_in', '', ['class' => 'form-control', 'id' => 'established_in']) }}
                        </div>
                    </div>

                    <!-- <p class="lead">Contact Details:</p> -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="state_id" class="col-form-label">State </label>
                            {{ Form::select('state_id', $states, '', ['class' => 'standardSelect form-control', 'title' => 'Select State', 'data-live-search' => 'true', 'id' => 'state_id', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="col-form-label">Address </label>
                            {{ Form::text('address', '', ['class' => 'form-control', 'id' => 'address']) }}
                        </div>
                    </div>


                    <!-- <p class="lead">Contact Details:</p> -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="city" class="col-form-label">City</label>
                            {{ Form::text('city', '', ['class' => 'form-control', 'id' => 'city']) }}
                        </div>

                        <div class="col-md-6">
                            <label for="pincode" class="col-form-label">Pincode </label>
                            {{ Form::text('pincode', '', ['class' => 'form-control', 'id' => 'pincode']) }}
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label for="landline" class="col-form-label">Landline <k>*</k></label>
                            {{ Form::text('landline', '', ['class' => 'form-control', 'id' => 'landline']) }}
                        </div>

                        <div class="col-md-6">
                            <label for="fb_url" class="col-form-label">FAX </label>
                            {{ Form::text('fax', '', ['class' => 'form-control', 'id' => 'fax']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="email" class="col-form-label">Email
                            </label>
                            {{ Form::text('email', '', ['class' => 'form-control', 'id' => 'email']) }}
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="col-form-label">Phone </label>
                            {{ Form::number('phone', '', ['class' => 'form-control', 'id' => 'phone']) }}
                            <span class="text-danger" id="property_sold-error"></span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'BasicDetailsSaveBtn']) !!}

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
