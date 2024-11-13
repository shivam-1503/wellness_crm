@extends('layouts.app')
@section('content')




	<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Products <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
		<a class="btn btn-primary float-right" href="{{ url('product/create') }}" id="createNewProduct"> Create Product</a>
    </div>

</div>
<!-- PAGE-HEADER END -->




	<div class="content mt-3">

		<div class="card radius-10">
			<div class="card-body">
				
				<div class="table-responsive">

					<table  class="table table-bordered text-nowrap border-bottom data-table w-100">
						<thead>
							<tr>
								<th class="border-bottom-0">Sr.</th>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Category</th>
								<th class="border-bottom-0">Price</th>
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

	
	

@stop


@section('scripting')

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

		var table = $('.data-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getProductsData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'category', name: 'category'},
				{data: 'unit_price', name: 'unit_price'},
		        {data: 'status', name: 'status', orderable: false, searchable: false},
		        {data: 'updated_at', name: 'Last Update', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
				
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    }
		});

		// $('#createNewProduct').click(function () {
		//     reset_modal();
		//     $('#ProgramBtn').val("Create");
		//     $('#statuses').val('').trigger("chosen:updated");
		//     $('#programForm').trigger("reset");
		//     $('#ProgramHeading').html("Create New Product Category");
		// });


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('product/edit') }}" +'/' + product_id, function (data) {
		      $('#ProgramHeading').html("Edit Product Category");
		      $('#ProgramBtn').val("Save Category");
		      $('#ProgramModel').modal('show');
			  $('#program_id').val(data.id);
		      $('#p_id').val(data.p_id);
		      $('#name').val(data.name);
		      $('#slug').val(data.slug);
		      $('#description').val(data.description);
		      $('#status').val(data.status);

			//   $('.standardSelect').selectpicker('refresh');
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
		


		if ($("#programForm").length > 0) {
			
			$("#programForm").validate({

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
						url: "{{ url('product/store') }}",
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

			swal({
				title: "Are you sure?",
				text: "Once deleted, you will not be able to recover this record!",
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
							swal("Great! Product has been deleted!", {
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

			})


			});

		// $('.standardSelect').selectpicker('refresh');

    });


    function reset_modal() {
    	
		$("#program_id").val("");

$("#clients_id").val("");
$("#title").val("");

$("#statuses").val("");
$("#is_deactive").val("");



$('#ProgramModel').modal('hide');

$("#title").removeClass("is-invalid");

$("#statuses").removeClass("is-invalid");
$("#is_deactive").removeClass("is-invalid");


$("#title-error").html("");


$("#statuses-error").html("");
$("#is_deactive-error").html("");



      

        $('#saveBtn').html('Save Changes');


$('#ProgramBtn').html('Save Program');
		// $('.standardSelect').selectpicker('refresh');
    }

</script>
@stop
