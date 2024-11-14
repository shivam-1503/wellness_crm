
@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                        <h4 class="card-title" id="modelHeading"></h4>
                    </div>
                </div>


                {!! Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class'=>'form-horizontal']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('patient_id', '', ['id'=>'patient_id']); !!}

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::text('name', '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Enter Name", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::select('docter', $docters, '', ['class'=>'standardSelect form-control', 'title'=>'Select Docter', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::text('phone', '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Enter Phone number", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::text('email', '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Enter Email", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::text('address', '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Enter Address", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::date('DOB', '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Date of Birth", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                </div>

  				<div class="modal-footer">

                  <button type = "button" class = "btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>

                	{!! Form::submit('submit', ['class'=>'btn btn-primary btn-sm', 'id'=>'saveBtn']); !!}

            	</div>

                {!! Form::close(); !!}

        </div>
    </div>
    </div>
</div>
