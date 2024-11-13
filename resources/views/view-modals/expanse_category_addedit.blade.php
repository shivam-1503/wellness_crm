
@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>

                        <h4 class="card-title" id="modelHeading"></h4>
                    </div>
                </div>


                {!! Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class'=>'form-horizontal']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('cat_id', '', ['id'=>'cat_id']); !!}

                    <div class="row form-group">
                        <div class="col-sm-12">
                        {!! Form::select('p_id', [''=>'Select Parent Category']+$p_cats, '', ['class'=>'standardSelect form-control', 'title'=>'Select Parent Category', 'data-live-search'=>'true', 'id'=>'p_id', 'data-dropup-auto'=>'false', 'data-size'=>'']) !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::text('name', '', ['class'=>"form-control", 'id'=>"name", 'placeholder'=>"Enter Category Name", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::textarea('description', '', ['class'=>"form-control", 'rows'=>"3" ,'id'=>"description", 'placeholder'=>"Enter Description", 'required']); !!}
                            <span class="text-danger" id="description-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                </div>

  				<div class="modal-footer">

            		<button type = "button" class = "btn btn-danger" data-bs-dismiss = "modal"> Close</button>

                	{!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'saveBtn']); !!}

            	</div>

                {!! Form::close(); !!}

        </div>
    </div>
    </div>
</div>
