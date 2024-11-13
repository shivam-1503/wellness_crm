@php $documents = [1=>'Aadhar Card', 2=>'Pan Card', 3=>'Voter Card', 4=>'Passport']; @endphp

<div class="modal fade effect-scale" id="ajaxModelKyc" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeadingKyc">Add KYC</h4>
                <button aria-label="Close" class="btn-close" onclick="reset_kyc()"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            {!! Form::open(['id' => 'dataFormKyc', 'name' => 'dataFormKyc', 'class'=>'form-horizontal',
            'enctype'=>'multipart/form-data']) !!}

            <div class="modal-body">

                {{csrf_field()}}

                {!! Form::hidden('user_id', '', ['id'=>'user_id']); !!}
                {!! Form::hidden('user_type', '', ['id'=>'user_type']); !!}

                <div class="form-row">
                    <div class="row">

                        <div class="col-xl-6 mb-3 form-group">
                            <label for="kyc_document_id">Document Type <k>*</k></label>
                            {!! Form::select('kyc_document_id', [''=>'Select Document']+$documents, '',
                            ['class'=>'form-control', 'title'=>'Select Document Type', 'data-live-search'=>'true',
                            'id'=>'kyc_document_id' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false',
                            'data-size'=>'5'])!!}
                            <span class="text-danger" id="kyc_document_id-error"></span>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="kyc_document_no">Document Number <k>*</k></label>
                            {!! Form::text('kyc_document_no', '', ['class'=>"form-control", 'id'=>"kyc_document_no",
                            'placeholder'=>"Enter Document Number", 'required']); !!}
                            <span class="text-danger" id="kyc_document_no-error"></span>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="kyc_document_image">Image <k>*</k></label>
                            {!! Form::file('kyc_document_image', ['class' => 'form-control', 'id' =>
                            'kyc_document_image', 'required']) !!}
                            <span class="text-danger" id="kyc_document_image-error"></span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer justify-content-center">

                <button type="button" class="btn btn-secondary" onclick="reset_kyc()">Close</button>

                {!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'saveBtnKyc']); !!}

            </div>

            {!! Form::close(); !!}

        </div>
    </div>
</div>