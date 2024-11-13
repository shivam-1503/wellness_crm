
@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp


<div class="modal fade effect-scale" id="ajaxModel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h4 class="modal-title" id="modelHeading">Add Offer</h4>
            <button aria-label="Close" class="btn-close" onclick="reset_modal()"><span aria-hidden="true">&times;</span></button>
        </div>


        {!! Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('dealer_id', '', ['id'=>'dealer_id']); !!}

                    <div class="details-form">
                        

                        <h4>Basic Details: </h4> <hr>
                        
                        
                        <div class="row" >
                            <div class="col-xl-6 mb-3">
                                <label for="title">Offer*</label>                      
                                {!! Form::text('title', '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Enter Offer", 'required']); !!}
                                <span class="text-danger" id="title-error"></span>
                            </div>
                            
                            <div class="col-xl-6 mb-3">
                                <label for="offer_code">Offer Code*</label>                      
                                {!! Form::text('offer_code', '', ['class'=>"form-control", 'id'=>"offer_code", 'placeholder'=>"Enter Offer Code", 'required']); !!}
                                <span class="text-danger" id="offer_code-error"></span>
                            </div>
                            <div class="col-xl-6 mb-3">
                                <label for="start_date">Start Date*</label>                      
                                {!! Form::date('start_date', '', ['class'=>"form-control", 'id'=>"start_date", 'placeholder'=>"Select Start date", 'required']); !!}
                                <span class="text-danger" id="start_date-error"></span>
                            </div>
                            <div class="col-xl-6 mb-3">
                                <label for="end_date">end date*</label>                      
                                {!! Form::date('end_date', '', ['class'=>"form-control", 'id'=>"end_date", 'placeholder'=>"Select End Date", 'required']); !!}
                                <span class="text-danger" id="end_date-error"></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-6 mb-3">
                                <label for="description">Description*</label>                      
                                {!! Form::textarea('description', '', ['class'=>"form-control", 'id'=>"description", "rows"=>3, 'placeholder'=>"Enter Description", 'required']); !!}
                                <span class="text-danger" id="description-error"></span>
                            </div>
                            <div class="col-xl-6 mb-3">
                                <label for="terms">Terms and Conditions*</label>                      
                                {!! Form::textarea('terms', '', ['class'=>"form-control", 'id'=>"terms", "rows"=>3, 'placeholder'=>"Enter Terms and condition", 'required']); !!}
                                <span class="text-danger" id="terms-error"></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-6 mb-3">
                            <label for="banner">Image*</label>                      
                            {!! Form::file('banner', ['class' => 'form-control', 'id' => 'banner', 'required']) !!}
                            <span class="text-danger" id="banner-error"></span>
                            </div>
                            <div class="col-xl-6 mb-3">
                                <label for="status">Status*</label>  
                                {!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                                <span class="text-danger" id="status-error"></span>
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



