@extends('layouts.app')
@section('content')

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Tasks Calendar <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
    	<a class="btn btn-primary" href="{{url('tasks')}}" id="createNewProduct"><i class="fa fa-bars"></i> Tasks List</a>
    </div>

</div>
<!-- PAGE-HEADER END -->


<div class="content mt-3">
					
				<div class="card radius-10">
					<div class="card-body">
						
                    <!-- <h3>Calendar</h3> -->

                    <div id='calendar'></div>
						
					</div>
				</div>
				
</div>
			
			@include('view-modals/tasks_addedit')


@stop


@section('scripting')


<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>

<script type="text/javascript">

    $(document).ready(function() {

		// $(".standardSelect").selectpicker();

        // $('.standardSelect').on('change', function () {
        //     // $(this).valid();
        //     $('.standardSelect').selectpicker('refresh');
        // });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


		$('#calendar').fullCalendar({
			timeZone: 'local',
			processing: true,
		    serverSide: true,
		    ajax: "{{ url('getTasksData') }}",
			eventLimit: true,
			dayMaxEvents: true,
		    events : [
                @foreach($tasks as $task)
                {
                    title : '{{ $task->title }}',
                    start : '{{ $task->start_date }}',
                    end : '{{ $task->end_date }}',
                    text : '{{ $task->description }}',
					task_id : '{{ $task->id }}',
					username : '{{ @$task->lead->first_name.' '.@$task->lead->last_name }}',
					phone : '{{ @$task->lead->phone }}',
                },
                @endforeach
            ],

			eventClick:  function(arg) {
                // endtime = $.fullCalendar.moment(event.end).format('h:mm');
                // starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');
                // var mywhen = starttime + ' - ' + endtime;
                // $('#title').html(arg.title);

				console.log(arg);
                $('#task').html(arg.title);
                $('#text').html(arg.text);
                $('#username').html(arg.username);
                $('#phone').html(arg.phone);
                $('#modalWhen').text(arg.start);
                $('#modalEndDate').text(arg.end);
                $('#task_id').val(arg.id);
				$('#del_item').val(arg.task_id);
                $('#calendarModal').modal('show');
            },

            dayClick: function(arg) {

				$('#dataForm').trigger("reset");

				var dt = arg.format();
				$('#saveBtn').val("Create");
				$('#start_date').val(dt);
				$('#end_date').val(dt);
				$('#status').val('').trigger("chosen:updated");
				$('#modelHeading').html("Create New To-Do-List");
				$('#ajaxModel').modal('show');
            }
        });


		if ($("#dataForm").length > 0) {
			console.log("sss");
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
                    end_date: 'required',
					description: 'required',
					status: 'required',
					available_for: 'required'
				},

				messages: {
					title: "Please Enter Title.",
					start_date: "Please Enter Start Date.",
                    end_date: "Please Enter End Date.",
					status: "Please Select Status.",
					description: "Please enter description.",
					available_for: "Please Select Available for.",
				},

				submitHandler: function(form) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					swal({   
						title: "Are You Sure?", 
						text: "HR Management System", 
						icon: "warning",

						buttons: {
							cancel: "Cancel",
							confirm: {
								text: "Create",
								closeModal: false,
							}
						},
					})
					.then(isConfirm => { 
						
						if(isConfirm){

							var vals = $("#dataForm").serializeArray();
							
							$.ajax({
								type: "POST",
								data: vals, dataType: 'json', url: "{{ url('task/store') }}",
								success: function (data) {
									$('#ajaxModel').modal('hide');
									swal({   
										title: "Success",   
										type: "success", 
										text: data.msg,
										icon: "success",
										confirmButtonColor: "#71aa68",
									})
									.then(refresh => {

										// window.location.reload(true);
									});
								},
								error: function (data) {
									console.log('Error:', data);
									swal({   
										title: "Error",   
										type: "error", 
										text: data.msg,
										icon: "error",
										confirmButtonColor: "#71aa68",
									})
									.then(refresh => {
									
										// window.location.reload(true);
										
									});
								}
							});
						}
					});

				}
			})
		}

    });


    function reset_modal() {
    	$("#to_do_list_id").val("");
    	$("name").val("");
    	$("description").val("");
    	$('#task_date').val("");
		$('#ajaxModel').modal('hide');

        $("#name").removeClass("is-invalid");
        $("#description").removeClass("is-invalid");
        $("#task_date").removeClass("is-invalid");

        $("#name-error").html("");
        $("#description-error").html("");
        $("#task_date-error").html("");

        $('#saveBtn').html('Save Changes');		
		$('.standardSelect').selectpicker('refresh');
    }




</script>

@endsection