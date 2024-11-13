<!DOCTYPE html>
<html>
    <head>
        <title>EMI Invoice</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <!-- <link rel="stylesheet" href="{{ asset('backend_assets/custom/css/invoice_1.css') }}"> -->

        <style>

            @import url("https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900");
            
            * {
                margin: 0;
                box-sizing: border-box;
                -webkit-print-color-adjust: exact;
            }

            body {
                background: #FFF;
                font-family: 'Roboto', sans-serif;
            }

            ::selection {
                background: #f31544;
                color: #FFF;
            }

            ::moz-selection {
                background: #f31544;
                color: #FFF;
            }

            .clearfix::after {
                content: "";
                clear: both;
                display: table;
            }

            .col-left {
                float: left;
            }

            .col-left p {
                font-size: .9em;
                color: #666;
                margin-bottom: .5em;
            }

            .col-right {
                float: right;
            }

            h1 {
                font-size: 1.5em;
                color: #444;
            }

            h2 {
                font-size: 1em;
            }

            h3 {
                font-size: 1.2em;
                font-weight: 300;
                line-height: 2em;
            }

            p {
                font-size: .85em;
                color: #666;
                line-height: 1.3em;
            }

            a {
                text-decoration: none;
                color: #00a63f;
            }

            #invoiceholder {
                width: 100%;
                height: 100%;
                padding: 0;
            }

            #invoice {
                position: relative;
                margin: 0 auto;
                width: 740px;
                padding: 30px 0;
                background: #FFF;
            }

            [id*='invoice-'] {
                /* Targets all id with 'col-' */
                /*  border-bottom: 1px solid #EEE;*/
                padding: 20px;
            }

            #invoice-top {
                border-bottom: 2px solid #00a63f;
            }

            #invoice-mid {
                min-height: 110px;
            }

            #invoice-bot {
                min-height: 240px;
                margin-bottom: 40px;
            }

            table {
                width: 100%
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            table, th, td, tr {
                border: 1px solid;
                border-collapse: collapse;
            }


            
            .info {
                display: inline-block;
                vertical-align: middle;
                margin-left: 20px;
            }

            
            


            h2 {
                margin-bottom: 12px;
                color: #444;
            }

            /* .col-right td {
                color: #666;
                padding: 5px 8px;
                border: 0;
                font-size: 0.85em;
                border-bottom: 1px solid #eeeeee;
            } */


            /* .col-right td {
                text-align:right
            } */
            .col-right td span:first-child {
                float:left;
            }

            /* .table-invoice {
                width: 100%;
                border-collapse: collapse;
            } */

            .table-main td {
                padding: 5px;
                border-bottom: 1px solid #cccaca;
                font-size: 0.8em;
                text-align: center;
            }


            

            .table-main th {
                font-size: 0.8em;
                text-align: center;
                padding: 5px 10px;
            }

            .item {
                width: 50%;
            }

            .list-item td {
                text-align: center;
            }

            
             .table-main {
                width: 100%;
                border-collapse: collapse;
            }
            
            
            
        </style>

    </head>

    <body>

    @php
        $act_types = array('1' => 'Waiting', '2'=>'Call', '3'=>'Meeting', '4'=>'Site Visit', '5'=>'Review');
        $lead = $data['lead_data'];
        $lead_acts = $data['lead_acts'];
        $comments = $data['comments'];
        $stages = $data['stages'];
        $sources = $data['sources'];
        $users = $data['users'];
        $assignments = $data['assignments'];
        $nice_answers = $data['nice_answers'];
        $bant_answers = $data['bant_answers'];
    @endphp

    <div id="invoiceholder">
            <div id="invoice">
                <div id="invoice-top">
                    <div class="title">
                        <h1>#<span class="invoiceVal invoice_num">{{$lead->title}}</span></h1>
                        
                    </div>
                    <!--End Title-->
                </div>
                <!--End InvoiceTop-->

                
                <div id="invoice-mid">
                    <div class="clearfix">
                        <div class="col-left">
                            <div class="clientinfo">
                                <h2 id="supplier">
                                    <strong>{{ $lead->first_name.' '.$lead->last_name }}</strong>
                                </h2>
                                
                                <p id="address">Phone: {{ $lead->phone }}</p>
                                <p id="address">Address: {{ $lead->address }}</p>
                                <p id="city">City: {{ $lead->city }}</p>
                                <p id="country">Pincode: {{ $lead->pincode }}</p>
                                
                            </div>


                                
                        </div>
                        <div class="col-right">
                            <table class="table" colspacing="2" border="1">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span>Project: </span>
                                        </td>
                                        <td>
                                            <strong>{{ $lead->project ? $lead->project->title : "" }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>Property:  </span>
                                        </td>
                                        <td>
                                            <strong>{{ $lead->property ? $lead->property->title : "" }} </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!--End Invoice Mid-->
                <div id="invoice-bot">

                    <table class="table-main">
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
                                <td>INR {{ $lead->est_amount }}</td>
                                <td>{{@$stages[$lead->stage_id_fk]}}</td>
                                <td>{{date('d M, Y', strtotime($lead->created_at))}}</td>
                                <td>{{date('d M, Y', strtotime($lead->created_at.' + 45 days'))}}</td>
                                <td>{{ round((time() - strtotime($lead->created_at)) / (60 * 60 * 24)) }} Days</td>
                                <td>{{$lead->category}}</td>
                                <td>{{$lead->priority}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table-main">
                        <tbody>
                            <tr>
                                <td>Description: {{ $lead->description }}</td>
                            </tr>
                            <tr>
                                <td>Remarks: {{ $lead->remarks }}</td>
                            </tr>
                        </tbody>
                    </table>
                    


                    <div id="table-invoice">
                        <h4>Planned Events</h4>
                        <table class="table-main">
                            <thead>
                                <tr class="tabletitle">
                                    <th>Sr</th>
                                    <th>Activity</th>
                                    <th>Description</th>
                                    <th width="18%" align="right">Date</th>
                                </tr>
                            </thead>
                            @if(count($lead_acts) > 0)
                                @foreach($lead_acts as $key=>$act)
                                <tr class="list-item">
                                    <td data-label="Sr" class="tableitem">{{$key+1}}</td>
                                    <td data-label="Description" class="tableitem">
                                        {{ @$act_types[$act->activity_type]}}
                                    </td>
                                    <td data-label="Description" class="tableitem">
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

                                        <p>{{$act->description}} <span class="float-right"><em> - By {{$act->user->name}}</em></span></p>
                                    </td>
                                    <td data-label="Tax Code" class="tableitem"><p>{{ date('d M, Y H:i', strtotime($act->created_at)) }}</p></td>
                                </tr>
                                @endforeach
                            @else
                                <tr class="list-item">                                    
                                    <td class="tableitem" colspan="4"><p><em>No Planned Events Found!<em></p></td>
                                </tr>
                            @endif
                            
                        </table>
                    </div>


                    <div id="table-invoice">
                        <h4>Lead Comments</h4>
                        <table class="table-main">
                            <thead>
                                <tr class="tabletitle">
                                    <th>Sr</th>
                                    <th>Comment</th>
                                    <th>Stage</th>
                                    <th>Priority</th>
                                    <th width="18%" align="right">Date</th>
                                </tr>
                            </thead>
                            @if(count($lead_acts) > 0)
                                @foreach($comments as $key=>$comment)
                                <tr class="list-item">
                                    <td data-label="Sr" class="tableitem">{{$key+1}}</td>
                                    <td data-label="Description" class="tableitem">
                                        <p>{{$comment->comment}}<span class="float-right"><small><em> - By {{$comment->user->name}}</em></small></span> </p>
                                    </td>
                                    <td data-label="Description" class="tableitem">
                                        <p> {{@$stages[$comment->new_stage]}} </p>
                                    </td>
                                    <td data-label="Description" class="tableitem">
                                        <p> {{$comment->priority}} </p>
                                    </td>
                                    <td data-label="Tax Code" class="tableitem">
                                        <p>{{ date('d M, Y H:i', strtotime($comment->created_at)) }}</p>
                                    </td>
                                </tr>

                                @endforeach

                            @else
                                <tr class="list-item">                                    
                                    <td class="tableitem" colspan="4"><em>No Comments Found!<em></td>
                                </tr>
                            @endif
                            
                        </table>
                    </div>


                    @php $user_types = [1=>'NC', '2'=>'RM', 3=>'CRM', 4=>'Sales Director']; @endphp
                    <div id="table-invoice">
                        <h4>Lead Assinment History</h4>
                        <table class="table-main">
                            <thead>
                                <tr class="tabletitle">
                                    <th>Sr</th>
                                    <th>User Type</th>
                                    <th>User</th>
                                    <th>Remarks</th>
                                    <th width="18%" align="right">Date</th>
                                </tr>
                            </thead>
                            @foreach($assignments as $key=>$obj)
                            <tr class="list-item">
                                <td data-label="Sr" class="tableitem">{{$key+1}}</td>
                                <td data-label="Description" class="tableitem">
                                    {{@$user_types[$obj->user_type]}} @if(!is_null($obj->is_sarthi)) Sarthi @endif
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{@$users[$obj->user_id]}}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{$obj->remarks}}
                                </td>
                                <td data-label="Tax Code" class="tableitem">{{ date('d M, Y H:i', strtotime($obj->created_at)) }}</td>
                            </tr>

                            @endforeach
                            
                        </table>
                    </div>



                    <hr>
                    <div id="table-invoice">
                        <h4>NICE Form Details:</h4>
                        @foreach($nice_answers as $key => $obj)
                        
                        <p>Question {{$key+1}}: {{@$obj->question->title}}</p>
                        <p style="margin-bottom: 20px;">Answer: {{$obj->answer}}</p>


                        @endforeach

                    </div>

                    <hr>
                    <div id="table-invoice">
                        <h4>BANT Form Details:</h4>
                        @foreach($bant_answers as $key => $obj)
                        
                        <p>Question {{$key+1}}: {{@$obj->question->title}}</p>
                        <p style="margin-bottom: 20px;">Answer: {{$obj->answer}}</p>


                        @endforeach

                    </div>
                    
                </div>
                <!--End InvoiceBot-->
                <footer class="footer-invoice">
                    
                </footer>
            </div>
            <!--End Invoice-->
        </div>
        <!-- End Invoice Holder-->
    </body>

</html>
