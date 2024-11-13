
@php $statuses = [2=>'Accept', 4=>'Reject']; @endphp




<div class="modal fade effect-scale" id="ajaxModel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h4 class="modal-title" id="modelHeading">Add Dealer</h4>
            <button aria-label="Close" class="btn-close" onclick="reset_modal()"><span aria-hidden="true">&times;</span></button>
        </div>


        {!! Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('request_id', '', ['id'=>'request_id']); !!}

                    <div class="details-form">
                        
                        <div class="row" >

                            <div class="col-xl-12 mb-3 form-group">
                                <label for="status">Status <k>*</k></label>  
                                {!! Form::select('status', [''=>'Select Status']+$statuses, '', ['class'=>'form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                                <span class="text-danger" id="status-error"></span>
                            </div>

                            <div class="col-xl-12 mb-3">
                                <label for="terms">Remarks</label>                      
                                {!! Form::textarea('remarks', '', ['class'=>"form-control", 'id'=>"remarks", "rows"=>3, 'placeholder'=>"Enter Remarks"]); !!}
                                <span class="text-danger" id="terms-error"></span>
                            </div>


                        </div>
                        
                    </div>

                </div>

                <div class="modal-footer justify-content-center">

                <button type = "button" class = "btn btn-secondary" onclick="reset_modal()">Close</button>

                {!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'saveBtn']); !!}

                </div>

                {!! Form::close(); !!}

    </div>
    </div>
</div>
