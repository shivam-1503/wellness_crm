@php $statuses = [''=>'Status', 1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade effect-scale" id="ProgramModel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h4 class="modal-title fw-bold" id="ProgramHeading">Add Program</h4><button aria-label="Close" class="btn-close" onclick="reset_modal()"><span aria-hidden="true">&times;</span></button>
        </div>


        {!! Form::open(['id' => 'programForm', 'name' => 'programForm', 'class'=>'form-horizontal']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('attribute_value_id', '', ['id'=>'attribute_value_id']); !!}

                    <div class="form-group row">
                        <div class="col-12 mb-3">
                            <label for="clients_id">Parent Category</label>  
                            {!! Form::select('attribute_id', [''=>'attributes']+$attributes, '', ['class'=>'standardSelect form-control', 'title'=>'Select Attribute', 'id'=>'attribute_id'])!!}
                            <span class="text-danger" id="attribute_id-error"></span>
                        </div>
                    </div>

                    <div class="form-group row">    
                        <div class="col-12 mb-3">
                            <label for="title">Value for Attribute *</label>                      
                            {!! Form::text('value', '', ['class'=>"form-control", 'id'=>"value", 'placeholder'=>"Enter Value for attribute", 'required']); !!}
                            <span class="text-danger" id="value-error"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12 mb-3">
                            <label for="statuses">Status*</label>  
                            {!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'id'=>'status'])!!}
							<span class="text-danger" id="status-error"></span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-center">

                <button type = "button" class = "btn btn-secondary" onclick="reset_modal()">Close</button>

                {!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'ProgramBtn']); !!}

                </div>

                {!! Form::close(); !!}

    </div>
    </div>
</div>
