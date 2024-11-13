@extends('layouts.app')

@section('content')
<style>
	   /* Style the Image Used to Trigger the Modal */
	   img {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

img:hover {opacity: 0.7;}

/* The Modal (background) */
#image-viewer {
    display: none;
    position: fixed;
    z-index: 9999;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.9);
}
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}
.modal-content { 
    animation-name: zoom;
    animation-duration: 0.6s;
}
@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}
#image-viewer .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}
#image-viewer .close:hover,
#image-viewer .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}



</style>


<div class="page-header">
    <div>
        <h1>KYCs <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
		<!-- <a class="btn btn-primary float-right" href="javascript:void(0)" id="createNewProduct"> Create New Distributor</a> -->
    </div>

</div>
<!-- PAGE-HEADER END -->


<div class="content mt-3">
		
			    
			    
				<div class="card app-card app-card-orders-table shadow-sm mb-5">
					<div class="card-body app-card-body">
						<div class="table-responsive">
							<table  class="table table-bordered text-nowrap border-bottom data-table w-100">
								<thead>
									<tr>
										<th class="cell">ID</th>
										<th class="cell">Name</th>
										<th class="cell">User Type</th>
										<th class="cell">Image</th>
										<th class="cell">Status</th>
										<th class="cell">Updated_at</th>
										<th class="cell">Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div><!--//table-responsive-->
						
					</div><!--//app-card-body-->		
				</div>


    
			    
		    </div>
	    </div>
    </div>
</div>




<div id="image-viewer">
	<span class="close">&times;</span>
	<img class="modal-content" id="full-image">
</div>


@include('view-modals/kyc_edit')
@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

		$(".standardSelect").selectpicker();

        $('.standardSelect').on('change', function () {
            // $(this).valid();
            // $('.standardSelect').selectpicker('refresh');
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




		$(".images img").click(function(){
			alert("hello")
			$("#full-image").attr("src", $(this).attr("src"));
			$('#image-viewer').show();
		});

		$("#image-viewer .close").click(function(){
			$('#image-viewer').hide();
		});


		var table = $('.data-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getKycsData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'title', name: 'title'},
		        {data: 'user_type', name: 'user_type'},
		        {data: 'image', name: 'image', orderable: false, searchable: false},
		        {data: 'status', name: 'status', orderable: false, searchable: false},
		        {data: 'updated_at', name: 'Last Update', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    }
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  var product_name = $(this).data('name');
		  reset_modal();
		  $.get("{{ url('kyc/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Audit KYC Details");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#kyc_id').val(data.id);
		      $('#name_kyc').empty();
		      $('#name_kyc').text(product_name);
		      $('#ref_kyc').empty();
		      $('#ref_kyc').text(data.kyc_ref_no);
		      $('#kyc_number').empty();
		      $('#kyc_number').text(data.kyc_document_no);
			  $('#kyc_type').empty();
			  var type = {1: 'Aadhar Card',2: 'Pan Card',3: 'Voter Card',4: 'Passport'};
		      $('#kyc_type').text(type[data.kyc_document_id]);
			  $('.images').empty();
			  var $image = $('<img>').attr('src', "{{ asset('kyc')}}/" + data.kyc_document_image).attr('alt', '').attr('height', '100').attr('width', '100');
		      $('.images').html($image);
		      $('#status').val(data.status).trigger('change');
			  $('.standardSelect').selectpicker('refresh');
		  })
		});



		$('#saveBtn').click(function (e) {
			e.preventDefault();
			$(this).html('Sending..');

			var formData = new FormData($('#dataForm')[0]);

			swal({title: "Are You Sure", 
				text: "You want to update the KYC status?",  
				type: "warning", icon: "warning",   
				showCancelButton: true,    
				confirmButtonColor: "#e6b034",  
				buttons: {
							cancel: "Cancel",
							confirm: {
								text: "Update Status",
								closeModal: false,
							}
						},
				closeOnConfirm: false, 
				closeOnCancel: true })

			.then (isConfirm => {

				if(isConfirm){

					swal({    title: "Processing Data ...", text: "Record Updation in Progress..", icon: "success",  showConfirmButton: false });
					$.ajax({
						data: formData,
						url: "{{ url('kyc/store') }}",
						type: "POST",
						dataType: 'json',
						contentType: false, // Important for sending files
						processData: false, // Important for sending files

						success: function (data) {
							$('#dataForm').trigger("reset");
							$('#ajaxModel').modal('hide');
							swal({   
								title: "Good job!",
								text: data.msg,
								icon: "success",
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

		
		
		// $('#saveBtn').click(function (e) {
		// 	e.preventDefault();
		// 	$(this).html('Sending..');

		// 	var formData = new FormData($('#dataForm')[0]);

		// 	$.ajax({
		// 		data: formData,
		// 		url: "{{ url('kyc/store') }}",
		// 		type: "POST",
		// 		dataType: 'json',
		// 		contentType: false, // Important for sending files
		// 		processData: false, // Important for sending files

		// 		success: function (data) {
		// 			$('#dataForm').trigger("reset");
		// 			$('#ajaxModel').modal('hide');
		// 				table.draw();
		// 		},
		// 		error: function (data) {
		// 			if (data.status == 422) {
		// 				var x = data.responseJSON;
		// 				$.each(x.errors, function (index, value) {
		// 					$("#" + index).addClass("is-invalid");
		// 					$("#" + index + "-error").html(value[0]);
		// 				});
		// 			}
		// 			$('#saveBtn').html('Save Changes');
		// 		}
		// 	});
		// });




		$('body').on('click', '.deleteProduct', function () {

		    var product_id = $(this).data("id");

		    
			$.ajax({
				type: "GET",
				url: "{{ url('category/delete') }}"+'/'+product_id,
				success: function (data) {
					table.draw();
					swal("Great! Designation has been deleted!", {
						icon: "success",
					});
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
			// swal({   title: "Are You Sure", text: "College Central Management System",  type: "warning",    showCancelButton: true,    confirmButtonColor: "#e6b034",  cancelButtonText: "No", confirmButtonText: "Yes", closeOnConfirm: false, closeOnCancel: true },
			// function (isConfirm){ 
			// 	if(isConfirm){
            //         swal({    title: "Deleting Data ...", text: "Manufacturing Management System",  showConfirmButton: false });
			// 		$.ajax({type: "GET",url: "{{ url('designation/delete') }}"+'/'+product_id,
			// 			success: function (data) {
			// 			swal({   title: data.success ,   type: "success", text: "Manufacturing Management System", confirmButtonColor: "#71aa68",   },function(){table.draw(); });
			// 		},
			// 		error: function (data) {
			// 		console.log('Error:', data);
			// 		}
			// 	});
			// 	}
			// });
			});


		// $('.standardSelect').selectpicker('refresh');

		//$(".standardSelect").select2();

    });


    function reset_modal() {
    	$("#category_id").val("");
    	$("title").val("");
    	$("parent_id").val("");
    	$("image").val("");
    	$('#status').val("");
		$('#ajaxModel').modal('hide');

        $("#title").removeClass("is-invalid");
        $("#parent_id").removeClass("is-invalid");
        $("#image").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#title-error").html("");
        $("#parent_id-error").html("");
        $("#image-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');		
		// $('.standardSelect').selectpicker('refresh');
    }


	function show_img()
	{
		$("#full-image").attr("src", $(".images img").attr("src"));
		$('#image-viewer').show();
	}
</script>
@stop
