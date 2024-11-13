
@php $statuses = [1=>'Completed']; @endphp

<div class="modal fade effect-scale" id="responseModel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h4 class="modal-title fw-bold" id="modelHeading">Add Task</h4><button aria-label="Close" class="btn-close" onclick="reset_modal()"><span aria-hidden="true">&times;</span></button>
        </div>


        {!! Form::open(['id' => 'responseForm', 'name' => 'responseForm', 'class'=>'form-horizontal']) !!}

                <div class="modal-body">

                    {{csrf_field()}}

                    {!! Form::hidden('response_task_id', '', ['id'=>'response_task_id']); !!}

                    <div class="form-row">
                        
                        <div class="col-xl-12 mb-3">
                            <label for="title">Response Remarks*</label>                      
                            {!! Form::textarea('remarks', '', ['class'=>"form-control", 'id'=>"response", 'rows'=>2, 'placeholder'=>"Enter description", 'required']); !!}
                            <span class="text-danger" id="response-error"></span>
                        </div>

                        <div class="col-xl-6">
                            <label for="status">Response Status*</label>  
                            {!! Form::select('response_status', $statuses, '', ['class'=>'standardSelect form-control border', 'title'=>'Select Response Status', 'data-live-search'=>'true', 'id'=>'response_status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                            <span class="text-danger" id="status-error"></span>
                        </div>

                        <div class="col-xl-6 date-div" style="display: none;">
                            <label for="title">Start Date*</label>
                            <div class="input-group mb-3">  
                                {{ Form::date('start_date','',['class'=>'form-control', 'id'=>"start_date"]) }}
                                {{ Form::time('start_time','',['class'=>'form-control', 'id'=>"start_time"]) }}
                            </div>
                                                
                            <span class="text-danger" id="name-error"></span>
                        </div>
                        
                        
                    </div>

                </div>

                <div class="modal-footer justify-content-center">

                <button type = "button" class = "btn btn-primary" data-bs-dismiss = "modal">Close</button>

                {!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'saveResponseBtn']); !!}
                
                </div>

                {!! Form::close(); !!}

    </div>
    </div>
</div>
