<div class="modal fade" id="emailDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-signup card-plain">


                {{ Form::open(['id' => 'emailForm', 'name' => 'emailForm', 'class' => 'form-horizontal']) }}
                {{ csrf_field() }}
                

                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-close"></i></button>
                        <h4 class="card-title" id="emailDetailModalHeading"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    <!-- <p class="lead"> Project Details:</p> -->

                    <div class="row">

                        <div class="col-md-12">
                            <label for="email_id" class="col-form-label">Email Account <k>*</k></label>
                            {{ Form::text('email_id', '', ['class' => 'form-control', 'id' => 'email_id']) }}
                            <span class="text-danger" id="email_id-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="display_name" class="col-form-label">Display Name <k>*</k></label>
                            {{ Form::text('display_name', '', ['class' => 'form-control', 'id' => 'display_name']) }}
                            <span class="text-danger" id="display_name-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="host" class="col-form-label">Host <k>*</k></label>
                            {{ Form::text('host', '', ['class' => 'form-control', 'id' => 'host']) }}
                            <span class="text-danger" id="host-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="password" class="col-form-label">Password <k>*</k></label>
                            {{ Form::text('password', '', ['class' => 'form-control', 'id' => 'password']) }}
                            <span class="text-danger" id="password-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <label for="security_type" class="col-form-label">Username <k>*</k></label>
                            {{ Form::select('security_type', $security_types, '', ['class' => 'form-control', 'id' => 'security_type']) }}
                            <span class="text-danger" id="security_type-error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="port" class="col-form-label">Port <k>*</k></label>
                            {{ Form::text('port', '', ['class' => 'form-control', 'id' => 'port']) }}
                            <span class="text-danger" id="port-error"></span>
                        </div>


                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'EmailDetailsSaveBtn']) !!}

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
