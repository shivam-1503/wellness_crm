@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade effect-scale" id="ajaxModelKyc" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h4 class="modal-title fw-bold" id="modelHeadingKyc">Add KYC</h4><button aria-label="Close" class="btn-close" onclick="reset_kyc()"><span aria-hidden="true">&times;</span></button>
        </div>


        {!! Form::open(['id' => 'dataFormKyc', 'name' => 'dataFormKyc', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('giftoffer_id', '', ['id'=>'giftoffer_id']); !!}

                    <div class="form-row">
                        <div class="row" >

                        <div class="col-xl-6 mb-3">
                            <label for="title">Gift Title*</label>                      
                            {!! Form::text('gift_title', '', ['class'=>"form-control", 'id'=>"gift_title", 'placeholder'=>"Enter Gift Title", 'required']); !!}
                            <span class="text-danger" id="gift_title-error"></span>
                        </div>

                        <div class="col-xl-6 mb-3">
                            <label for="points">Gift points*</label>                      
                            {!! Form::text('points', '', ['class'=>"form-control", 'id'=>"points", 'placeholder'=>"Enter Gift points", 'required']); !!}
                            <span class="text-danger" id="points-error"></span>
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="specification">Gift specification*</label>                      
                            {!! Form::text('specification', '', ['class'=>"form-control", 'id'=>"specification", 'placeholder'=>"Enter Gift specification", 'required']); !!}
                            <span class="text-danger" id="specification-error"></span>
                        </div>

                        <div class="col-xl-6 mb-3">
                        <label for="image">Image*</label>                      
                        {!! Form::file('image', ['class' => 'form-control', 'id' => 'image', 'required']) !!}
                        <span class="text-danger" id="image-error"></span>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="gift_status">Status*</label>  
                            {!! Form::select('gift_status', $statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select gift_status', 'data-live-search'=>'true', 'id'=>'gift_status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                            <span class="text-danger" id="gift_status-error"></span>
                        </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-center">

                <button type = "button" class = "btn btn-secondary" onclick="reset_kyc()">Close</button>

                {!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'saveBtnKyc']); !!}

                </div>

                {!! Form::close(); !!}

    </div>
    </div>
</div>
