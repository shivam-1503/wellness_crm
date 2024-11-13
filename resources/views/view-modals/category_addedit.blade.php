
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

                    {!! Form::hidden('cat_id', '', ['id'=>'cat_id']); !!}

                    <div class="row">
                        <div class="col-6 mb-3 form-group ">
                            <label for="p_id">Parent Category</label>  
                            {!! Form::select('p_id', [''=>'Parent Category']+$categories, '', ['class'=>'standardSelect form-control border', 'title'=>'Select Parent Category', 'data-live-search'=>'true', 'id'=>'p_id' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                            <span class="text-danger" id="p_id-error"></span>
                        </div>
                        <div class="col-6 mb-3 form-group ">
                            <label for="title">Name *</label>                      
                            {!! Form::text('name', '', ['class'=>"form-control", 'id'=>"name", 'placeholder'=>"Enter category name", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xl-6 mb-3 form-group">
                            <label for="short_code">Short Code *</label>                      
                            {!! Form::text('short_code', '', ['class'=>"form-control", 'id'=>"short_code", 'placeholder'=>"Enter Short Code", 'required']); !!}
                            <span class="text-danger" id="short_code-error"></span>
                        </div>
                        
                        <div class="col-xl-6 mb-3 form-group">
                            <label for="statuses">Status*</label>  
                            {!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control border', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
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
