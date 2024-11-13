@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>KRAs <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">KRAs </a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage</li>
        </ol>
    </div>

    <div class="float-end">
		@if($employee->kra_status == 0)
			<a class="btn btn-primary float-end" href="javascript:void(0)" id="submitForApproval"><i class="fa fa-plus"></i> Submit for Approval</a>
		@elseif($employee->kra_status == 1)
			<a class="btn btn-primary float-end" href="javascript:void(0)" id="approveKra"><i class="fa fa-plus"></i> Approve KRA</a>
		@endif
	</div>

</div>
<!-- PAGE-HEADER END -->



	<div class="content mt-3">

        <!-- Default box -->
        <div class="card">

        	<div class="card-header">
				KRAs List
        	</div>

			
			{!! Form::hidden('designation_id', '', ['id'=>'designation_id']); !!}

            <div class="card-body">
                <table class="table table-bordered table-hover data-table" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>KPI</th>
                            <th>Target</th>
                            <th>Weightage</th>
                            <th>Frequency</th>
                            <th>Status</th>
                            @if($employee->kra_status == 0)
								<th>Action</th>
							@endif
                        </tr>
                    </thead>
                    
					@if($employee->kra_status == 0)
					
					<tbody>
						@foreach($kpis as $key => $kpi)

						{!! Form::open(['id' => 'dataForm_'.$kpi->id, 'name' => 'dataForm_'.$kpi->id, 'class'=>'form-horizontal']) !!}
						{{csrf_field()}}
						{!! Form::hidden('kpi_id', $kpi->id, ['id'=>'designation_id']); !!}
						{!! Form::hidden('employee_id', $employee->id, ['id'=>'designation_id']); !!}

						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $kpi->title }}</td>
							<td>
								{!! Form::text('target', $kpi->kra ? $kpi->kra->target : '', ['class'=>"form-control", 'id'=>"target_".$kpi->id, 'placeholder'=>"Enter Target in ".$kpi->unit, 'required']); !!}
							</td>
							<td>
								{!! Form::text('weightage', $kpi->kra ? $kpi->kra->weightage : '', ['class'=>"form-control", 'id'=>"weightage_".$kpi->id, 'placeholder'=>"Weightage Percentage", 'required']); !!}
							</td>
							<td>
								{!! Form::select('review_frequency', [''=>'Select Frequency']+$review_frequencies, $kpi->kra ? $kpi->kra->review_frequency : '', ['class'=>"form-control", 'id'=>"review_frequency_".$kpi->id, 'required']); !!}
							</td>
							<td>
								<span class="badge bg-danger">Not Submitted</span>
							</td>
							<td>
								<a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $kpi->id }}" data-original-title="Edit" class="edit btn btn-primary btn-sm saveBtn"><i class="fa fa-edit"></i></a>	
							</td>
						</tr>
						{!! Form::close() !!}

						@endforeach
                    </tbody>
					
					@else

					<tbody>
						@foreach($kpis as $key => $kpi)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $kpi->title }}</td>
							<td>{{ $kpi->kra->target }}@if($kpi->unit == 'Percentage')% @elseif($kpi->unit == 'Number') @endif </td>
							<td>{{ $kpi->kra->weightage }}%</td>
							<td>{{ $kpi->kra->review_frequency }}</td>
							<td>
								@if($employee->kra_status == 1)
									<span class="badge bg-info">Pending for Approval</span>
								@else
									<span class="badge bg-success">Approved</span>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>

					@endif

                </table>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->
    </div>

@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

		$(".standardSelect").selectpicker();

        $('.standardSelect').on('change', function () {
            $(this).valid();
            $('.standardSelect').selectpicker('refresh');
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		$('#createNewProduct').click(function () {
		    reset_modal();
		    $('#saveBtn').val("Create");
		    $('#status').val('').trigger("chosen:updated");
		    $('#dataForm').trigger("reset");
		    $('#modelHeading').html("Create New KPI");
		    $('#ajaxModel').modal('show');
		});


		$('body').on('click', '.saveBtn', function (e) {
			e.preventDefault();
			var product_id = $(this).data('id');
			
			var target = $('#target_'+product_id).val();
			var weightage = $('#weightage_'+product_id).val();
			var review_frequency = $('#review_frequency_'+product_id).val();

			var error_message = '';

			if(!target) {
				error_message = 'Target is mandatory';
			}

			if(!weightage) {
				error_message = 'Weightage is mandatory';
			}

			if(!review_frequency) {
				error_message = 'Review Frequency is mandatory';
			}

			if(error_message != '') {

				swal({
					title: "Error",
					text: error_message,
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					error_message = '';
				})
			}
			else {
				$.ajax({
					data: $('#dataForm_'+product_id).serialize(),
					url: "{{ url('kra/store') }}",
					type: "POST",
					dataType: 'json',

					success: function (data) {
						// $('#ajaxModel').modal('hide');
						swal({
							title: "Good job!",
							text: data.msg,
							icon: "success",
						})
						.then((willDelete) => {
							// table.draw();
						});
					},

					error: function (data) {
						if (data.status == 422) {
							var x = data.responseJSON;
							$.each(x.errors, function( index, value ) {
								console.log(index);
								$("#"+index).addClass("is-invalid");
								$('.standardSelect').selectpicker('refresh');
								$("#"+index+"-error").html(value[0]);
							});
						}
						$('#saveBtn').html('Save Changes');
					}
				});
			}



			
			
			
		})



		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  $.get("{{ url('kpi/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Edit KPI");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#kpi_id').val(data.id);
		      $('#title').val(data.title);
		      $('#kpi_group_id').val(data.kpi_group_id);
		      $('#description').val(data.description);
		      $('#unit').val(data.unit);
		      $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');
		  })
		});



		

		$('body').on('click', '#submitForApproval', function () {

		    var product_id = "{{ $employee->id }}";

		    swal({
		    	title: "Are you sure?",
				text: "Once Submitted, you will not be able to make any changes!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
		    })
			.then((willDelete) => {
  				if (willDelete) {

					$.ajax({
				        type: "GET",
				        url: "{{ url('kra/submit_for_approval') }}"+'/'+product_id,
				        success: function (data) {
							if(data.success) {
								swal(data.msg, {
									icon: "success",
								});
							}
							else {
								swal(data.msg, {
									icon: "error",
								});
							}
				            
				        },
				        error: function (data) {
				            console.log('Error:', data);
				        }
				    });
				}
				else
				{
					swal("Your KPI delete request Cancelled!")
				}

			})


		});


		$('body').on('click', '#approveKra', function () {

			var product_id = "{{ $employee->id }}";

			swal({
				title: "Are you sure?",
				text: "Once Submitted, you will not be able to make any changes!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {

					$.ajax({
						type: "GET",
						url: "{{ url('kra/approve_kra') }}"+'/'+product_id,
						success: function (data) {
							if(data.success) {
								swal(data.msg, {
									icon: "success",
								});
							}
							else {
								swal(data.msg, {
									icon: "error",
								});
							}	
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				}
				else
				{
					swal("Your KPI delete request Cancelled!")
				}

			})
		});

		

		$('.standardSelect').selectpicker('refresh');

		//$(".standardSelect").select2();

    });


    function reset_modal() {
    	$("#cat_id").val("");
    	$("title").val("");
    	$("description").val("");
    	$("type").val("");
    	$('#status').val("");
		$('.standardSelect').selectpicker('refresh');

        $("#title").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#title-error").html("");
        $("#description-error").html("");
        $("#description-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');
    }

</script>
@stop
