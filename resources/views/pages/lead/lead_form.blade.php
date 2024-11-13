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
                                <a class="nav-link" href="{{ url('lead/details/'.$data->id) }}">
                                    Lead Details
                                </a>
                            </li> 
                            
                            @foreach($forms as $key => $val)
                            <li class="nav-item">
                                <a class="nav-link {{ $form->id == $key ? 'active' : ''}}"  href="{{ url('lead/form/'.$data->id.'/'.$key) }}">
                                    {{ $val }}
                                </a>
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div class="tab-pane active" id="basic" role="tabpanel">



                            <div class="row">
                                <div class="col-md-12">
                                <div class="table-responsive">
                <table class="table table-bordered data-table" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>User</td>
                                            <td>Phone</td>
                                            <td>Emails</td>
                                            <td>Addresss</td>
                                        </tr>
                                        <tr>
                                            <td>{{$data->first_name}} {{$data->last_name}}</td>
                                            <td>{{$data->phone}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>{{$data->city}}, Pincode: {{$data->pincode}}</td>
                                        </tr>
                                    </tbody>
                                </table>
</div>

<div class="table-responsive">
                <table class="table table-bordered data-table" id="dataTable" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>Amount</td>
                                            <td>Stage</td>
                                            <td>Start Date</td>
                                            <td>Target End Date</td>
                                            <td>Lead Age</td>
                                            <td>Category</td>
                                            <td>Priority</td>
                                        </tr>
                                        <tr>
                                            <td>INR {{ $data->est_amount }}</td>
                                            <td>{{@$stages[$data->stage_id_fk]}}</td>
                                            <td>{{date('d M, Y', strtotime($data->created_at))}}</td>
                                            <td>{{date('d M, Y', strtotime($data->created_at.' + 45 days'))}}</td>
                                            <td>{{ round((time() - strtotime($data->created_at)) / (60 * 60 * 24)) }} Days</td>
                                            <td>{{$data->category}}</td>
                                            <td>{{$data->priority}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>

                                </div>
                            </div>



                            <hr>

                            <div class="col-md-8 offset-md-2">
                            {{ Form::open(array('url'=>'/lead/form-answer/store'))}}
                             
                                @csrf

                                {{ Form::hidden('lead_id', $data->id)}}
                                {{ Form::hidden('form_id', $form->id)}}
                            
                                @foreach($questions as $key => $question)
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label>Question {{$key+1}}:   {{$question->title}} </label> <br>

                                        @if($question->type == 'text')
                                            {{ Form::text('answer_'.$question->id, !empty($answers) && !empty(@$answers[$question->id]) ? @$answers[$question->id] : '', ['class'=>'form-control', 'placeholder'=>'Enter Answer']) }}
                                        @elseif ($question->type == 'radio')

                                            @php $options = explode(' || ', $question->description) @endphp

                                            @foreach($options as $option)
                                                {{ Form::radio('answer_'.$question->id, $option, !empty($answers) && !empty(@$answers[$question->id]) && @$answers[$question->id] == $option ? true : '') }} {{$option}} &nbsp; &nbsp; &nbsp;
                                            @endforeach

                                        @elseif ($question->type == 'checkbox')
                                            @php $options = explode(' || ', $question->description); $answers_array = explode(' || ', @$answers[$question->id]); @endphp

                                            @foreach($options as $option)
                                                {{ Form::checkbox('answer_'.$question->id.'[]', $option, !empty($answers) && !empty(@$answers[$question->id]) && in_array(@$option, $answers_array) ? 'checked' : '') }} {{$option}} &nbsp; &nbsp; &nbsp;
                                            @endforeach
                                        @endif
                                        
                                    </div>
                                </div>
                                @endforeach

                                {{ Form::submit(!empty($answers) ? 'Update Details' : 'Save Details',array('class'=>'btn btn-primary')) }}
                                {{ Form::close() }}
                                </div>

                    
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

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