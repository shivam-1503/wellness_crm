@extends('layouts.app')
@section('content')

@php $categories = ['Associate'=>'Associate', 'End User'=>'End User', 'Associate + End User'=>'Associate + End User',  'Trading'=>'Trading'];  @endphp
@php $priorities = ['P0-A0'=>'P0-A0', 'P0-A1'=>'P0-A1', 'P0-A2'=>'P0-A2', 'P1-A0'=>'P1-A0', 'P1-A1'=>'P1-A1', 'P1-A2'=>'P1-A2', 'P2-A0'=>'P2-A0', 'P2-A1'=>'P2-A1', 'P2-A2'=>'P2-A2', 'P3'=>'P3', 'P4'=>'P4'];  @endphp
@php $ages = ['7'=>'7 Days or Less', '15'=>'15 Days or Less', '30'=>'30 Days or Less', '45'=>'45 Days or Less', '1000'=>'More than 45 days'];  @endphp


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Leads <small>List & Management</small></h1>
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

                <div class="row mb-3">
                    {{ Form::hidden('phase', $phase, ['id'=>'phase_id']) }}
                
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('lead_stage_id', [''=>'Select Stage']+$stages, $stage_param, ['class'=>'standardSelect form-control', 'title'=>'Select Stage', 'data-live-search'=>'true', 'id'=>'lead_stage_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>                
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('project_id', [''=>'Select Service']+$services, '', ['class'=>'standardSelect form-control', 'title'=>'Select category', 'id'=>'project_id', 'required']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('category', [''=>'Select Category']+$categories, '', ['class'=>'standardSelect form-control', 'title'=>'Select Category', 'data-live-search'=>'true', 'id'=>'category' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('priority', [''=>'Select Priority']+$priorities, '', ['class'=>'standardSelect form-control', 'title'=>'Select Priority', 'data-live-search'=>'true', 'id'=>'priority' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('age', [''=>'Select Lead Age']+$ages, '', ['class'=>'standardSelect form-control', 'title'=>'Select Lead Age', 'data-live-search'=>'true', 'id'=>'age' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('assigned_to', [''=>'Select Consultant']+$users, '', ['class'=>'standardSelect form-control', 'title'=>'Select Consultant', 'data-live-search'=>'true', 'id'=>'assigned_to' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3">
                        {{ Form::date('lead_start_date','',['class'=>'form-control', 'id'=>"from_date"]) }}
                    </div>
                    <div class="col-md-3">
                        {{ Form::date('lead_end_date','',['class'=>'form-control', 'id'=>"to_date"]) }}
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered data-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Category</th>
                            <th>Stage</th>
                            <th>Priority</th>
                            <th>Service</th>
                            <th>Assignee</th>
                            <th>Created At</th>
                            <th>Lead Age</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>
</div>
</div>


@include('view-modals/assign_lead')
@include('view-modals/comment_lead')


@stop



@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            "dom": 'Bfrtip',
		    "buttons": [
                'excel', 
                'pdf', 
                {
                    extend: 'print',
                    text: 'Print',
                    title: 'Leads Report | Date: '+"{{date('d M, Y')}}",
                },
                'pageLength'], 	
		    "pageLength": 100,
            processing: true,
            serverSide: true,
            // ajax: "{{ url('getleadsData') }}",
            ajax: {
                data: function ( d ) {
                        d.stage_id = $('#lead_stage_id').val();
                        d.service_id = $('#service_id').val();
                        d.phase_id = $('#phase_id').val();
                        d.category = $('#category').val();
                        d.priority = $('#priority').val();
                        d.age = $('#age').val();
                        d.assigned_to = $('#assigned_to').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d._token = "{{ csrf_token() }}";
                    },
                url: "{{ url('getleadsData') }}",
                type: "POST",
                dataType: 'json',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'client', name: 'first_name'},
                {data: 'category', name: 'category', orderable: false, searchable: true},
                {data: 'stage', name: 'stage.name', orderable: false, searchable: false},
                {data: 'priority', name: 'priority'},
                {data: 'service', name: 'service'},
                {data: 'assignee', name: 'assignee'},
                {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                {data: 'lead_age', name: 'lead_age'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            
        });

        table.on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({placement: 'top',});
        });


        $('#lead_stage_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#priority').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#age').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#assigned_to').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#category').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#from_date').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#to_date').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        


        // Delete a record
        $('body').on('click', '.deleteProduct', function(e) {
            var product_id = $(this).data("id");

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        type: "GET",
                        url: "{{ url('product/delete') }}"+'/'+product_id,
                        success: function (data) {
                            table.draw();
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





        $('body').on('click', '.assignLead', function () {
		    var product_id = $(this).data('id');
		    reset_modal();

            $.get("{{ url('get_lead_details') }}" +'/' + product_id, function (data) {
                console.log(data.crm_id);
                $('#ajaxModel').modal('show');
                $('#modelHeading').html("Assign Lead");
                $('#lead_id').val(product_id);
                $('#user_id').val(data.assigned_to);
                $('.standardSelect').selectpicker('refresh');
		    })
		});



        $('#saveBtn').click(function (e) {
		    e.preventDefault();
		    $(this).html('Sending..');

		    $.ajax({
		        data: $('#dataForm').serialize(),
		        url: "{{ url('lead/assign_lead') }}",
		        type: "POST",
		        dataType: 'json',

		        success: function (data) {
		            $('#dataForm').trigger("reset");
		            $('#ajaxModel').modal('hide');
		            table.draw();
		            swal({
						title: "Good job!",
						text: data.msg,
						icon: "success",
					});
		        },
		        error: function (data) {
		            if (data.status == 422) {
		                var x = data.responseJSON;
		                $.each(x.errors, function( index, value ) {
		                    $("#"+index).addClass("is-invalid");
		                    $("#"+index+"-error").html(value[0]);
		                });
		            }
		            $('#saveBtn').html('Save Changes');
		        }
		  });
		});



        $('body').on('click', '.commentLead', function () {
		    var product_id = $(this).data('id');
		    reset_modal_comment();

            $.get("{{ url('get_lead_details') }}" +'/' + product_id, function (data) {
                $('#commentModel').modal('show');
                $('#modelHeading').html("Assign Lead");
                $('#lead_id_c').val(product_id);
                $('#priority_c').val(data.priority);
                $('#stage_id_c').val(data.stage_id_fk);
                $('#comment').val('');
                $('.standardSelect').selectpicker('refresh');
		    })
		});



        $('#saveCommentBtn').click(function (e) {
		    e.preventDefault();
		    $(this).html('Sending..');

		    $.ajax({
		        data: $('#commentForm').serialize(),
		        url: "{{ url('lead/store_comment') }}",
		        type: "POST",
		        dataType: 'json',

		        success: function (data) {
		            $('#commentForm').trigger("reset");
		            $('#commentModel').modal('hide');
		            table.draw();
		            swal({
						title: "Good job!",
						text: data.msg,
						icon: "success",
					});
		        },
		        error: function (data) {
		            if (data.status == 422) {
		                var x = data.responseJSON;
		                $.each(x.errors, function( index, value ) {
		                    $("#"+index).addClass("is-invalid");
		                    $("#"+index+"-error").html(value[0]);
		                });
		            }
		            $('#saveCommentBtn').html('Save Changes');
		        }
		  });
		});



    });


    function reset_modal() {
    	$("#cat_id").val("");
    	$("name").val("");
    	//$('#status').val("").trigger("chosen:updated");
    	$('#status').val("");
		$('.standardSelect').selectpicker('refresh');

        $("#name").removeClass("is-invalid");
        $("#country_id_fk").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#name-error").html("");
        $("#country_id_fk-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');
    }

    function reset_modal_comment() {
    	$("#cat_id").val("");
    	$("name").val("");
    	//$('#status').val("").trigger("chosen:updated");
    	$('#status').val("");
		$('.standardSelect').selectpicker('refresh');

        $("#name").removeClass("is-invalid");
        $("#country_id_fk").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#name-error").html("");
        $("#country_id_fk-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');
    }

    



</script>


@endsection
