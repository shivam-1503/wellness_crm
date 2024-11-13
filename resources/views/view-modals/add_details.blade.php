@php $statuses = [1=>'Active', 0=>'Inactive']; @endphp


<style>
    a {
        color: #f96332;
    }

    a:hover,
    a:focus {
        color: #f96332;
    }

    p {
        line-height: 1.61em;
        font-weight: 300;
        font-size: 1.2em;
    }

    .category {
        text-transform: capitalize;
        font-weight: 700;
        color: #9A9A9A;
    }

    body {
        color: #2c2c2c;
        font-size: 14px;
        font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
        overflow-x: hidden;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
    }

    .nav-item .nav-link,
    .nav-tabs .nav-link {
        -webkit-transition: all 300ms ease 0s;
        -moz-transition: all 300ms ease 0s;
        -o-transition: all 300ms ease 0s;
        -ms-transition: all 300ms ease 0s;
        transition: all 300ms ease 0s;
    }

    .card a {
        -webkit-transition: all 150ms ease 0s;
        -moz-transition: all 150ms ease 0s;
        -o-transition: all 150ms ease 0s;
        -ms-transition: all 150ms ease 0s;
        transition: all 150ms ease 0s;
    }


    .nav-tabs {
        border: 0;
        margin: 15px 0.7rem;
    }

    .nav-tabs:not(.nav-tabs-neutral)>.nav-item>.nav-link.active {
        box-shadow: 0px 5px 35px 0px rgba(0, 0, 0, 0.3);
    }

    .card .nav-tabs {
        border-top-right-radius: 0.1875rem;
        border-top-left-radius: 0.1875rem;
    }

    .nav-tabs>.nav-item>.nav-link {
        color: #888888;
        margin: 0;
        margin-right: 5px;
        background-color: transparent;
        border: 1px solid transparent;
        border-radius: 30px;
        font-size: 14px;
        padding: 11px 30px;
        line-height: 1.5;
    }

    .nav-tabs>.nav-item>.nav-link:hover {
        background-color: transparent;
    }

    .nav-tabs>.nav-item>.nav-link.active {
        background-color: #444;
        border-radius: 30px;
        color: #ccc;
    }

    .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
        font-size: 14px;
        position: relative;
        top: 1px;
        margin-right: 3px;
    }

    .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
        color: #FFFFFF;
    }

    .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: #FFFFFF;
    }

    .card {
        border: 0;
        border-radius: 0.1875rem;
        display: inline-block;
        position: relative;
        width: 100%;
        /* margin-bottom: 30px; */
        box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
    }

    .card .card-header {
        background-color: transparent;
        border-bottom: 0;
        background-color: transparent;
        border-radius: 0;
        padding: 0;
    }

    .card[data-background-color="orange"] {
        background-color: #f96332;
    }

    .card[data-background-color="red"] {
        background-color: #FF3636;
    }

    .card[data-background-color="yellow"] {
        background-color: #FFB236;
    }

    .card[data-background-color="blue"] {
        background-color: #2CA8FF;
    }

    .card[data-background-color="green"] {
        background-color: #15b60d;
    }

    [data-background-color="orange"] {
        background-color: #e95e38;
    }

    [data-background-color="black"] {
        background-color: #2c2c2c;
    }

    [data-background-color]:not([data-background-color="gray"]) {
        color: #FFFFFF;
    }

    [data-background-color]:not([data-background-color="gray"]) p {
        color: #FFFFFF;
    }

    [data-background-color]:not([data-background-color="gray"]) a:not(.btn):not(.dropdown-item) {
        color: #FFFFFF;
    }

    [data-background-color]:not([data-background-color="gray"]) .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
        color: #FFFFFF;
    }



    footer {
        margin-top: 50px;
        color: #555;
        background: #fff;
        padding: 25px;
        font-weight: 300;
        background: #f7f7f7;

    }

    .footer p {
        margin-bottom: 0;
    }

    footer p a {
        color: #555;
        font-weight: 400;
    }

    footer p a:hover {
        color: #e86c42;
    }

    @media screen and (max-width: 768px) {

        .nav-tabs {
            display: inline-block;
            width: 100%;
            padding-left: 100px;
            padding-right: 100px;
            text-align: center;
        }

        .nav-tabs .nav-item>.nav-link {
            margin-bottom: 5px;
        }
    }
</style>

<div class="modal fade" id="addDetailsModel"  data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center" style="margin-top: -30px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                        <h4 class="card-title" id="modelHeading">Add Details, Calls and Meetings</h4>
                    </div>
                </div>
                
                <div class="modal-body">


                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-primary">Customer Name</label>
                            <h5><span id="customer_name"></span></h5> 
                        </div>
                        <div class="col-md-6 text-end">
                            <label class="text-primary">EMI Amount</label>
                            <h5><span id="customer_emi_amount"></span></h5> 
                        </div>
                    </div>

                    <hr>


                        <div class="tab-content">

                            {{-- Basic Details Form --}}
                            <div class="tab-pane active" id="basic" role="tabpanel">

                                @php
                                    $act_types = array('1' => 'Waiting', '2'=>'Call', '3'=>'Meeting');
                                    $icons = array('1'=>'fa-clock-o', '2'=>'fa-phone', '3'=>'fa-handshake-o');
                                @endphp

                                <div class="row">
                                    <div class="col-sm-12 side-content">
                                        <ul class="nav nav-tabs mt-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="one-tab" data-bs-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Comment</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="two-tab" data-bs-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Wait</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="three-tab" data-bs-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">Call</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="four-tab" data-bs-toggle="tab" href="#four" role="tab" aria-controls="Four" aria-selected="false">Meeting</a>
                                            </li>

                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                                                {!! Form::open(['id' => 'commentForm', 'name' => 'dataForm', 'class'=>'form-horizontal']) !!}
                                                    @csrf
                                                    {{ Form::hidden('emi_id', '', ['class'=>'emi_id'])}}
                                                    <div class="form-group">
                                                        {{Form::textarea('comment','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Leave Your Comment', 'rows'=>'3'])}}
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                        
                                                        {{ Form::submit('Submit',array('class'=>'btn btn-primary', 'id'=>'commentBtn')) }}
                                                    </div>
                                                {{ Form::close() }}
                                            </div>

                                            <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                                                {!! Form::open(['id' => 'waitingForm', 'name' => 'dataForm', 'class'=>'form-horizontal']) !!}
                                                    @csrf
                                                    {{ Form::hidden('emi_id', '', ['class'=>'emi_id'])}}
                                                    <div class="form-group">
                                                        {{ Form::select('waiting_days',array('1'=>'1 Day','2'=>'2 Days'),'',['class'=>'form-control']) }}
                                                    </div>

                                                    <div class="form-group">
                                                        {{Form::textarea('description','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Put description here', 'rows'=>'3'])}}
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                        
                                                        {{ Form::submit('Submit',array('class'=>'btn btn-primary', 'id'=>'waitingBtn')) }}
                                                    </div>
                                                {{ Form::close() }}
                                            </div>

                                            <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
                                                {!! Form::open(['id' => 'callForm', 'name' => 'dataForm', 'class'=>'form-horizontal']) !!}
                                                    @csrf
                                                    {{ Form::hidden('emi_id', '', ['class'=>'emi_id'])}}
                                                    
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                {{ Form::date('call_time','',['class'=>'form-control', 'type'=>'date']) }}
                                                            </div>
                                                            <div class="col-sm-6">
                                                                {{ Form::text('call_with','',['class'=>'form-control', 'placeholder'=>'Name of Person']) }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        {{Form::textarea('description','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Put description here', 'rows'=>'3'])}}
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                        
                                                        {{ Form::submit('Submit',array('class'=>'btn btn-primary', 'id'=>'callBtn')) }}
                                                    </div>
                                                {{ Form::close() }}
                                            </div>


                                            <div class="tab-pane fade p-3" id="four" role="tabpanel" aria-labelledby="four-tab">
                                                {!! Form::open(['id' => 'meetingForm', 'name' => 'dataForm', 'class'=>'form-horizontal']) !!}
                                                    @csrf
                                                    {{ Form::hidden('emi_id', '', ['class'=>'emi_id'])}}
                                                    
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                {{ Form::date('meeting_time','',['class'=>'form-control', 'type'=>'date']) }}
                                                            </div>
                                                            <div class="col-sm-6">
                                                                {{ Form::text('meeting_with','',['class'=>'form-control', 'placeholder'=>'Name of Person']) }}
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        {{ Form::text('location','',['class'=>'form-control', 'placeholder'=>'Location']) }}
                                                    </div>

                                                    <div class="form-group">
                                                        {{Form::textarea('description','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Put description here', 'rows'=>'3'])}}
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                        {{ Form::submit('Submit',array('class'=>'btn btn-primary', 'id'=>'meetingBtn')) }}
                                                    </div>
                                                {{ Form::close() }}
                                            </div>

                                        </div>

                                        
                                    </div>


                                </div>
                            
                            </div>


                        </div>

                    </div>

        </div>
    </div>
    </div>
</div>
