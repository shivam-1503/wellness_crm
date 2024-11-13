@php $payment_modes = ['cash' => 'Cash', 'cheque' => 'Cheque', 'netbanking' => 'Net Banking', 'upi' => 'UPI'] @endphp

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-signup card-plain">


                {{ Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class' => 'form-horizontal']) }}

                {{ Form::hidden('expanse_id', '', ['id' => 'expanse_id']) }}
                {{ csrf_field() }}
                

                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <h4 class="card-title" id="ajaxModalHeading"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    <!-- <p class="lead"> Project Details:</p> -->
                    <div class="row">

                        <div class="col-md-6">
                            <label for="cat_id" class="col-form-label">Expanse Category </label>
                            {{ Form::select('cat_id', $cats, '', ['class' => 'standardSelect form-control', 'title' => 'Select Expanse Category', 'data-live-search' => 'true', 'id' => 'cat_id', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                            <span class="text-danger" id="cat_id-error"></span>
                        </div>


                        <div class="col-md-6">
                            <label for="vendor_id" class="col-form-label">Vendor </label>
                            {{ Form::select('vendor_id', $cats, '', ['class' => 'standardSelect form-control', 'title' => 'Select Vendor', 'data-live-search' => 'true', 'id' => 'vendor_id', 'data-dropup-auto' => 'false', 'data-size' => '5']) }}
                            <span class="text-danger" id="vendor_id-error"></span>
                        </div>

                    </div>




                    <div class="row">

                        <div class="col-md-6">
                            <label for="title" class="col-form-label">Title <k>*</k></label>
                            {{ Form::text('title', '', ['class' => 'form-control', 'id' => 'title']) }}
                            <span class="text-danger" id="title-error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="amount" class="col-form-label">Amount <k>*</k></label>
                            {{ Form::text('amount', '', ['class' => 'form-control', 'id' => 'amount']) }}
                            <span class="text-danger" id="amount-error"></span>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-12">
                            <label for="full_name" class="col-form-label">Description <k>*</k></label>
                            {{ Form::text('description', '', ['class' => 'form-control', 'id' => 'description']) }}
                            <span class="text-danger" id="description-error"></span>
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
