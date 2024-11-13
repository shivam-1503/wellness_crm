@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp

<div class="modal fade effect-scale" id="ProgramModel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h4 class="modal-title fw-bold" id="ProgramHeading">Add Program</h4><button aria-label="Close" class="btn-close" onclick="reset_modal()"><span aria-hidden="true">&times;</span></button>
        </div>


        {!! Form::open(['id' => 'programForm', 'name' => 'programForm', 'class'=>'form-horizontal']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('product_id', '', ['id'=>'product_id']); !!}

                    <div class="form-row">
                        <div class="col-xl-6 mb-3">
                            <label for="clients_id">Parent Category</label>  
                            {!! Form::select('clients_id', $categories, '', ['class'=>'standardSelect form-control border', 'title'=>'Select Parent Category', 'data-live-search'=>'true', 'id'=>'p_id' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                            <span class="text-danger" id="p_id-error"></span>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="title">Name *</label>                      
                            {!! Form::text('name', '', ['class'=>"form-control", 'id'=>"name", 'placeholder'=>"Enter category name", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>

                        <div class="col-xl-12 mb-3">
                            <label for="description">Description *</label>                      
                            {!! Form::textarea('description', '', ['class'=>"form-control", 'id'=>"description", 'placeholder'=>"Enter description", 'rows'=>3, 'required']); !!}
                            <span class="text-danger" id="description-error"></span>
                        </div>                

                        <div class="col-xl-6 mb-3">
                            <label for="slug">Slug *</label>                      
                            {!! Form::text('slug', '', ['class'=>"form-control", 'id'=>"slug", 'placeholder'=>"Enter Slug", 'required']); !!}
                            <span class="text-danger" id="slug-error"></span>
                        </div>
                        
                        <div class="col-xl-6 mb-3">
                            <label for="statuses">Status*</label>  
                            {!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control border', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                            <span class="text-danger" id="statuses-error"></span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-center">

                <button type = "button" class = "btn btn-secondary" onclick="reset_modal()">Close</button>

                {!! Form::submit('submit', ['class'=>'btn btn-primary', 'id'=>'ProgramBtn']); !!}

                </div>

                {!! Form::close(); !!}

    </div>
    </div>
</div>
