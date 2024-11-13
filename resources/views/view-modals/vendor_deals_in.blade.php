@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade" id="ajaxCatModel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card card-signup card-plain">


                {{ Form::open(['id' => 'catForm', 'name' => 'catForm', 'class' => 'form-horizontal']) }}

                {{ Form::hidden('vendor_id', '', ['id' => 'deals_vendor_id']) }}
                {{ csrf_field() }}
                

                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <h4 class="card-title" id="ajaxCatModalHeading"></h4>
                    </div>
                </div>

                <div class="modal-body">

                    

                    <!-- <p class="lead">Contact Details:</p> -->
                    <div class="row">
                                                    
                        <span class="text-danger" id="name-error"></span>
                        
                        @foreach($categories as $key => $obj) 
                            <div class="col-md-12">
                                {{  Form::checkbox('deals_in[]', $key, false, ['id'=>'cat_'.$key])  }} <label for="name" class="col-form-label"> {{ $obj }}</label>
                            </div>
                        @endforeach
                    </div>

                    
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'saveCatBtn']) !!}

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
