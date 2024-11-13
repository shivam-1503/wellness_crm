@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<style>strong{color:#f16a6a; font-family: auto;}</style>

<div class="card shadow mb-4">
<!-- Default Card Example -->
    <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-primary">Update Customer Details
        <span class="pull-right"><a href="{{ url('sales/customers') }}" class="btn btn-sm btn-primary" style="float:right;"><i class="fa fa-arrow-left"></i> Back</a></span></h4>
    </div>

            <div class="card-body">
                {{ Form::open(array('url'=>'/sales/customers/edit/'.$data->id))}}
                    @csrf

                    @php
                      
                     $title = array(''=>'Select','Mr'=>'Mr','Mrs'=>'Mrs','Ms'=>'Ms','Miss'=>'Miss','Dr'=>'Dr');

                    @endphp

                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label"><b>Salutation</b></label>
                        <div class="col-md-6">
                            {{ Form::select('title',$title,$data->title,['class'=>'form-control']) }}

                             @if ($errors->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cus_name" class="col-md-4 col-form-label"><b>First Name<span style="color:red;">*</span></b></label>
                        <div class="col-md-6">
                            {{ Form::text('first_name',$data->first_name,['class'=>'form-control']) }}

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cus_name" class="col-md-4 col-form-label"><b>Last Name</b></label>
                        <div class="col-md-6">
                            {{ Form::text('last_name',$data->last_name,['class'=>'form-control']) }}

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="cus_email" class="col-md-4 col-form-label"><b>Position</b></label>
                        <div class="col-md-6">
                            {{ Form::text('position',$data->position,['class'=>'form-control']) }}

                            @if ($errors->has('position'))
                                <span class="help-block">
                                <strong>{{ $errors->first('position') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="contact_no" class="col-md-4 col-form-label"><b>Phone<span style="color:red;">*</span></b></label>
                        <div class="col-md-6">
                            {{ Form::text('phone',$data->phone,['class'=>'form-control']) }}

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
                            {{ Form::text('email',$data->email,['class'=>'form-control']) }}

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
                            {{ Form::text('website',$data->website,['class'=>'form-control']) }}

                            @if ($errors->has('website'))
                                <span class="help-block">
                                <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="parent_acc" class="col-md-4 col-form-label"><b>Company</b></label>
                        <div class="col-md-6">
                            {{ Form::select('company_id_fk',array(''=>'Please select')+$companies,$data->company_id_fk,['class'=>'form-control']) }}

                            @if ($errors->has('company_id_fk'))
                                <span class="help-block">
                                <strong>{{ $errors->first('company_id_fk') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="location_id_fk" class="col-md-4 col-form-label"><b>Contact Type</b></label>
                        <div class="col-md-6">
                            {{ Form::select('contact_type_id_fk',array(''=>'Please select')+$contact_types,$data->contact_type_id_fk,['class'=>'form-control']) }}

                            @if ($errors->has('contact_type_id_fk'))
                                <span class="help-block">
                                <strong>{{ $errors->first('contact_type_id_fk') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="tax_type_id" class="col-md-4 col-form-label"><b>Source</b></label>
                        <div class="col-md-6">
                            {{ Form::select('source_id_fk',array(''=>'Please select')+$sources,$data->source_id_fk,['class'=>'form-control']) }}

                            @if ($errors->has('source_id_fk'))
                                <span class="help-block">
                                <strong>{{ $errors->first('source_id_fk') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                     <div class="form-group row">
                        <label for="remarks" class="col-md-4 col-form-label"><b>Remarks</b></label>
                        <div class="col-md-6">
                            {{ Form::textarea('remarks',$data->remarks,['class'=>'form-control','rows'=>3,'cols'=>3]) }}

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
                            {{ Form::select('status',array('0'=>'Inactive','1'=>'Active'),$data->status,['class'=>'form-control']) }}

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
