@extends('layouts.app')
@section('content')

	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title"> Product Categories <small> List & Management</small></h1>

			<button type="button" class="modal-effect btn btn-primary d-grid mb-3" data-bs-effect="effect-scale" data-bs-toggle="modal" id="createNewProduct" data-bs-target="#ProgramModel"> Add Category</button>

		</div>
		
		
		<div class="card radius-10">
			<div class="card-body">
				
				<div class="table-responsive">

					<table  class="table table-bordered text-nowrap border-bottom data-table w-100">
						<thead>
							<tr>
								<th class="border-bottom-0">Sr.</th>
                                <th class="border-bottom-0">Parent category</th>
								<th class="border-bottom-0">Category Name</th>
								<th class="border-bottom-0">Short Code</th>
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

	@include('products/category_addedit')
	

@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

		// $(".standardSelect").selectpicker();

        // $('.standardSelect').on('change', function () {
        //     // $(this).valid();
        //     $('.standardSelect').selectpicker('refresh');
        // });

		$('#p_id').select2({
			placeholder: 'Select Parent Category',
		});

		$('#status').select2({
			placeholder: 'Select Status',
		});

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

		var table = $('.data-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getCategoriesData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'p_id', name: 'p_id'},
				{data: 'name', name: 'name'},
				{data: 'short_code', name: 'short_code'},
		        {data: 'status', name: 'status', orderable: false, searchable: false},
		        {data: 'updated_at', name: 'Last Update', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
				
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    }
		});

		$('#createNewProduct').click(function () {
		    reset_modal();
		    $('#ProgramBtn').val("Create");
		    $('#status').val('').trigger("change");
		    $('#p_id').val('').trigger("change");
		    $('#programForm').trigger("reset");
		    $('#ProgramHeading').html("Create New Product Category");
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('product_category/edit') }}" +'/' + product_id, function (data) {
		      $('#ProgramHeading').html("Edit Product Category");
		      $('#ProgramBtn').val("Save Category");
		      $('#ProgramModel').modal('show');
			  $('#category_id').val(data.id);
		      $('#p_id').val(data.p_id).trigger('change');
		      $('#name').val(data.name);
		      $('#short_code').val(data.short_code);
		      $('#description').val(data.description);
		      $('#status').val(data.status).trigger('change');

			  // $('.standardSelect').selectpicker('refresh');
		  })
		});



		if ($("#programForm").length > 0) {
			
			$("#programForm").validate({

				errorClass: "is-invalid",

				unhighlight: function(element, errorClass, validClass) {
					$(element).removeClass(errorClass);
					$(element).parent().removeClass(errorClass);
				},

				errorPlacement: function(error, element) {
					element.parent().append( error );
					// $('.standardSelect').selectpicker('refresh');
				},

				rules: {
					name: 'required',
					description: 'required',
					statuses: 'required',
				
				},

				messages: {
					name: "Please enter category name.",
					description: "Please Enter description.",
					statuses: "Please Select Status.",
				},



				submitHandler: function(form) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$('#ProgramBtn').html('Sending..');
                    var vals = $("#programForm").serializeArray();
							
                    // var vals = $("#dataForm").find('input,select').serializeArray();
                    // vals.push({name: 'description', value: CKEDITOR.instances.description.getData()});
                    // vals.push({name: 'salient_feature', value: CKEDITOR.instances.salient_feature.getData()});

					$.ajax({
						data: vals,
						url: "{{ url('product_category/store') }}",
						type: "POST",
						dataType: 'json',

						success: function (data) {
							$('#ProgramModel').modal('hide');
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
									// $('.standardSelect').selectpicker('refresh');
									$("#"+index+"-error").html(value[0]);
								});
							}
							$('#ProgramBtn').html('Save Category');
						}
					});

				}
			})
		}

        






		$('body').on('click', '.deleteProduct', function () {

		    var product_id = $(this).data("id");

			swal({title: "Are You Sure", 
				text: "You want to delete this record?",  
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

                    swal({    title: "Deleting Data ...", text: "Record Deletion in Progress..", icon: "success",  showConfirmButton: false });
					$.ajax({type: "GET", url: "{{ url('product_category/delete') }}"+'/'+product_id,
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

		// $('.standardSelect').selectpicker('refresh');

    });


    function reset_modal() {
    	
		$("#category_id").val("");

		$("#p_id").val("").trigger('change');
		$("#name").val("");
		$("#description").val("");
		$("#status").val("").trigger('change');
		$("#short_code").val("");

		$('#ProgramModel').modal('hide');


		$("#p_id").removeClass("is-invalid");
		$("#name").removeClass("is-invalid");
		$("#description").removeClass("is-invalid");
		$("#status").removeClass("is-invalid");
		$("#short_code").removeClass("is-invalid");


		$("#p_id-error").html("");
		$("#name-error").html("");
		$("#description-error").html("");
		$("#status-error").html("");
		$("#short_code-error").html("");


		$('#saveBtn').html('Save Changes');
		$('#ProgramBtn').html('Save Program');
		// $('.standardSelect').selectpicker('refresh');
    }

</script>
@stop
