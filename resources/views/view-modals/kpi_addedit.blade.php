
@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp


<style>

.bootstrap-select .btn {
  border: 1px solid #ddd;
  -webkit-appearance: none;
  -moz-appearance: none;
}

</style>


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

                    {!! Form::hidden('kpi_id', '', ['id'=>'kpi_id']); !!}

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::select('kpi_group_id', [''=>'Select KPI Group']+$groups, '', ['class'=>'standardSelect form-control', 'title'=>'Select Service Type ', 'data-live-search'=>'true', 'id'=>'kpi_group_id' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                            <span class="text-danger" id="kpi_group_id-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::text('title', '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Enter Service Title", 'required']); !!}
                            <span class="text-danger" id="title-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::textarea('description', '', ['class'=>"form-control", 'id'=>"description", 'placeholder'=>"Enter Service Description", 'rows'=>3, 'required']); !!}
                            <span class="text-danger" id="description-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::select('unit', [''=>'Select Unit']+$units, '', ['class'=>'standardSelect form-control', 'title'=>'Select Unit', 'data-live-search'=>'true', 'id'=>'unit' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                            <span class="text-danger" id="type-error"></span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::select('status', [''=>'Select Status']+$statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
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