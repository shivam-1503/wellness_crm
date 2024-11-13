@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Users <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
		<a class="btn btn-primary float-end" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-plus"></i> Create User</a>
	</div>

</div>
<!-- PAGE-HEADER END -->



@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
@endif




<div class="content mt-3">

    <div class="card shadow mb-4">

        <div class="card-header">
            <strong>Users List</strong>
        </div>

        <div class="card-body">
            <div class="">
                <div class="table-responsive">
                <table class="table table-bordered data-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
						<tr>
							<th>Sr.</th>
							<th>Name</th>
							<th>Email</th>
							<th>Roles</th>
							<th>System Access</th>
							<th>Action</th>
						</tr>
                    </thead>

                    <tbody>
					@foreach ($data as $key => $user)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							
							<td>
								
							@if(!empty($user->getRoleNames()))
								@foreach($user->getRoleNames() as $x => $v)
									<span class="badge bg-primary"> {{ $v }}</span>
								@endforeach
							@endif
							</td>
							<td> @if($user->status == 1) <span class="badge bg-success">Yes</span> @else <span class="badge bg-danger">No</span> @endif</td>
							<td>
								<a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $user->id }}" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i> Edit</a>
								<a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $user->id }}" data-original-title="Delete Product" class="delete btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i> Delete</a>
							</td>
						</tr>
						@endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>
</div>

@include('view-modals/user_addedit')

@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable();


		$('#createNewProduct').click(function () {
		    reset_modal();
		
		    $('#saveBtn').val("Create");
		    $('#status').val('').trigger("chosen:updated");
		    $('#user_id').val('').trigger("chosen:updated");
		    $('#dataForm').trigger("reset");
		    $('#modelHeading').html("Create New User");
		    $('#ajaxModel').modal('show');
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();

		  $.get("{{ url('user/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Edit User");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#user_id').val(data.id);
		      $('#name').val(data.name);
		      $('#email').val(data.email);
		      $('#phone').val(data.phone);
		      $('#roles').val(data.role);
		      $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');
		  })
		});





	$('#saveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Sending..');

		if($('#user_id').val() == "") {
			var txt = "Create";
		}
		else {
			var txt = "Update";
		}

        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to '+txt+' this User?',

            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: txt+" Category!",
                    closeModal: false,
                }
            },

        })
        .then(confirm => {

            if(confirm) {
				$('#dataForm').submit();
            }
            else {
                swal("Oh noes!", "Process Cancelled!", "error"); 
				$('#ajaxModel').modal('hide');
            }
        })
        .catch(err => {
            if (err) {
                swal("Oh noes!", "The AJAX request failed!", "error");
				console.log(err);
				$('#ajaxModel').modal('hide');
            } else {
                swal.stopLoading();
                swal.close();
            }
        });        
    });




	$("#dataForm").validate({

		errorClass: "is-invalid",

		unhighlight: function(element, errorClass, validClass) {
			$(element).removeClass(errorClass);
			$(element).parent().removeClass(errorClass);
		},

		errorPlacement: function(error, element) {
			element.parent().append(error);
			$('.standardSelect').selectpicker('refresh');
			swal.close();
		},


		rules: {
			name: 'required',
			email: 'required',
			roles: 'required',
			status: 'required',
		},

		messages: {
			name: "Please Enter Category Name.",
			email: "Please Select Parent Category.",
			roles: "Please Enter Description.",
			status: "Please Select Status.",
		},

		submitHandler: function(form) {
			// form.submit();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#saveBtn').html('Sending..');

			
			var user_id = $('#user_id').val();

			var route = '';

			if(user_id == '') {
				route = "{{ url('user/store') }}"
			}
			else {
				route = "{{ url('user/update') }}"+'/'+user_id
			}

			$.ajax({
					data: $('#dataForm').serialize(),
					url: route,
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
						swal.close();
						$('#saveBtn').html('Save Changes');
					}
				});
			}
		});




		$('body').on('click', '.deleteProduct', function () {

		    var product_id = $(this).data("id");

		    swal({
		    	title: "Are you sure?",
				text: "Once deleted, you will not be able to recover this category!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
		    })
			.then((willDelete) => {
  				if (willDelete) {

					$.ajax({
				        type: "GET",
				        url: "{{ url('user/delete') }}"+'/'+product_id,
				        success: function (data) {
				            table.draw();
				            swal("Great! User has been deleted!", {
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
					swal("Your Expense Category delete request Cancelled!")
				}

			})


		});

		$('.standardSelect').selectpicker('refresh');

    });


    function reset_modal() {
    	$("#cat_id").val("");
    	$("#name").val("");
    	$('#p_id').val("");
    	$('#description').val("");
        // $("#name").removeClass("is-invalid");
        // $("#status").removeClass("is-invalid");
        // $("#name-error").html("");
        // $("#status-error").html("");
		
        $('#saveBtn').html('Save Changes');

		$('#dataForm').validate().resetForm();
		$('#dataForm').find('.error').removeClass('error');
		$('#dataForm').find('.is-invalid').removeClass('is-invalid');


		$('.standardSelect').selectpicker('refresh');
    }

</script>

@endsection

