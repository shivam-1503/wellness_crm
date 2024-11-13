@extends('layouts.app')

@section('content')

<style type="text/css">

.bs-vertical-wizard {
    border-right: 1px solid #eaecf1;
    padding-bottom: 50px;
}

.bs-vertical-wizard ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.bs-vertical-wizard ul>li {
    display: block;
    position: relative;
}

.bs-vertical-wizard ul>li>div {
    display: block;
    padding: 10px 10px 10px 40px;
    color: #333c4e;
    font-size: 17px;
    font-weight: 400;
    letter-spacing: .8px;
}


.bs-vertical-wizard ul>li>div:before {
    content: '';
    position: absolute;
    width: 1px;
    height: calc(100% - 25px);
    background-color: #bdc2ce;
    left: 13px;
    bottom: -9px;
    z-index: 3;
}

.bs-vertical-wizard ul>li>div .ico {
    pointer-events: none;
    font-size: 18px;
    position: absolute;
    left: 5px;
    top: 12px;
    z-index: 2;
}

.bs-vertical-wizard ul>li>div:after {
    content: '';
    position: absolute;
    border: 2px solid #bdc2ce;
    border-radius: 50%;
    top: 14px;
    left: 6px;
    width: 16px;
    height: 16px;
    z-index: 3;
}

.bs-vertical-wizard ul>li>div .desc {
    display: block;
    color: #78797c;
    font-size: 12px;
    /*font-weight: 400;*/
    line-height: 1.8;
    height: auto !important;
    letter-spacing: .8px;
    padding: 10px;
    background-color: #fff9dd;
    margin-bottom: 8px;
    border-radius: 10px;
}

.bs-vertical-wizard ul>li.complete>div:before {
    background-color: #5cb85c;
    opacity: 1;
    height: calc(100% - 25px);
    bottom: -9px;
}

.bs-vertical-wizard ul>li.complete>div:after {display:none;}

.bs-vertical-wizard ul>li>div .ico.ico-green {
    color: #5cb85c;
}


.bs-vertical-wizard ul>li>a {
    display: block;
    padding: 10px 10px 10px 40px;
    color: #333c4e;
    font-size: 17px;
    font-weight: 400;
    letter-spacing: .8px;
}

.bs-vertical-wizard ul>li>a:before {
    content: '';
    position: absolute;
    width: 1px;
    height: calc(100% - 25px);
    background-color: #bdc2ce;
    left: 13px;
    bottom: -9px;
    z-index: 3;
}

.bs-vertical-wizard ul>li>a .ico {
    pointer-events: none;
    font-size: 14px;
    position: absolute;
    left: 10px;
    top: 15px;
    z-index: 2;
}

.bs-vertical-wizard ul>li>a:after {
    content: '';
    position: absolute;
    border: 2px solid #bdc2ce;
    border-radius: 50%;
    top: 14px;
    left: 6px;
    width: 16px;
    height: 16px;
    z-index: 3;
}

.bs-vertical-wizard ul>li>a .desc {
    display: block;
    color: #bdc2ce;
    font-size: 11px;
    font-weight: 400;
    line-height: 1.8;
    letter-spacing: .8px;
    height: auto !important;
}

.bs-vertical-wizard ul>li.complete>a:before {
    background-color: #5cb85c;
    opacity: 1;
    height: calc(100% - 25px);
    bottom: -9px;
}

.bs-vertical-wizard ul>li.complete>a:after {display:none;}
.bs-vertical-wizard ul>li.locked>a:after {display:none;}
.bs-vertical-wizard ul>li:last-child>a:before {display:none;}

.bs-vertical-wizard ul>li.complete>a .ico {
    left: 8px;
}

.bs-vertical-wizard ul>li>a .ico.ico-green {
    color: #5cb85c;
}

.bs-vertical-wizard ul>li>a .ico.ico-muted {
    color: #bdc2ce;
}

.bs-vertical-wizard ul>li.current {
    background-color: #fff;
}

.bs-vertical-wizard ul>li.current>a:before {
    background-color: #ffe357;
    opacity: 1;
}

.bs-vertical-wizard ul>li.current>a:after {
    border-color: #ffe357;
    background-color: #ffe357;
    opacity: 1;
}

.bs-vertical-wizard ul>li.current:after, .bs-vertical-wizard ul>li.current:before {
    left: 100%;
    top: 50%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}

.bs-vertical-wizard ul>li.current:after {
    border-color: rgba(255,255,255,0);
    border-left-color: #fff;
    border-width: 10px;
    margin-top: -10px;
}

.bs-vertical-wizard ul>li.current:before {
    border-color: rgba(234,236,241,0);
    border-left-color: #eaecf1;
    border-width: 11px;
    margin-top: -11px;
}

</style>


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
        box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.3);
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
        padding: 10px 20px;
        line-height: 1.5;
    }

    .nav-tabs>.nav-item>.nav-link:hover {
        background-color: transparent;
    }

    .nav-tabs>.nav-item>.nav-link.active {
        /* background-color: #444; */
        background: linear-gradient(to bottom right, #9e88f5 0%, #6259ca 100%);
        border-radius: 30px;
        color: #FFF;
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



<style type="text/css">
    p {
        margin-bottom: 7px;
    }

    .green {
        color: green;
        font-size: 14px;
    }

</style>

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Lead <small>View & Confirm</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lead Details</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="{{url('leads')}}"> <i class="fa fa-arrow-left"></i> All Lead</a>
    </div>

</div>
<!-- PAGE-HEADER END -->

    <div class="content mt-3">


    @if($message = Session::get("success"))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Greate Job!</strong> {{$message}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    

        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">

                
                <!-- Nav tabs -->
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ url('lead/details/'.$data->id) }}">
                                    Lead Details
                                </a>
                            </li> 
                            
                            @foreach($forms as $key => $form)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('lead/form/'.$data->id.'/'.$key) }}">
                                    {{ $form }}
                                </a>
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content">

                            {{-- Basic Details Form --}}
                            <div class="tab-pane active" id="basic" role="tabpanel">

                                @php
                                    $user_types = ['1'=>'Nivesh Consultant', '2'=>'RM', '3'=>'CRM', '4'=>'Sales Director'];
                                    $icons = array('1'=>'fa-clock-o', '2'=>'fa-phone', '3'=>'fa-handshake-o', '4'=>'fa-handshake-o', '5'=>'fa-handshake-o');
                                @endphp

                                <style>
                                    .title {
                                        
                                        line-height: 30px;
                                        font-size: 14px;
                                        margin-bottom: 13px;
                                        clear: both;
                                    }

                                    .title .value {
                                        float: right;
                                    }
                                </style>
                                <div class="row">
                                    <div class="col-sm-5">

                                        <div class="card mt-5">
                                            <div class="card-body">
                                                <h4>About User</h4>
                                                
                                                <div class="title">
                                                    <span class="text-muted">User Name:</span>
                                                    <span class="value">{{$data->first_name.' '.$data->last_name}}</span>
                                                </div>

                                                <div class="title">
                                                    <span class="text-muted">Phone</span>
                                                    <span class="value">{{ $data->phone }}</span>
                                                </div>

                                                <div class="title">
                                                    <span class="text-muted">Email</span>
                                                    <span class="value">{{ strtolower($data->email) }}</span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card mt-5">
                                            <div class="card-body">
                                                <h4>About Project</h4>
                                                
                                                <div class="title">
                                                    <span class="text-muted">Project:</span>
                                                    <span class="value">{{$data->service ? $data->service->title : '' }}</span>
                                                </div>

                                            </div>
                                        </div>

                                        


                                        <div class="card mt-3">
                                            
                                            <div class="card-body">
                                                <h4>About Deal: {{$data->name}}</h4>

                                                <div class="title">
                                                    <span class="text-muted">Amount</span>
                                                    <span class="value">INR {{ $data->est_amount }}</span>
                                                </div>
                                                <div class="title">
                                                    <span class="text-muted">Stage</span>
                                                    <span class=" value badge bg-primary">{{@$stages[$data->stage_id_fk]}}</span>
                                                </div>
                                                <div class="title">
                                                    <span class="text-muted">Start Date</span>
                                                    <span class="value">{{date('d M, Y', strtotime($data->created_at))}}</span>
                                                </div>
                                                <div class="title">
                                                    <span class="text-muted">Target End Date</span>
                                                    <span class="value">{{date('d M, Y', strtotime($data->created_at.' + 45 days'))}}</span>
                                                </div>
                                                <div class="title">
                                                    <span class="text-muted">Lead Age</span>
                                                    <span class="value">{{ round((time() - strtotime($data->created_at)) / (60 * 60 * 24)) }} Days</span>
                                                </div>

                                                <div class="title">
                                                    <span class="text-muted">Source</span>
                                                    <span class="value">{{@$sources[$data->source_id_fk]}}</span>
                                                </div>

                                                <div class="title">
                                                    <span class="text-muted">Category</span>
                                                    <span class="value  badge bg-primary">{{$data->category}}</span>
                                                </div>

                                                <div class="title">
                                                    <span class="text-muted">Priority</span>
                                                    <span class="value  badge bg-danger">{{$data->priority}}</span>
                                                </div>

                                                <span class="text-muted">Description</span>
                                                <p>{{$data->description}}</p>
                                            </div>
                                        </div>

                                        <div class="card mt-5">
                                            <div class="card-body">
                                                <h4>Remarks</h4>
                                                <p>{{$data->remarks}}</p>
                                            </div>
                                        </div>


                                        <div class="card mt-5">
                                            <div class="card-body">
                                                <h4>More Actions</h4>
                                                @if($data->stage_id_fk != 99)
                                                <a href="javascript:void(0)" title="Mark Dead" class="btn btn-primary btn-sm" id="markDead"><i class="fa fa-edit"></i> Mark this lead Dead</a>
                                                @else
                                                    <span class="value badge bg-danger">Lead has been marked dead on {{ date('d M, Y H:i', strtotime($data->updated_at))}}</span>
                                                @endif

                                                <button type="button" onclick="show_receipt({{$data->id}})" title="Download" class="btn btn-primary btn-sm"><i class="fas fa-receipt"></i> Download Communication</button>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-7 side-content">
                                        
                                        @if($data->stage_id_fk != 99)
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
                                            <li class="nav-item">
                                                <a class="nav-link" id="six-tab" data-bs-toggle="tab" href="#six" role="tab" aria-controls="Six" aria-selected="false">Review</a>
                                            </li>


                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content" id="myTabContent">
                                            
                                            <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                                                {{ Form::open(array('url'=>'/lead/comment/store'))}}
                                                    @csrf
                                                    {{ Form::hidden('lead_id_fk', $data->id)}}
                                                    <div class="form-group">
                                                        {{Form::textarea('comment','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Leave Your Comment', 'rows'=>'3'])}}
                                                    </div>

                                                    
                                                    <div class="form-group">
                                                        {{ Form::select('stage_id_fk', $stages, '', ['class'=>'standardSelect form-control', 'title'=>'Select Stage', 'data-live-search'=>'true', 'id'=>'stage_id_fk' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                                                    </div>

                                                    <div class="form-group">
                                                        {{ Form::select('priority', $priorities, '', ['class'=>'standardSelect form-control', 'title'=>'Select Lead Priority', 'data-live-search'=>'true', 'id'=>'priority', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                                                    </div>
                                                    
                                                    
                                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                                {{ Form::close() }}
                                            </div>

                                            <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                                                {{ Form::open(array('url'=>'/lead/waiting/store'))}}
                                                    @csrf
                                                    {{ Form::hidden('lead_id_fk', $data->id)}}
                                                    <div class="form-group">
                                                        <span class="text-muted">Select Next Date to Connect:</span>
                                                        {{ Form::date('waiting_days','',['class'=>'form-control', 'id'=>'waiting_days']) }}

                                                    </div>

                                                    <div class="form-group">
                                                        {{Form::textarea('description','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Put description here', 'rows'=>'3'])}}
                                                    </div>

                                                    <div class="form-group">
                                                        {{ Form::select('priority', $priorities, '', ['class'=>'standardSelect form-control', 'title'=>'Select Task Priority', 'data-live-search'=>'true', 'id'=>'priority', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                                                    </div>

                                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                                {{ Form::close() }}
                                            </div>

                                            <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
                                                {{ Form::open(array('url'=>'/lead/call/store'))}}
                                                    @csrf
                                                    {{ Form::hidden('lead_id_fk', $data->id)}}
                                                

                                                    <div class="input-group mb-3">
                                                        {{ Form::date('call_date','',['class'=>'form-control', 'id'=>"call_date"]) }}

                                                        {{ Form::time('call_time','',['class'=>'form-control', 'id'=>"call_time"]) }}
                                                    </div>

                                                    <div class="form-group">
                                                        {{Form::textarea('description','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Put description here', 'rows'=>'3'])}}
                                                    </div>

                                                    <div class="form-group">
                                                        {{ Form::select('priority', $priorities, '', ['class'=>'standardSelect form-control', 'title'=>'Select Task Priority', 'data-live-search'=>'true', 'id'=>'priority', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                                                    </div>

                                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                                {{ Form::close() }}
                                            </div>


                                            <div class="tab-pane fade p-3" id="four" role="tabpanel" aria-labelledby="four-tab">
                                                {{ Form::open(array('url'=>'/lead/meeting/store'))}}
                                                    @csrf
                                                    {{ Form::hidden('lead_id_fk', $data->id)}}
                                                    
                                                    <div class="input-group mb-3">
                                                        {{ Form::date('meeting_date','',['class'=>'form-control', 'id'=>"meeting_date"]) }}

                                                        {{ Form::time('meeting_time','',['class'=>'form-control', 'id'=>"meeting_time"]) }}
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::select('user_id', [''=>'Select User']+$users, '', ['class'=>'standardSelect form-control', 'title'=>'Select User', 'data-live-search'=>'true', 'id'=>'user_id' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::select('act_slot', ['30 Mins'=>'30 Mins', '1 Hour' => '1 Hour'], '', ['class'=>'standardSelect form-control', 'title'=>'Select Slot', 'data-live-search'=>'true', 'id'=>'act_slot' , 'data-style'=>'btn-sp', 'data-dropup-auto'=>'false', 'data-size'=>'5']) !!}
                                                    </div>

                                                    

                                                    <div class="form-group">
                                                        {{ Form::text('location','',['class'=>'form-control', 'placeholder'=>'Location']) }}
                                                    </div>

                                                    <div class="form-group">
                                                        {{Form::textarea('description','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Put description here', 'rows'=>'3'])}}
                                                    </div>

                                                    <div class="form-group">
                                                        {{ Form::select('priority', $priorities, '', ['class'=>'standardSelect form-control', 'title'=>'Select Task Priority', 'data-live-search'=>'true', 'id'=>'priority', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                                                    </div>

                                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                                {{ Form::close() }}
                                            </div>
                                            
                                            <div class="tab-pane fade p-3" id="six" role="tabpanel" aria-labelledby="six-tab">
                                                {{ Form::open(array('url'=>'/lead/review/store'))}}
                                                    @csrf
                                                    {{ Form::hidden('lead_id_fk', $data->id)}}
                                                    <div class="form-group">
                                                        <span class="text-muted">Select Review:</span>
                                                        {{ Form::date('waiting_days','',['class'=>'form-control', 'id'=>'waiting_days']) }}

                                                    </div>

                                                    <div class="form-group">
                                                        {{Form::textarea('description','', ['class'=>'form-control', 'required'=>'','placeholder'=>'Put description here', 'rows'=>'3'])}}
                                                    </div>

                                                    <div class="form-group">
                                                        {{ Form::select('priority', $priorities, '', ['class'=>'standardSelect form-control', 'title'=>'Select Task Priority', 'data-live-search'=>'true', 'id'=>'priority', 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                                                    </div>

                                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                                {{ Form::close() }}
                                            </div>

                                        </div>

                                        <hr>
                                        @endif

                                        <div class="bs-vertical-wizard">
                                            <ul>
                                                <li class="complete">
                                                    <div>Comments <i class="ico fa fa-comments ico-green"></i>
                                                        @foreach($comments as $row)
                                                        <div class="desc">
                                                            <p>
                                                                <strong class="green"><i class="fa fa-comments"></i>&nbsp;&nbsp; Comment</strong>

                                                                <small><span class="float-right">{{date('d M, Y H:i', strtotime($row->created_at))}}</span></small>
                                                            </p>
                                                            <p>{{$row->comment}} <span class="float-right"><small><em> - By {{$row->user->name}}</em></small></span></p>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </li>


                                                <li class="complete">

                                                    <div>Planned Activity <i class="ico fa fa-paper-plane ico-green"></i>
                                                        @foreach($lead_acts as $act)
                                                        <div class="desc">
                                                            <p>
                                                                <strong class="green"><i class="fa {{$icons[$act->activity_type]}}"></i>&nbsp;&nbsp;{{$act_types[$act->activity_type]}}</strong>

                                                                <small><span class="float-right">{{date('d M, Y H:i', strtotime($act->created_at))}} </span></small>
                                                            </p>

                                                            @if($act->activity_type == 1) 

                                                                <p>Next Date to Connect with: {{$act->waiting_days}}</p>

                                                            @elseif($act->activity_type == 2)
                                                            
                                                                <p>Call Time: {{ date('d M, Y H:i', strtotime($act->act_time))}}</p>                    

                                                            @elseif($act->activity_type == 3)
                                                                <p>Meeting Time: {{ date('d M, Y H:i', strtotime($act->act_time))}}</p>
                                                                
                                                                <p>Meeting With: {{ $act->activity_user ? $act->activity_user->name : "NA"}}

                                                                <p>Meeting Location: {{ $act->location }}

                                                                <p>Meeting Slot: {{ $act->act_slot }}
                                                            @else
                                                                <!-- No Comments -->
                                                            @endif

                                                            <p>{{$act->description}} <span class="float-right"><small><em> - By {{$act->user->name}}</em></small></span></p>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </li>


                                                {{--
                                                <li class="complete prev-step">
                                                    <a href="#">Details <i class="ico fa fa-check ico-green"></i>
                                                        <span class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, cumque.</span>
                                                    </a>
                                                </li>
                                                <li class="current">
                                                    <a href="#">Meta
                                                        <span class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, cumque.</span>
                                                    </a>
                                                </li>
                                                --}}
                                            </ul>
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


        <!-- Invoice Modal Starts -->
        <div class="modal fade" tabindex="-1" role="dialog" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Receipt</h5>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        <a  href="#" class="btn btn-primary download_link"><i class="fa fa-file-pdf"></i> &nbsp; Download PDF</a>
                    </div>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice Modal Ends -->



@endsection


@section('scripting')



<script type="text/javascript">

   $(document).ready(function() {

        $(".standardSelect").selectpicker();

        // $("#call_time").datetimepicker();
        // $("#meeting_time").datetimepicker();

        // $('#meeting_time').datetimepicker('show');

       
        $('body').on('click', '#markDead', function(e) {

            var product_id = {{ $data->id }};

            swal({
                title: "Are you sure?",
                text: "You want to make this lead dead!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        type: "GET",
                        url: "{{ url('lead/delete') }}"+'/'+product_id,
                        success: function (data) {
                            // table.draw();
                            swal("Great! Category has been deleted!", {
                              icon: "success",
                            });
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
                else
                {
                    swal("Your category delete request Cancelled!")
                }

            });

        });

   });



   function show_receipt(lead_id)
    {
        var id = lead_id;
        $.ajax({
            type : 'GET',
            url : '{{ url("generate-lead-details") }}?e='+id,

            success: function(result, url) {

                var link =  '{{ url("generate-lead-details") }}?e='+id;
                $("a.download_link").attr("href", link + '&export=pdf');

                $('.modal-title').html("Lead Details Report");
                $('.modal-body').html(result);
                $('#myModal').modal('show');

                $('.modal-container').load($(this).data('path'),function(result){
                    $('#myModal').modal({show:true});
                });
            }
        });
    }



</script>



@endsection