<!DOCTYPE html>
<html>
<head>

<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid;
            padding: 5px;
        }

    </style>

</head>
<body>


    @php
        $act_types = array('1' => 'Waiting', '2'=>'Call', '3'=>'Meeting', '4'=>'Site Visit');
        $tasks = $data['task_data'];
        $task_names = $data['task_names'];
        $task_count = $data['task_count'];

        $waiting_tasks = $tasks[1];
        $call_tasks = $tasks[2];
        $meeting_tasks = $tasks[3];
        $site_visit_tasks = $tasks[4];
        $review_tasks = $tasks[5];        
    @endphp
    

    
    


    <div id="invoiceholder">
            <div id="invoice">
                <div id="invoice-top">
                    <div class="title">
                        <h1>Tasks Report | <span class="small">Date: <?php echo date('d M, Y'); ?></span></h1>
                        
                    </div>
                    <!--End Title-->
                </div>
                <!--End InvoiceTop-->

                <div class="card">
                    <div class="card-body text-center">
                        
                        <div id="chart">

                        </div> 

                    </div>
                </div>

                
                <div id="invoice-mid">
                    <div class="clearfix">
                        <div class="col-left">
                            


                                
                        </div>
                        <div class="col-right">
                            
                        </div>
                    </div>
                </div>


                <!--End Invoice Mid-->
                <div id="invoice-bot" style="margin-top: 20px;">

                <h4>Tasks Statistics: </h4>
                    <div id="table-invoice">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr class="tabletitle">
                                    <th class="border-bottom-0">Meeting Tasks</th>
                                    <th class="border-bottom-0">Site-visit Tasks</th>
                                    <th class="border-bottom-0">Call Tasks</th>
                                    <th class="border-bottom-0">Waiting Tasks</th>
                                    <th class="border-bottom-0">Review Tasks</th>
                                </tr>
                            </thead>

                            <tr class="list-item">
                                @foreach($task_count as $obj)
                                <td data-label="Description" class="tableitem">
                                    {{ $obj }}
                                </td>
                                @endforeach                              
                            </tr>
                            
                        </table>
                    </div>

                    <h4>Meeting Tasks: </h4>
                    <div id="table-invoice">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr class="tabletitle">
                                <th  width="20" class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">Title</th>
								<th class="border-bottom-0">Client</th>
								<th class="border-bottom-0">Managers</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0" style="max-width: 200px">Description</th>
								<th class="border-bottom-0">Priority</th>
								<th class="border-bottom-0">Status</th>
								<th class="border-bottom-0">Last Update</th>
                                </tr>
                            </thead>

                            @foreach($meeting_tasks as $key=>$task)
                            <tr class="list-item">
                                <td data-label="Sr" class="tableitem">{{$key+1}}</td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->title }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                {{ $task->lead ? $task->lead->first_name.' '.$task->lead->last_name.' | '.$task->lead->phone : "NA" }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    @php 
                                        if($task->lead){
                                            $txt = '';
                                            $txt .= "NC: ". ($task->lead->nc ? $task->lead->nc->name : "NA") ." | ";
                                            $txt .= "RM: ". ($task->lead->rm ? $task->lead->rm->name : "NA") ." | ";
                                            $txt .= "CRM: ". ($task->lead->crm ? $task->lead->crm->name : "NA") ." | ";
                                            $txt .= "SD: ". ($task->lead->head ? $task->lead->head->name : "NA") ." | ";
                                            echo rtrim($txt, ' | ');
                                        }
                                    @endphp
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ date('d M, Y h:i a', strtotime($task->start_date))  }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->description }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->priority }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->response_status == 0 ? "Pending" : "Completed"  }}
                                </td>
                                
                                
                                <td data-label="Tax Code" class="tableitem">{{ date('d M, Y H:i', strtotime($task->created_at)) }}</td>
                            </tr>

                            @endforeach
                            
                        </table>
                    </div>

                    <h4>Site Visit Tasks: </h4>
                    <div id="table-invoice">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="tabletitle">
                                <th  width="20" class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">Title</th>
								<th class="border-bottom-0">Client</th>
								<th class="border-bottom-0">Managers</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0" style="max-width: 200px">Description</th>
								<th class="border-bottom-0">Priority</th>
								<th class="border-bottom-0">Status</th>
								<th class="border-bottom-0">Last Update</th>
                                </tr>
                            </thead>

                            @foreach($site_visit_tasks as $key=>$task)
                            <tr class="list-item">
                                <td data-label="Sr" class="tableitem">{{$key+1}}</td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->title }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                {{ $task->lead ? $task->lead->first_name.' '.$task->lead->last_name.' | '.$task->lead->phone : "NA" }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    @php 
                                        if($task->lead){
                                            $txt = '';
                                            $txt .= "NC: ". ($task->lead->nc ? $task->lead->nc->name : "NA") ." | ";
                                            $txt .= "RM: ". ($task->lead->rm ? $task->lead->rm->name : "NA") ." | ";
                                            $txt .= "CRM: ". ($task->lead->crm ? $task->lead->crm->name : "NA") ." | ";
                                            $txt .= "SD: ". ($task->lead->head ? $task->lead->head->name : "NA") ." | ";
                                            echo rtrim($txt, ' | ');
                                        }
                                    @endphp
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ date('d M, Y h:i a', strtotime($task->start_date))  }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->description }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->priority }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->response_status == 0 ? "Pending" : "Completed"  }}
                                </td>
                                
                                
                                <td data-label="Tax Code" class="tableitem">{{ date('d M, Y H:i', strtotime($task->created_at)) }}</td>
                            </tr>

                            @endforeach
                            
                        </table>
                    </div>

                    <h4>Call Tasks: </h4>
                    <div id="table-invoice">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="tabletitle">
                                <th  width="20" class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">Title</th>
								<th class="border-bottom-0">Client</th>
								<th class="border-bottom-0">Managers</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0" style="max-width: 200px">Description</th>
								<th class="border-bottom-0">Priority</th>
								<th class="border-bottom-0">Status</th>
								<th class="border-bottom-0">Last Update</th>
                                </tr>
                            </thead>

                            @foreach($call_tasks as $key=>$task)
                            <tr class="list-item">
                                <td data-label="Sr" class="tableitem">{{$key+1}}</td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->title }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                {{ $task->lead ? $task->lead->first_name.' '.$task->lead->last_name.' | '.$task->lead->phone : "NA" }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    @php 
                                        if($task->lead){
                                            $txt = '';
                                            $txt .= "NC: ". ($task->lead->nc ? $task->lead->nc->name : "NA") ." | ";
                                            $txt .= "RM: ". ($task->lead->rm ? $task->lead->rm->name : "NA") ." | ";
                                            $txt .= "CRM: ". ($task->lead->crm ? $task->lead->crm->name : "NA") ." | ";
                                            $txt .= "SD: ". ($task->lead->head ? $task->lead->head->name : "NA") ." | ";
                                            echo rtrim($txt, ' | ');
                                        }
                                    @endphp
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ date('d M, Y h:i a', strtotime($task->start_date))  }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->description }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->priority }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->response_status == 0 ? "Pending" : "Completed"  }}
                                </td>
                                
                                
                                <td data-label="Tax Code" class="tableitem">{{ date('d M, Y H:i', strtotime($task->created_at)) }}</td>
                            </tr>

                            @endforeach
                            
                        </table>
                    </div>
                    
                    <h4>Waiting Tasks: </h4>
                    <div id="table-invoice">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="tabletitle">
                                <th  width="20" class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">Title</th>
								<th class="border-bottom-0">Client</th>
								<th class="border-bottom-0">Managers</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0" style="max-width: 200px">Description</th>
								<th class="border-bottom-0">Priority</th>
								<th class="border-bottom-0">Status</th>
								<th class="border-bottom-0">Last Update</th>
                                </tr>
                            </thead>

                            @foreach($waiting_tasks as $key=>$task)
                            <tr class="list-item">
                                <td data-label="Sr" class="tableitem">{{$key+1}}</td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->title }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                {{ $task->lead ? $task->lead->first_name.' '.$task->lead->last_name.' | '.$task->lead->phone : "NA" }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    @php 
                                        if($task->lead){
                                            $txt = '';
                                            $txt .= "NC: ". ($task->lead->nc ? $task->lead->nc->name : "NA") ." | ";
                                            $txt .= "RM: ". ($task->lead->rm ? $task->lead->rm->name : "NA") ." | ";
                                            $txt .= "CRM: ". ($task->lead->crm ? $task->lead->crm->name : "NA") ." | ";
                                            $txt .= "SD: ". ($task->lead->head ? $task->lead->head->name : "NA") ." | ";
                                            echo rtrim($txt, ' | ');
                                        }
                                    @endphp
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ date('d M, Y h:i a', strtotime($task->start_date))  }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->description }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->priority }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->response_status == 0 ? "Pending" : "Completed"  }}
                                </td>
                                
                                
                                <td data-label="Tax Code" class="tableitem">{{ date('d M, Y H:i', strtotime($task->created_at)) }}</td>
                            </tr>

                            @endforeach
                            
                        </table>
                    </div>

                    <h4>Review Tasks: </h4>
                    <div id="table-invoice">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="tabletitle">
                                <th  width="20" class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">Title</th>
								<th class="border-bottom-0">Client</th>
								<th class="border-bottom-0">Managers</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0" style="max-width: 200px">Description</th>
								<th class="border-bottom-0">Priority</th>
								<th class="border-bottom-0">Status</th>
								<th class="border-bottom-0">Last Update</th>
                                </tr>
                            </thead>

                            @foreach($review_tasks as $key=>$task)
                            <tr class="list-item">
                                <td data-label="Sr" class="tableitem">{{$key+1}}</td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->title }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                {{ $task->lead ? $task->lead->first_name.' '.$task->lead->last_name.' | '.$task->lead->phone : "NA" }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    @php 
                                        if($task->lead){
                                            $txt = '';
                                            $txt .= "NC: ". ($task->lead->nc ? $task->lead->nc->name : "NA") ." | ";
                                            $txt .= "RM: ". ($task->lead->rm ? $task->lead->rm->name : "NA") ." | ";
                                            $txt .= "CRM: ". ($task->lead->crm ? $task->lead->crm->name : "NA") ." | ";
                                            $txt .= "SD: ". ($task->lead->head ? $task->lead->head->name : "NA") ." | ";
                                            echo rtrim($txt, ' | ');
                                        }
                                    @endphp
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ date('d M, Y h:i a', strtotime($task->start_date))  }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->description }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->priority }}
                                </td>
                                <td data-label="Description" class="tableitem">
                                    {{ $task->response_status == 0 ? "Pending" : "Completed"  }}
                                </td>
                                
                                
                                <td data-label="Tax Code" class="tableitem">{{ date('d M, Y H:i', strtotime($task->created_at)) }}</td>
                            </tr>

                            @endforeach
                            
                        </table>
                    </div>


 
                    

                    
                </div>
                
            </div>
            <!--End Invoice-->
        </div>
        <!-- End Invoice Holder-->


    <script type="text/javascript">

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var options = {
          series: [{
          // data: [21, 22, 10, 28, 16, 21, 13, 30]
          data: [],
        }],
          chart: {
          height: 350,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        // colors: colors,
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        xaxis: {
        //   categories: [
        //     ['John', 'Doe'],
        //     ['Joe', 'Smith'],
        //     ['Jake', 'Williams'],
        //     'Amber',
        //     ['Peter Brown'],
        //     ['Mary', 'Evans'],
        //     ['David', 'Wilson'],
        //     ['Lily', 'Roberts'], 
        //   ],
        categories: [],
          labels: {
            style: {
              // colors: colors,
              fontSize: '12px'
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        $.getJSON("{{ url('getTaskStats') }}", function(response) {
           console.log(response.leads);


            chart.updateOptions({
                xaxis: {
                    categories: response.task_names
                },
                series: [{
                    data: response.task_count
                }],
            });

        });

    });


</script>
</body>
</html>