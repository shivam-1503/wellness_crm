@extends('layouts.app')
@section('content')

@php $categories = ['Associate'=>'Associate', 'End User'=>'End User', 'Associate + End User'=>'Associate + End User',  'Trading'=>'Trading'];  @endphp
@php $priorities = ['P0-A0'=>'P0-A0', 'P0-A1'=>'P0-A1', 'P0-A2'=>'P0-A2', 'P1-A0'=>'P1-A0', 'P1-A1'=>'P1-A1', 'P1-A2'=>'P1-A2', 'P2-A0'=>'P2-A0', 'P2-A1'=>'P2-A1', 'P2-A2'=>'P2-A2', 'P3'=>'P3', 'P4'=>'P4'];  @endphp
@php $ages = ['7'=>'7 Days or Less', '15'=>'15 Days or Less', '30'=>'30 Days or Less', '45'=>'45 Days or Less', '1000'=>'More than 45 days'];  @endphp


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

                <div class="row mb-3">
                    {{ Form::hidden('phase', $phase, ['id'=>'phase_id']) }}
                
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('lead_stage_id', [''=>'Select Stage']+$stages, '', ['class'=>'standardSelect form-control', 'title'=>'Select Stage', 'data-live-search'=>'true', 'id'=>'lead_stage_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>                
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('project_id', [''=>'Select Project']+$projects, '', ['class'=>'standardSelect form-control', 'title'=>'Select category', 'id'=>'project_id', 'required']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('property_id', [''=>'Select Property'], '', ['class'=>'standardSelect form-control', 'title'=>'Select Property', 'id'=>'property_id']) }}
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
                        {{ Form::select('nc_id', [''=>'Select Consultant']+$users, '', ['class'=>'standardSelect form-control', 'title'=>'Select Consultant', 'data-live-search'=>'true', 'id'=>'nc_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('rm_id', [''=>'Select RM']+$users, '', ['class'=>'standardSelect form-control', 'title'=>'Select RM', 'data-live-search'=>'true', 'id'=>'rm_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('crm_id', [''=>'Select CRM']+$users, '', ['class'=>'standardSelect form-control', 'title'=>'Select CRM', 'data-live-search'=>'true', 'id'=>'crm_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3 mb-3 form-group">
                        {{ Form::select('head_id', [''=>'Select Director']+$users, '', ['class'=>'standardSelect form-control', 'title'=>'Select RM', 'data-live-search'=>'true', 'id'=>'head_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
                    </div>
                    <div class="col-md-3">
                        {{ Form::date('lead_start_date','',['class'=>'form-control', 'id'=>"from_date"]) }}
                    </div>
                    <div class="col-md-3">
                        {{ Form::date('lead_end_date','',['class'=>'form-control', 'id'=>"to_date"]) }}
                    </div>
                </div>

                <div class="table-responsive">
                <table class="table table-bordered data-table" id="file-datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20px">S.No.</th>
                            <th>Title</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Priority</th>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Stage</th>
                            <th>NC</th>
                            <th>RM</th>
                            <th>CRM</th>
                            <th>Sales Director</th>
                            <th>Last Comment</th>
                            <th>Activity</th>
                            <th>Details</th>
                            <th>Create At</th>
                            <th>Target Closure Date</th>
                            <th>Lead Age</th>
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


@include('view-modals/assign_lead');


@stop



@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#file-datatable').DataTable({
            "dom": 'Bfrtip',
		    "buttons": ['excel', 'pdf', {
                        extend: 'print',
                        text: 'Print',
                        title: 'Leads Report | Date: '+"{{date('d M, Y')}}",
                        orientation: 'landscape',
                    }, 'pageLength'], 	
		    "pageLength": 1000,
		    "processing": false,
		    responsive: false,
            processing: true,
            serverSide: true,
            // ajax: "{{ url('getleadsData') }}",
            ajax: {
                data: function ( d ) {
                        d.stage_id = $('#lead_stage_id').val();
                        d.project_id = $('#project_id').val();
                        d.property_id = $('#property_id').val();
                        d.phase_id = $('#phase_id').val();
                        d.category = $('#category').val();
                        d.priority = $('#priority').val();
                        d.rm_id = $('#rm_id').val();
                        d.crm_id = $('#crm_id').val();
                        d.nc_id = $('#nc_id').val();
                        d.head_id = $('#head_id').val();
                        d.age = $('#age').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d._token = "{{ csrf_token() }}";
                    },
                url: "{{ url('getleadsReportData') }}",
                type: "POST",
                dataType: 'json',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title', name: 'title', orderable: false, searchable: false},
                {data: 'client', name: 'first_name', orderable: false, searchable: true},
                {data: 'phone', name: 'phone', orderable: false, searchable: true},
                {data: 'priority', name: 'priority', orderable: false, searchable: true},
                {data: 'project', name: 'project', orderable: false, searchable: true},
                {data: 'category', name: 'category', orderable: false, searchable: true},
                {data: 'stage', name: 'stage.name', orderable: false, searchable: false},
                {data: 'nc_name', name: 'nc_name', orderable: false, searchable: false},
                {data: 'rm_name', name: 'rm_name', orderable: false, searchable: false},
                {data: 'crm_name', name: 'crm_name', orderable: false, searchable: false},
                {data: 'head_name', name: 'head_name', orderable: false, searchable: false},
                {data: 'last_comment', name: 'last_comment', orderable: false, searchable: false},
                {data: 'activity', name: 'activity', orderable: false, searchable: false},
                {data: 'details', name: 'details', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                {data: 'target_closure_date', name: 'target_closure_date', orderable: false, searchable: false},
                {data: 'lead_age', name: 'lead_age', orderable: false, searchable: false},
            ],

            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });

        table.buttons().container()
		.appendTo('#file-datatable_wrapper .col-md-6:eq(0)');

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

        $('#nc_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#rm_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#crm_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });

        $('#head_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#category').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
        $('#property_id').change(function (e) {
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

          $('#ajaxModel').modal('show');
          $('#modelHeading').html("Assign Lead");
          $('#lead_id').val(product_id);
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



    });


    $('#project_id').change(function() {
        var cat_id = $('#project_id').val();
        $.ajax({
			type: "get",
			url: "{{url('getPropertiesByProjectId/')}}/"+cat_id,
			dataType: "json",
			success: function(res) {

				if (res.success) {
					var options_htm = '<option value="">Select Properties</option>';
					$.each(res.data, function(key, val) {
						options_htm += '<option value="' + key + '">' + val + '</option>';
					});
					$('#property_id').html(options_htm);
                    $('.standardSelect').selectpicker('refresh');
				}
			}
		})

        $(".data-table").DataTable().ajax.reload();
    })


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




</script>


@endsection
