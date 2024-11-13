
@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        
                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="fas fa-times"></i></button>

                        <h4 class="card-title" id="modelHeading"></h4>
                    </div>
                </div>


                {!! Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class'=>'form-horizontal']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('content_id', '', ['id'=>'content_id']); !!}

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::textarea('content', '', ['class'=>"form-control", 'id'=>"content", 'placeholder'=>"Enter Content", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            {!! Form::textarea('description', '', ['class'=>"form-control", 'id'=>"description", 'placeholder'=>"Enter Description", 'rows'=>2, 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>

                        <div class="col-sm-4">
                            {!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                </div>

  				<div class="modal-footer">

            		<button type = "button" class = "btn btn-primary" data-bs-dismiss = "modal">Close</button>

                	{!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'saveBtn']); !!}

            	</div>

                {!! Form::close(); !!}

        </div>
    </div>
    </div>
</div>
