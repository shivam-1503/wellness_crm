
@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp
@php $ratings = [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5']; @endphp
@php $types = [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5']; @endphp




<div class="modal fade effect-scale" id="ajaxModel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h4 class="modal-title" id="modelHeading">Add Dealer</h4>
            <button aria-label="Close" class="btn-close" onclick="reset_modal()"><span aria-hidden="true">&times;</span></button>
        </div>


        {!! Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('dealer_id', '', ['id'=>'dealer_id']); !!}

                    <div class="details-form">
                        

                        <h4>Basic Details: </h4> <hr>
                        
                        
                        <div class="row" >
                            <div class="col-xl-4 mb-3">
                                <label for="name">Name <k>*</k></label>                      
                                {!! Form::text('name', '', ['class'=>"form-control", 'id'=>"name", 'placeholder'=>"Enter Name", 'required']); !!}
                                <span class="text-danger" id="name-error"></span>
                            </div>

                            <div class="col-xl-4 mb-3">
                                <label for="mobile">Mobile Number <k>*</k></label>                      
                                {!! Form::text('mobile', '', ['class'=>"form-control", 'id'=>"mobile", 'placeholder'=>"Enter Mobile Number", 'required']); !!}
                                <span class="text-danger" id="mobile-error"></span>
                            </div>

                            <div class="col-xl-4 mb-3">
                                <label for="email">Email <k>*</k></label>                      
                                {!! Form::text('email', '', ['class'=>"form-control", 'id'=>"email", 'placeholder'=>"Enter Email Address"]); !!}
                                <span class="text-danger" id="email-error"></span>
                            </div>

                            <div class="col-xl-4 mb-3">
                                <label for="date_of_birth">Date of birth <k>*</k></label>                      
                                {!! Form::date('date_of_birth', '', ['class'=>"form-control", 'id'=>"date_of_birth", 'placeholder'=>"Enter Date of Birth", 'required']); !!}
                                <span class="text-danger" id="date_of_birth-error"></span>
                            </div>

                            <div class="col-xl-4 mb-3">
                                <label for="aadhar">Aadhar Number </label>                      
                                {!! Form::text('aadhar', '', ['class'=>"form-control", 'id'=>"aadhar", 'placeholder'=>"Enter Aadhar Number", 'required']); !!}
                                <span class="text-danger" id="aadhar-error"></span>
                            </div>

                            <div class="col-xl-4 mb-3 form-group">
                                <label for="status">Status <k>*</k></label>  
                                {!! Form::select('status', [''=>'Select Status']+$statuses, '', ['class'=>'form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                                <span class="text-danger" id="status-error"></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4 class="mt-4">Permanent Details</h4> <hr>
                                        <div class="row">
                                            <div class="col-xl-12 mb-3">
                                                <label for="permanent_address">Permanent Address <k>*</k></label>
                                                {!! Form::text('permanent_address', '', ['class'=>"form-control", 'id'=>"permanent_address",
                                                'placeholder'=>"Enter Permanant Address"]); !!}
                                                <span class="text-danger" id="permanent_address-error"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 mb-3 form-group">
                                                <label for="present_state_id">Permanent State <k>*</k></label>
                                                {!! Form::select('permanent_state_id', [''=>'Select State']+$states, '', ['class'=>'form-control standardSelect',
                                                'title'=>'Select State', 'data-live-search'=>'true', 'id'=>'permanent_state_id' ,
                                                'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                                                <span class="text-danger" id="present_state_id-error"></span>
                                            </div>
                                            
                                            <div class="col-xl-6 mb-3 form-group">
                                                <label for="permanent_district_id">Permanent District <k>*</k></label>
                                                {!! Form::select('permanent_district_id', [''=>'Select District']+$districts, '', ['class'=>'form-control standardSelect', 'title'=>'Select District', 'data-live-search'=>'true',
                                                'id'=>'permanent_district_id' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false',
                                                'data-size'=>'5'])!!}
                                                <span class="text-danger" id="permanent_district_id-error"></span>
                                            </div>

                                            <div class="col-xl-6 mb-3">
                                                <label for="permanent_city">Permanent City <k>*</k></label>
                                                {!! Form::text('permanent_city', '', ['class'=>"form-control", 'id'=>"permanent_city",
                                                'placeholder'=>"Enter Permanant City"]); !!}
                                                <span class="text-danger" id="permanent_city-error"></span>
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="permanent_pincode">Permanent Pincode <k>*</k></label>
                                                {!! Form::text('permanent_pincode', '', ['class'=>"form-control", 'id'=>"permanent_pincode",
                                                'placeholder'=>"Enter Permanant Pincode"]); !!}
                                                <span class="text-danger" id="permanent_pincode-error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4 class="mt-4">Present Details</h4> <hr>
                                        <div class="row">
                                            <div class="col-xl-12 mb-3">
                                                <label for="present_address">Present Address <k>*</k></label>
                                                {!! Form::text('present_address', '', ['class'=>"form-control standardSelect", 'id'=>"present_address",
                                                'placeholder'=>"Enter Present Address"]); !!}
                                                <span class="text-danger" id="present_address-error"></span>
                                            </div>
                                            <div class="col-xl-6 mb-3 form-group">
                                                <label for="present_state_id">Present State <k>*</k></label>
                                                {!! Form::select('present_state_id', [''=>'Select State']+$states, '', ['class'=>'form-control standardSelect',
                                                'title'=>'Select State', 'data-live-search'=>'true', 'id'=>'present_state_id' ,
                                                'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                                                <span class="text-danger" id="present_state_id-error"></span>
                                            </div>
                                            <div class="col-xl-6 mb-3 form-group">
                                                <label for="present_district_id">Present District <k>*</k></label>
                                                {!! Form::select('present_district_id', [''=>'Select District']+$districts, '', ['class'=>'form-control standardSelect',
                                                'title'=>'Select District', 'data-live-search'=>'true', 'id'=>'present_district_id' ,
                                                'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                                                <span class="text-danger" id="present_district_id-error"></span>
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="present_city">Present City <k>*</k></label>
                                                {!! Form::text('present_city', '', ['class'=>"form-control", 'id'=>"present_city",
                                                'placeholder'=>"Enter Permanant City"]); !!}
                                                <span class="text-danger" id="present_city-error"></span>
                                            </div>
                                            <div class="col-xl-6 mb-3">
                                                <label for="present_pincode">Present Pincode <k>*</k></label>
                                                {!! Form::text('present_pincode', '', ['class'=>"form-control", 'id'=>"present_pincode",
                                                'placeholder'=>"Enter Permanant Pincode"]); !!}
                                                <span class="text-danger" id="present_pincode-error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="row">
                            <div class="col-xl-4 mb-3 form-group">
                                <label for="rating">Ratings <k>*</k></label>  
                                {!! Form::select('rating', $ratings, '', ['class'=>'standardSelect form-control', 'title'=>'Select Rating', 'data-live-search'=>'true', 'id'=>'rating' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                                <span class="text-danger" id="rating-error"></span>
                            </div>
                        </div> -->
                        
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
