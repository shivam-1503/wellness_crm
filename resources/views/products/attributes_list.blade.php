@extends('layouts.app')
@section('content')

	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title"> Attributes <small> List & Management</small></h1>

			<button type="button" class="modal-effect btn btn-primary d-grid mb-3" data-bs-effect="effect-scale" data-bs-toggle="modal" id="createNewProduct" data-bs-target="#ProgramModel"> Add Attribute</button>

		</div>
		
		
		<div class="card radius-10">
			<div class="card-body">
				
				<div class="table-responsive">

					<table  class="table table-bordered text-nowrap border-bottom data-table w-100">
						<thead>
							<tr>
								<th class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">Attribute</th>
								<th class="border-bottom-0">Value</th>
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

	@include('products/attributes_addedit')
	

@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

		// $(".standardSelect").select2();

        // $('.standardSelect').on('change', function () {
        //     // $(this).valid();
        //     // $('.standardSelect').selectpicker('refresh');
        // });

		$( '.select2' ).select2( {
			theme: 'bootstrap-5',
		} );

	$('#attribute_id').select2({
        placeholder: 'Select Attribute',
    });

	

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

		$('#status').select2({
			placeholder: 'Select Status',
		});

		var table = $('.data-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getAttributesData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'family', name: 'family'},
				{data: 'value', name: 'value'},
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
		    $('#attribute_id').val('').trigger("change");
		    $('#status').val('').trigger("change");
		    $('#programForm').trigger("reset");
		    $('#ProgramHeading').html("Create New Attribute Value");
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('attribute/edit') }}" +'/' + product_id, function (data) {
		      $('#ProgramHeading').html("Edit Attribute Details");
		      $('#ProgramBtn').val("Save Attribute Value");
		      $('#ProgramModel').modal('show');
			  $('#attribute_value_id').val(data.id);
		      $('#attribute_id').val(data.attribute_id).trigger('change');
		      $('#value').val(data.value);
		      $('#status').val(data.status).trigger('change');

			  // $('#status').select2();
			  // $('#status').val(null).trigger('change');

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
					attribute_family_: 'required',
					value: 'required',
					status: 'required',
				
				},

				messages: {
					attribute_family_: "Please Select Attribute Family.",
					value: "Please enter Value.",
					status: "Please Select Status.",
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
						url: "{{ url('attribute/store') }}",
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
				text: "You want to Delete this Record?",  
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

                    swal({    title: "Deleting Data ...", text: "Record deletion is in process.", icon: "success",  showConfirmButton: false });
					$.ajax({type: "GET", url: "{{ url('attribute/delete') }}"+'/'+product_id,
						success: function (data) {
							swal({   
								title: "Good Job!",   
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


    function reset_modal() 
	{	
		$("#attribute_value_id").val("");

		$("#attribute_id").val("").trigger('change');
		$("#value").val("");
		$("#status").val("").trigger('change');

		$('#ProgramModel').modal('hide');

		$("#attribute_id").removeClass("is-invalid");
		$("#value").removeClass("is-invalid");
		$("#status").removeClass("is-invalid");


		$("#attribute_id-error").html("");
		$("#value-error").html("");
		$("#status-error").html("");

        $('#saveBtn').html('Save Changes');
		$('#ProgramBtn').html('Save Program');
		// $('.standardSelect').selectpicker('refresh');
	}

</script>
@stop
