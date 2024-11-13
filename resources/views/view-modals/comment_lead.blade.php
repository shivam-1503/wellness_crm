
@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade" id="commentModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                        <h4 class="card-title" id="modelHeading"></h4>
                    </div>
                </div>


                {!! Form::open(['id' => 'commentForm', 'name' => 'commentForm', 'class'=>'form-horizontal']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('lead_id_c', '', ['id'=>'lead_id_c']); !!}

                
                    <div class="row form-group">
                        <div class="col-sm-12">
                            {{Form::textarea('comment','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Leave Your Comment', 'rows'=>'3'])}}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {{ Form::select('stage_id_c', $stages, '', ['class'=>'standardSelect form-control', 'title'=>'Select Stage', 'data-live-search'=>'true', 'id'=>'stage_id_c' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {{ Form::select('priority_c', $priorities, '', ['class'=>'standardSelect form-control', 'title'=>'Select Lead Priority', 'data-live-search'=>'true', 'id'=>'priority_c', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                </div>

  				<div class="modal-footer">

                  <button type = "button" class = "btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>

                	{!! Form::submit('Submit', ['class'=>'btn btn-primary btn-sm', 'id'=>'saveCommentBtn']); !!}

            	</div>

                {!! Form::close(); !!}

        </div>
    </div>
    </div>
</div>
