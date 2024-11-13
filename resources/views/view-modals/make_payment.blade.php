@php $payment_modes = ['cash' => 'Cash', 'cheque' => 'Cheque', 'netbanking' => 'Net Banking', 'upi' => 'UPI'] @endphp

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-signup card-plain">


                {{ Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class' => 'form-horizontal']) }}

                {{ Form::hidden('expanse_id', '', ['id' => 'expanse_id']) }}
                {{ Form::hidden('vendor_id', '', ['id' => 'vendor_id']) }}

                {{ csrf_field() }}
                

                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <h4 class="card-title" id="ajaxModalHeading"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    

                    


                    <div class="row">


                        <div class="col-md-12">
                            <label for="title" class="col-form-label">Title <k>*</k></label>
                            <!-- {{ Form::text('title', '', ['class' => 'form-control', 'id' => 'title']) }} -->
                            {{ Form::select('title', [''=>'Select Title']+$payment_titles, '', ['class' => 'standardSelect form-control', 'title' => 'Select Title', 'data-live-search' => 'true', 'id' => 'title', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                            <span class="text-danger" id="title-error"></span>
                        </div>

                        <div class="col-md-12">
                            <label for="full_name" class="col-form-label">Description <k>*</k></label>
                            {{ Form::textarea('description', '', ['class' => 'form-control', 'id' => 'description', 'rows'=>2]) }}
                            <span class="text-danger" id="remarks-error"></span>
                        </div>
                        

                        <div class="col-md-6">
                            <label for="amount" class="col-form-label">Amount Paid <k>*</k></label>
                            {{ Form::text('amount_paid', '', ['class' => 'form-control', 'id' => 'amount_paid']) }}
                            <span class="text-danger" id="amount-error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="vendor_id" class="col-form-label">Payment Made By</label>
                            {{ Form::select('payment_by', [''=>'Select User']+$users, '', ['class' => 'standardSelect form-control', 'title' => 'Select User', 'data-live-search' => 'true', 'id' => 'payment_by', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                            <span class="text-danger" id="vendor_id-error"></span>
                        </div>

                        
                    </div>


                    <div class="row">
                        
                        <div class="col-md-4">
                            <label for="vendor_id" class="col-form-label">Payment Mode </label>
                            {{ Form::select('payment_mode', $payment_modes, '', ['class' => 'standardSelect form-control', 'title' => 'Select Payment Mode', 'data-live-search' => 'true', 'id' => 'payment_mode', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                            <span class="text-danger" id="vendor_id-error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="amount" class="col-form-label">Payment Ref </label>
                            {{ Form::text('payment_ref', '', ['class' => 'form-control', 'id' => 'payment_ref']) }}
                            <span class="text-danger" id="payment_ref-error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="amount" class="col-form-label">Payment Date</label>
                            {{ Form::date('payment_date', '', ['class' => 'form-control', 'id' => 'payment_date']) }}
                            <span class="text-danger" id="payment_date-error"></span>
                        </div>

                        

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'saveBtn']) !!}

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
