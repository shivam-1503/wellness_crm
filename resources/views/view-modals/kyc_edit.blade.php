@php $statuses = [1=>'Under Review', 2=>'Accepted', 3=>'Rejected']; @endphp
@php $documents = [1=>'Aadhar Card', 2=>'Pan Card', 3=>'Voter Card', 4=>'Passport']; @endphp


<div class="modal fade effect-scale" id="ajaxModel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Add Customer</h4><button aria-label="Close"
                    class="btn-close" onclick="reset_modal()"><span aria-hidden="true">&times;</span></button>
            </div>

            {!! Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class'=>'form-horizontal',
            'enctype'=>'multipart/form-data']) !!}

            <div class="modal-body">

                {{csrf_field()}}

                {!! Form::hidden('kyc_id', '', ['id'=>'kyc_id']); !!}

                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-row">
                                <div class="row">
                                    <div class="col-xl-6 mb-3">
                                        <p>Name: <span id="name_kyc"></span></p>
                                    </div>
                                    <div class="col-xl-6 mb-3 d-flex justify-content-end">
                                        <span class="badge bg-secondary">Ref:  <span id="ref_kyc"></span></span>
                                    </div>
                                    <div class="col-xl-6">
                                        <p>Document Type: <span id="kyc_type"> </span><p>
                                    </div>
                                    <div class="col-xl-6 d-flex justify-content-end">
                                        <p>Document Number: <span id="kyc_number"> </span><p>
                                    </div>

                                    <div class="col-xl-12">
                                        <hr>
                                    </div>
                                    
                                

                                    <div class="col-xl-12 mb-3">
                                        <label for="remarks">Enter Remarks</label>
                                        {!! Form::textarea('remarks', '', ['class'=>"form-control", 'id'=>"remarks", 'placeholder'=>"Enter Remarks", 'rows'=>2, 'required']); !!}
                                    </div>

                                    <div class="col-xl-6 mb-3">
                                        <label for="kyc_date">Verification date <k>*</k></label>
                                        {!! Form::date('kyc_date', '', ['class'=>"form-control", 'id'=>"kyc_date", 'placeholder'=>"Enter kyc_date Number", 'required']); !!}
                                        <span class="text-danger" id="kyc_date-error"></span>
                                    </div>

                                    <div class="col-xl-6 mb-3 form-group">
                                        <label for="status">Status <k>*</k></label>
                                            {!! Form::select('status', [''=>'Select Status']+$statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                                        <span class="text-danger" id="status-error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="images " onclick="show_img()"></div>
                        </div>
                    </div>
                </div>

                        

            </div>

            
            

            <div class="modal-footer justify-content-center">

                <button type="button" class="btn btn-secondary" onclick="reset_modal()">Close</button>

                {!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'saveBtn']); !!}

            </div>

            {!! Form::close(); !!}

        </div>
    </div>
</div>




<div class="modal" id="Modal4" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Aubrey Drake "Drizzy" Graham</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          SOMETHING
      </div>
  </div>
</div>