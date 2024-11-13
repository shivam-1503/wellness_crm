<div class="modal fade" id="smsDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-signup card-plain">


                {{ Form::open(['id' => 'smsForm', 'name' => 'smsForm', 'class' => 'form-horizontal']) }}
                {{ csrf_field() }}
                

                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-close"></i></button>
                        <h4 class="card-title" id="smsDetailModalHeading"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    <!-- <p class="lead"> Project Details:</p> -->
                    <div class="row">

                        <div class="col-md-12">
                            <label for="endpoint" class="col-form-label">Host Endpoint <k>*</k></label>
                            {{ Form::text('endpoint', '', ['class' => 'form-control', 'id' => 'endpoint']) }}
                            <span class="text-danger" id="endpoint-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="username" class="col-form-label">Username <k>*</k></label>
                            {{ Form::text('username', '', ['class' => 'form-control', 'id' => 'username']) }}
                            <span class="text-danger" id="username-error"></span>
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

                        <div class="col-md-12">
                            <label for="bearer_token" class="col-form-label">Bearer Token <k>*</k></label>
                            {{ Form::text('bearer_token', '', ['class' => 'form-control', 'id' => 'bearer_token']) }}
                            <span class="text-danger" id="youtube-error"></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label for="sender_name" class="col-form-label">Sender Name <k>*</k></label>
                            {{ Form::text('sender_name', '', ['class' => 'form-control', 'id' => 'sender_name']) }}
                            <span class="text-danger" id="sender_name-error"></span>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'SmsDetailsSaveBtn']) !!}

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
