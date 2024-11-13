@extends('layouts.app')
@section('content')

@php $act_types = array('1' => 'Waiting', '2'=>'Call', '3'=>'Meeting'); @endphp
@php $categories = ['Associate'=>'Associate', 'Hierararchy'=>'Hierararchy', 'End User'=>'End User', 'Trading'=>'Trading'];  @endphp
@php $priorities = ['P0-A0'=>'P0-A0', 'P0-A1'=>'P0-A1', 'P0-A2'=>'P0-A2', 'P1'=>'P1', 'P2'=>'P2', 'P3'=>'P3', 'P4'=>'P4'];  @endphp
@php $ages = ['7'=>'7 Days', '15'=>'15 Days', '30'=>'30 Days', '45'=>'45 Days'];  @endphp

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Leads <small>Report</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
    <a class="btn btn-primary" href="{{url('lead/create')}}" id="createNewProduct"><i class="fa fa-plus"></i> Add New Lead</a>
    </div>

</div>
<!-- PAGE-HEADER END -->


<div class="content mt-3">

    <div class="card shadow mb-4">

        <div class="card-header">
            <strong>Leads List</strong>
        </div>

        <div class="card-body">
            <div class="">

                {{-- <div class="form-group">
                    {{ Form::hidden('phase', $phase, ['id'=>'phase_id']) }}
                    {{ Form::select('lead_stage_id', [''=>'Select Stage']+$stages, '', ['class'=>'standardSelect form-control', 'title'=>'Select Stage', 'data-live-search'=>'true', 'id'=>'lead_stage_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                </div> --}}

                <div class="row mb-3">                
                    <div class="col-md-3 mb-0 form-group">
                        {{ Form::select('lead_stage_id', [''=>'Select Stage']+$stages, '', ['class'=>'standardSelect form-control', 'title'=>'Select Stage', 'data-live-search'=>'true', 'id'=>'lead_stage_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                
                    <div class="col-md-3 mb-0 form-group">
                        {{ Form::select('project_id', [''=>'Select Project']+$projects, '', ['class'=>'standardSelect form-control', 'title'=>'Select category', 'id'=>'project_id', 'required']) }}
                    </div>
                    <div class="col-md-3 mb-0 form-group">
                        {{ Form::select('property_id', [''=>'Select Property'], '', ['class'=>'standardSelect form-control', 'title'=>'Select Property', 'id'=>'property_id']) }}
                    </div>
                    <div class="col-md-3 mb-0 form-group">
                        {{ Form::select('category', [''=>'Select Category']+$categories, '', ['class'=>'standardSelect form-control', 'title'=>'Select Category', 'data-live-search'=>'true', 'id'=>'category' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                </div>

                <div class="table-responsive">
                <table class="table table-bordered data-table" id="file-datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Title</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Stage</th>
                            <th>RM</th>
                            <th>CRM</th>
                            <th>Last Activity</th>
                            <th>Details</th>
                            <th>Lead Age</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $key => $lead)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $lead->title }}</td>
                                <td>{{ $lead->first_name.' '.$lead->last_name }}</td>
                                <td>{{ $lead->phone }}</td>
                                <td>{{ $lead->category }}</td>
                                <td>{{ $lead->priority }}</td>
                                <td>{{ @$lead->stage->name }}</td>
                                <td>{{ @$lead->rm->name }}</td>
                                <td>{{ @$lead->crm->name }}</td>
                                <td>{{ $lead->last_activity ? $act_types[$lead->last_activity->activity_type ] : "NA" }}</td>
                                <td>
                                    @php 
                                        $data = "";
                                        if($lead->last_activity && $lead->last_activity->activity_type==1){
                                            $data = "Next Date to Connect with: ".date('d M, Y', strtotime($lead->last_activity->waiting_days))." || ";
                                        }
                                        elseif($lead->last_activity && $lead->last_activity->activity_type==2){
                                           $data = "Call Time: ".date('d M, Y H:i', strtotime($lead->last_activity->act_time))." || ";
                                        }
                                        elseif($lead->last_activity && $lead->last_activity->activity_type==3){
                                            $data = "Meeting Time: ".date('d M, Y H:i', strtotime($lead->last_activity->act_time))." || ";
                                                                
                                            $data .= "Meeting With: ".($lead->last_activity->activity_user ? $lead->last_activity->activity_user->name : "NA")." || ";

                                            $data .= "Meeting Location: ".$lead->last_activity->location." || ";

                                            $data .= "Meeting Slot: ".$lead->last_activity->act_slot." || " ;
                                        }
                                        else{
                                            echo "No Activity Yet";
                                        }

                                        if($lead->last_activity)
                                        {
                                            $data .= "Description: ".$lead->last_activity->description." || ";
                                            $data .= "By: ".$lead->last_activity->user->name." || ";
                                            $data .= "Time: ".date('d M, Y H:i', strtotime($lead->last_activity->created_at));
                                        }
                                        

                                        echo $data;

                                    @endphp
                                </td>
                                
                                <td>{{ round((time() - strtotime($lead->created_at)) / (60 * 60 * 24)) }} Days</td>
                            </tr>


                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

@stop



@section('scripting')



<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('.data-table').DataTable({
        //     dom: 'Blfrtip',
        //     buttons: [
        //         'csv'
        //     ]
        // });


        var table = $('#file-datatable').DataTable({
        "dom": 'Bfrtip',
		"buttons": ['excel', 'pdf', 'print', 'pageLength'], 	
		"pageLength": 10,
		"processing": false,
		responsive: false,
		language: {
			searchPlaceholder: 'Search...',
			sSearch: '',
		}
	});
	table.buttons().container()
		.appendTo('#file-datatable_wrapper .col-md-6:eq(0)');

        // new DataTable('.data-table', {
        //     layout: {
        //         topStart: {
        //             buttons: ['copy', 'excel', 'pdf', 'colvis']
        //         }
        //     }
        // });

        

    });

</script>


@endsection
