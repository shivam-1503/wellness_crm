@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Expense Categories <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Expense Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage</li>
        </ol>
    </div>

    <div class="float-end">
		@can('create-expense-header')
			<a class="btn btn-primary float-end" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-plus"></i> Create Expense Category</a>
		@endcan
    </div>

</div>
<!-- PAGE-HEADER END -->



	<div class="content mt-3">

        <!-- Default box -->
        <div class="card">

        	<div class="card-header">
        		Expense Categories List
        	</div>

            <div class="card-body">
                <table class="table table-bordered table-hover data-table" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Title</th>
                            <th>Parent Category</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Last Update</th>
                            <th width="180px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->
    </div>

	@include('view-modals/expanse_category_addedit')

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

		var table = $('.data-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getExpanseCategoriesData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'name', name: 'name'},
		        {data: 'parent', name: 'parent'},
		        {data: 'description', name: 'description'},
		        {data: 'status', name: 'status', orderable: false, searchable: false},
		        {data: 'updated_at', name: 'status', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    }
		});

		$('#createNewProduct').click(function () {
		    reset_modal();
		
		    $('#saveBtn').val("Create");
		    $('#status').val('').trigger("chosen:updated");
		    $('#p_id').val('').trigger("chosen:updated");
		    $('#dataForm').trigger("reset");
		    $('#modelHeading').html("Create New Expense Category");
		    $('#ajaxModel').modal('show');
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();

		  $.get("{{ url('expanse_category/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Edit Expense Category");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#cat_id').val(data.id);
		      $('#name').val(data.name);
		      $('#p_id').val(data.p_id);
		      $('#description').val(data.description);
		      $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');
		  })
		});





	$('#saveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Sending..');

		if($('#cat_id').val() == "") {
			var txt = "Create";
		}
		else {
			var txt = "Update";
		}

        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to '+txt+' this Category?',

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
			description: 'required',
			status: 'required',
		},

		messages: {
			name: "Please Enter Category Name.",
			p_id: "Please Select Parent Category.",
			description: "Please Enter Description.",
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

			$.ajax({
					data: $('#dataForm').serialize(),
					url: "{{ url('expanse_category/store') }}",
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
				        url: "{{ url('expanse_category/delete') }}"+'/'+product_id,
				        success: function (data) {
				            table.draw();
				            swal("Great! Expense Category has been deleted!", {
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
@stop
