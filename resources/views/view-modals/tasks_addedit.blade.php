
@php 
    $statuses = [1=>'Active', 0=>'Inactive'];                                     
    $priorities = ['P0'=>'P0', 'P1'=>'P1', 'P2'=>'P2', 'P3'=>'P3', 'P4'=>'P4'];
@endphp

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                        <h4 class="card-title" id="modelHeading"></h4>
                    </div>
                </div>


        {!! Form::open(['id' => 'dataForm', 'name' => 'dataForm', 'class'=>'form-horizontal']) !!}

                <div class="modal-body">


                    {{csrf_field()}}

                    {!! Form::hidden('task_id', '', ['id'=>'task_id']); !!}

                    <div class="form-row">
                        <div class="col-xl-12 mb-3">
                            <label for="title">Title*</label>                      
                            {!! Form::text('title', '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Enter title", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>

                        <div class="col-xl-12 mb-3">
                            <label for="title">Description*</label>                      
                            {!! Form::textarea('description', '', ['class'=>"form-control", 'id'=>"description", 'rows'=>2, 'placeholder'=>"Enter description", 'required']); !!}
                            <span class="text-danger" id="name-error"></span>
                        </div>


                        <div class="col-xl-6">
                        <label for="title">Start Date*</label>
                            <div class="input-group mb-3">  
                                {{ Form::date('start_date','',['class'=>'form-control', 'id'=>"start_date"]) }}
                                {{ Form::time('start_time','',['class'=>'form-control', 'id'=>"start_time"]) }}
                            </div>
                                                
                            <span class="text-danger" id="name-error"></span>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="status">Deadline*</label>  
                            {!! Form::date('deadline', '', ['class'=>"form-control", 'id'=>"deadline", 'placeholder'=>"Enter deadline date", 'required']); !!}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                        
                        <div class="col-xl-4">
                            <label for="priority">Priority </label>  
                            {!! Form::select('priority', [''=>'Select Priority']+$priorities, '', ['class'=>'standardSelect form-control border', 'title'=>'Select Priority', 'data-live-search'=>'true', 'id'=>'priority' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                        
                        @if(isset($users))
                        <div class="col-xl-4">
                            <label for="status">User</label>  
                            {!! Form::select('user_id', [''=>'Select User']+$users, '', ['class'=>'standardSelect form-control border', 'title'=>'Select User', 'data-live-search'=>'true', 'id'=>'user_id' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                            <span class="text-danger" id="status-error"></span>
                        </div>
                        @endif

                        <div class="col-xl-4">
                            <label for="status">Status*</label>  
                            {!! Form::select('status', [''=>'Select Status']+$statuses, '', ['class'=>'standardSelect form-control border', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5'])!!}
                            <span class="text-danger" id="status-error"></span>
                        </div>

                        
                    </div>

                </div>

                <div class="modal-footer justify-content-center">

                <button type = "button" class = "btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>

                {!! Form::submit('submit', ['class'=>'btn btn-primary btn-sm', 'id'=>'saveBtn']); !!}
                
                </div>

                {!! Form::close(); !!}

    </div>
    </div>
    </div>
</div>


<div id="calendarModal" class="modal fade">
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h4 class="modal-title fw-bold" id="modelHeading">Event Details</h4><button aria-label="Close" class="btn-close" data-bs-dismiss = "modal"><span aria-hidden="true">&times;</span></button>
        </div>

        <div id="modalBody" class="modal-body">
        {{csrf_field()}}
        {!! Form::hidden('del_item', '', ['id'=>"del_item"]) !!}


        <div class="row">
            <div class="col-md-12">
                <h4>About User:</h4>
            </div>
            <div class="col-md-6">
                <span class="text-muted">User Name:</span>
                <p class="value lead" id="username"></p>
            </div>

            <div class="col-md-6">
                <span class="text-muted">Phone</span>
                <p class="value lead"  id="phone"></p>
            </div>
        </div>


        <hr>


        <div class="row">
            <div class="col-md-12">
                <h4>About Event:</h4>
            </div>
            <div class="col-md-6">
                <span class="text-muted">Event Name</span>
                <p class="value lead" id="task"></p>
            </div>

            <div class="col-md-6">
                <span class="text-muted">Event Date</span>
                <p class="value lead"  id="modalWhen"></p>
            </div>

            <div class="col-md-12 mt-4">
                <span class="text-muted">Description:</span>
                <p class="value lead" id="text"></p>
            </div>


        </div>



                                                
        
        </div>
        <!-- <input id="eventID"/> -->
        <div class="modal-footer">
            <button type = "button" class = "btn btn-primary" data-bs-dismiss = "modal">Close</button>
        </div>
    </div>
</div>
</div>
