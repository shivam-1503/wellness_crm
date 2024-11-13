@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<style>strong{color:#f16a6a; font-family: auto;}</style>

<div class="card shadow mb-4">
<!-- Default Card Example -->
    <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-primary">Add New Company
        <span class="pull-right"><a href="{{ url('sales/companies') }}" class="btn btn-sm btn-primary" style="float:right;"><i class="fa fa-arrow-left"></i> Back</a></span></h4>
    </div>


            <div class="card-body">
                {{ Form::open(array('url'=>'/sales/company/store'))}}
                    @csrf

                    <div class="form-group row">
                        <label for="cus_name" class="col-md-4 col-form-label"><b>Company Name<span style="color:red;">*</span></b></label>
                        <div class="col-md-6">
                            {{ Form::text('name','',['class'=>'form-control']) }}

                            @if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="tax_type_id" class="col-md-4 col-form-label"><b>Company Type</b></label>
                        <div class="col-md-6">
                            {{ Form::select('company_type_id_fk',array(''=>'Please select')+$company_types,'',['class'=>'form-control']) }}

                            @if ($errors->has('company_type_id_fk'))
                                <span class="help-block">
                                <strong>{{ $errors->first('company_type_id_fk') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="tax_type_id" class="col-md-4 col-form-label"><b>Industry</b></label>
                        <div class="col-md-6">
                            {{ Form::select('industry_id_fk',array(''=>'Please select')+$industries,'',['class'=>'form-control']) }}

                            @if ($errors->has('industry_id_fk'))
                                <span class="help-block">
                                <strong>{{ $errors->first('industry_id_fk') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="contact_no" class="col-md-4 col-form-label"><b>Phone<span style="color:red;">*</span></b></label>
                        <div class="col-md-6">
                            {{ Form::text('phone','',['class'=>'form-control']) }}

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>




                    <div class="form-group row">
                        <label for="cus_email" class="col-md-4 col-form-label"><b>Email<span style="color:red;">*</span></b></label>
                        <div class="col-md-6">
                            {{ Form::text('email','',['class'=>'form-control']) }}

                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="cus_email" class="col-md-4 col-form-label"><b>Website</b></label>
                        <div class="col-md-6">
                            {{ Form::text('website','',['class'=>'form-control']) }}

                            @if ($errors->has('website'))
                                <span class="help-block">
                                <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                     <div class="form-group row">
                        <label for="remarks" class="col-md-4 col-form-label"><b>Remarks</b></label>
                        <div class="col-md-6">
                            {{ Form::textarea('remarks','',['class'=>'form-control','rows'=>3,'cols'=>4]) }}

                            @if ($errors->has('remarks'))
                                <span class="help-block">
                                <strong>{{ $errors->first('remarks') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label"><b>Status</b></label>
                        <div class="col-md-6">
                            {{ Form::select('status',array('0'=>'Inactive','1'=>'Active'),'',['class'=>'form-control']) }}

                            @if ($errors->has('source_id_fk'))
                                <span class="help-block">
                                <strong>{{ $errors->first('source_id_fk') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4" align="right">
                           {{ Form::submit('submit',array('class'=>'btn btn-primary')) }}
                        </div>
                    </div>
                </form>
            </div>
        

</div>



@endsection
