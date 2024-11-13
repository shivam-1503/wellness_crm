@extends('layouts.app')
@section('content')

@php $response_statuses = [1=>'Completed', 0=>'Pending']; @endphp
@php $types = [0=>'Tasks', 1=>'Waiting', '2'=>'Call', '3'=>'Meeting', '4'=>'Site Visit', '5'=>'Review']; @endphp


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Tasks <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
        <button type="button" class="modal-effect btn btn-primary mb-3" 
            data-bs-effect="effect-scale" data-bs-toggle="modal" id="createNewProduct" data-bs-target="#ajaxModel"> <i class="fa fa-plus"></i> Add Task</button>
    </div>

    

</div>
<!-- PAGE-HEADER END -->


<div class="content mt-3">
		
		<div class="card radius-10">
			<div class="card-body">
				{{ Form::open(['id' => 'basicForm', 'name' => 'dataForm', 'class' => 'form-horizontal']) }}
                {{ csrf_field() }}
                <div class="row mb-3">

                <div class="col-md-3 mb-3 form-group">
                {{ Form::select('response_status', [''=>'Select Response Status']+$response_statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Response', 'data-live-search'=>'true', 'id'=>'response_status' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                </div>
                <div class="col-md-3 mb-3 form-group">
                {{ Form::date('task_date','',['class'=>'form-control', 'id'=>"task_date"]) }}

                </div>
                <div class="col-md-3 mb-3 form-group">
                {{ Form::date('to_date','',['class'=>'form-control', 'id'=>"to_date"]) }}

                </div>
				<div class="col-md-3 mb-3 form-group">
                {{ Form::select('type', [''=>'Select Task Type']+$types, '', ['class'=>'standardSelect form-control', 'title'=>'Select Response', 'data-live-search'=>'true', 'id'=>'type' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}

                </div>
				<div class="col-md-3 mb-3 form-group">
					{{ Form::select('user_id', [''=>'Select User']+$users, '', ['class'=>'standardSelect form-control', 'title'=>'Select RM', 'data-live-search'=>'true', 'id'=>'rm_id' , 'data-dropup-auto'=>'false', 'data-size'=>'5']) }}
				</div>
				<div class="col-md-3 mb-3 form-group">
					<button type="button" onclick="show_receipt()" title="Download" class="btn btn-primary"><i class="fas fa-receipt"></i> Download Complete Report</button>
				</div>
                </div>
				{{ Form::close() }}
				
				<div class="table-responsive">

					<table  class="table table-bordered border-bottom data-table w-100">
						<thead>
							<tr>
								<th  width="20" class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">Title</th>
								<th class="border-bottom-0">Client</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0" style="max-width: 200px">Description</th>
								<th class="border-bottom-0">Priority</th>
								<th class="border-bottom-0">Status</th>
								<th class="border-bottom-0">Last Update</th>
								<th class="border-bottom-0">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					
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
                        <a href="#"  class="btn btn-primary download_link"><i class="fa fa-file-pdf"></i> &nbsp; Download PDF</a>
                    </div>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice Modal Ends -->


    @include('view-modals/tasks_addedit')
    @include('view-modals/task_response')

@stop


@section('scripting')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">

    $(document).ready(function() {

		$(".standardSelect").selectpicker();

        $('.standardSelect').on('change', function () {
            // $(this).valid();
            $('.standardSelect').selectpicker('refresh');
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		var table = $('.data-table').DataTable({
            "dom": 'Bfrtip',
            "buttons": ['excel', 'pdf', 'print', 'pageLength'], 	
            "pageLength": 100,
            responsive: false,
		    processing: true,
		    serverSide: true,
            ajax: {
                data: function ( d ) {
                        d.task_date = $('#task_date').val();
                        d.to_date = $('#to_date').val();
                        d.response_status = $('#response_status').val();
                        d.type = $('#type').val();
                        d.user_id = $('#user_id').val();
                        d._token = "{{ csrf_token() }}";
                    },
                url: "{{ url('getTasksData') }}",
                type: "POST",
                dataType: 'json',
            },
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'title', name: 'name', orderable: false, searchable: false},
		        {data: 'client', name: 'client'},
                {data: 'start_date', name: 'start_date', orderable: false, searchable: false},
                {data: 'description', name: 'description', orderable: false, searchable: false},
				{data: 'priority', name: 'priority'},
		        {data: 'status', name: 'status', orderable: false, searchable: false},
		        {data: 'updated_at', name: 'Last Update', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    },

            columnDefs: [{ width: 20, targets: 0 }],
            fixedColumns: true,
		});


        table.on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({placement: 'top',});
        });


        $('#task_date').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
        
		$('#to_date').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });

		$('#type').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });

        $('#response_status').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
		$('#rm_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });
		$('#crm_id').change(function (e) {
            $(".data-table").DataTable().ajax.reload();
        });


		$('#createNewProduct').click(function () {
		    reset_modal();
		    $('#saveBtn').val("Create");
		    $('#status').val('').trigger("chosen:updated");
		    $('#dataForm').trigger("reset");
		    $('#modelHeading').html("Create New Task");
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('task/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Edit Task");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#task_id').val(data.id);
		      $('#title').val(data.title);
              $('#start_date').val(data.start_date);
              $('#start_time').val(data.start_time);
		      // $('#end_date').val(data.end_date);
              $('#description').val(data.description);
		      $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');
		  })
		});


        $('body').on('click', '.responseProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('task/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Record Task Response");
		      $('#saveBtn').val("Save Changes");
		      $('#responseModel').modal('show');
		      $('#response_task_id').val(data.id);
		      $('#title').val(data.title);
              $('#start_date').val(data.start_date);
              $('#start_time').val(data.start_time);
		      // $('#end_date').val(data.end_date);
              $('#description').val(data.description);
		      $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');
		  })
		});

		// $('#saveBtn').click(function (e) {
		//     e.preventDefault();
		//     $(this).html('Sending..');

		//     $.ajax({
		//         data: $('#dataForm').serialize(),
		//         url: "{{ url('department/store') }}",
		//         type: "POST",
		//         dataType: 'json',

		//         success: function (data) {
		//             //$('#dataForm').trigger("reset");
		//             $('#ajaxModel').modal('hide');
		// 			swal({
		// 				title: "Great!",
		// 				type: "success",
		// 				text: data.msg, 
		// 				confirmButtonColor: "#71aa68",   
		// 			},
		// 			function(){ table.draw(); });		            
		//         },
		//         error: function (data) {
		//             if (data.status == 422) {
		//                 var x = data.responseJSON;
		//                 $.each(x.errors, function( index, value ) {
		//                     $("#"+index).addClass("is-invalid");
		//                     $("#"+index+"-error").html(value[0]);
		//                 });
		//             }
		//             $('#saveBtn').html('Save Changes');
		//         }
		//   });
		// });



		if ($("#dataForm").length > 0) {
			
			$("#dataForm").validate({

				errorClass: "is-invalid",

				unhighlight: function(element, errorClass, validClass) {
					$(element).removeClass(errorClass);
					$(element).parent().removeClass(errorClass);
				},

				errorPlacement: function(error, element) {
					element.parent().append( error );
					$('.standardSelect').selectpicker('refresh');
				},

				rules: {
					title: 'required',
					start_date: 'required',
					// end_date: 'required',
                    // available_for: 'required',
					description: 'required',
					status: 'required',
				},

				messages: {
					title: "Please Enter Zipcode.",
					start_date: "Please Enter Address.",
					// end_date: "Please Select Status.",
                    // available_for: "Please Enter Zipcode.",
					description: "Please Enter Address.",
					status: "Please Select Status.",
				},



				submitHandler: function(form) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$('#saveBtn').html('Sending..');
                    var vals = $("#dataForm").serializeArray();
							
                    // var vals = $("#dataForm").find('input,select').serializeArray();
                    // vals.push({name: 'description', value: CKEDITOR.instances.description.getData()});
                    // vals.push({name: 'salient_feature', value: CKEDITOR.instances.salient_feature.getData()});

					$.ajax({
						data: vals,
						url: "{{ url('task/store') }}",
						type: "POST",
						dataType: 'json',

						success: function (data) {
							$('#ajaxModel').modal('hide');
							swal({
								title: "Good job!",
								text: data.msg,
								icon: "success",
							})
							.then((willDelete) => {
								table.draw();
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
		}



        if ($("#responseForm").length > 0) {
			
			$("#responseForm").validate({

				errorClass: "is-invalid",

				unhighlight: function(element, errorClass, validClass) {
					$(element).removeClass(errorClass);
					$(element).parent().removeClass(errorClass);
				},

				errorPlacement: function(error, element) {
					element.parent().append( error );
					$('.standardSelect').selectpicker('refresh');
				},

				rules: {
					response_status: 'required',
				},

				messages: {
					response_status: "Please Enter Zipcode.",
				},



				submitHandler: function(form) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$('#saveBtn').html('Sending..');
                    var vals = $("#responseForm").serializeArray();
							
                    // var vals = $("#dataForm").find('input,select').serializeArray();
                    // vals.push({name: 'description', value: CKEDITOR.instances.description.getData()});
                    // vals.push({name: 'salient_feature', value: CKEDITOR.instances.salient_feature.getData()});

					$.ajax({
						data: vals,
						url: "{{ url('task/store_response') }}",
						type: "POST",
						dataType: 'json',

						success: function (data) {
							$('#responseModel').modal('hide');
							swal({
								title: "Good job!",
								text: data.msg,
								icon: "success",
							})
							.then((willDelete) => {
								table.draw();
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
		}



		$('body').on('click', '.deleteProduct', function () {

		    var product_id = $(this).data("id");

			swal({title: "Are You Sure?", 
				text: "You want to delete this task",  
				type: "warning", icon: "warning",   
				showCancelButton: true,    
				confirmButtonColor: "#e6b034",  
				buttons: {
							cancel: "Cancel",
							confirm: {
								text: "Delete",
								closeModal: false,
							}
						},
				closeOnConfirm: false, 
				closeOnCancel: true })
			
			.then (isConfirm => {

				if(isConfirm){

                    swal({    title: "Processing Data ...", text: "Deleting this record..", icon: "success",  showConfirmButton: false });
					$.ajax({type: "GET", url: "{{ url('task/delete') }}"+'/'+product_id,
						success: function (data) {
							swal({   
								title: data.success,   
								type: "success", 
								text: data.msg,
								confirmButtonColor: "#71aa68",
							})
							.then(refresh => {
								table.draw();
								});
							},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				}
			});
		});

		$('.standardSelect').selectpicker('refresh');

    });


    function reset_modal() {
    	$("#task_id").val("");
    	$("#title").val("");
        $("#start_date").val("");
        $("#end_date").val("");
        $("#available_for").val("");
        $("#description").val("");
    	$("#status").val("");

		
		$('#ajaxModel').modal('hide');

        $("#title").removeClass("is-invalid");
        $("#start_date").removeClass("is-invalid");
        $("#end_date").removeClass("is-invalid");
        $("#available_for").removeClass("is-invalid");
        $("#description").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#title-error").html("");
        $("#start_date-error").html("");
        $("#end_date-error").html("");
        $("#available_for-error").html("");
        $("#description-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');
		$('.standardSelect').selectpicker('refresh');
    }



	function show_receipt()
    {
        var id = '';
        $.ajax({
			data: $('#basicForm').serialize(),
            type : 'POST',
            url : '{{ url("generate-tasks-report") }}',

            success: function(result, url) {

                var link =  '{{ url("generate-tasks-report") }}?e='+id;
                $("a.download_link").attr("href", link + '&export=pdf');

                $('.modal-title').html("Tasks Details Report");
                $('.modal-body').html(result);
                $('#myModal').modal('show');

                $('.modal-container').load($(this).data('path'),function(result){
                    $('#myModal').modal({show:true});
                });
            }
        });
    }



	function download_receipt()
    {
        var id = '';
        $.ajax({
			data: $('#basicForm').serialize(),
            type : 'POST',
            url : '{{ url("generate-tasks-report") }}?e=1&export=pdf',

            success: function(result, url) {

                console.log("Hello");
            }
        });
    }


</script>
@stop
