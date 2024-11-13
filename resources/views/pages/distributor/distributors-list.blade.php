@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <h1>Distributors <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
		<a class="btn btn-primary float-right" href="javascript:void(0)" id="createNewProduct"> Create New Distributor</a>
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
								<th class="border-bottom-0">Distributor Name</th>
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

    @include('view-modals/distributor_addedit') 
    @include('view-modals/kyc_add') 

@stop

@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

		$(".standardSelect").selectpicker();

        

		// $('#type_id').select2({
		// 	placeholder: 'Select User Type',
		// });
		// $('#present_state_id').select2({
		// 	placeholder: 'Select Present State',
		// });
		// $('#present_district_id').select2({
		// 	placeholder: 'Select Present District',
		// });
		// $('#permanent_state_id').select2({
		// 	placeholder: 'Select Permanent State',
		// });
		// $('#permanent_district_id').select2({
		// 	placeholder: 'Select Permanent District',
		// });
		// $('#status').select2({
		// 	placeholder: 'Select Status',
		// });
		// $('#kyc_document_id').select2({
		// 	placeholder: 'Select KYC Document Type',
		// });
		


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		var table = $('.data-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getDistributorsData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'name', name: 'name'},
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
		    $('#saveBtn').val("Create");
		    $('#status').val('').trigger("chosen:updated");
		    $('#dataForm').trigger("reset");
		    $('#modelHeading').html("Create New Distributor");
			$('#ajaxModel').modal('show');
		});


		/** 
		 * Edit the distributor Section
		 * Parameter: distributor_id
		 * **/
		$('body').on('click', '.editProduct', function () {
		  	var product_id = $(this).data('id');
		  	reset_modal();
		  	$.get("{{ url('distributor/edit') }}" +'/' + product_id, function (data) {
				$('#modelHeading').html("Edit Distributor");
				$('#saveBtn').val("Save Changes");
				$('#ajaxModel').modal('show');
				$('#distributor_id').val(data.id);
				$('#name').val(data.name);
				$('#email').val(data.email);
				$('#date_of_birth').val(data.date_of_birth);
				$('#aadhar').val(data.aadhar);
				$('#type_id').val(data.type_id);
				$('#rating').val(data.rating);
				$('#mobile').val(data.mobile);
				$('#permanent_address').val(data.permanent_address);
				$('#permanent_state_id').val(data.permanent_state_id).trigger('change');
				$('#permanent_district_id').val(data.permanent_district_id).trigger('change');
				$('#permanent_city').val(data.permanent_city);
				$('#permanent_pincode').val(data.permanent_pincode);
				$('#present_address').val(data.present_address);
				$('#present_state_id').val(data.present_state_id).trigger('change');
				$('#present_district_id').val(data.present_district_id).trigger('change');
				$('#present_city').val(data.present_city);
				$('#present_pincode').val(data.present_pincode);
				$('#status').val(data.status).trigger('change');
				//   $('.standardSelect').selectpicker('refresh');

				setTimeout(function () {
					$('#present_district_id').val(data.present_district_id).trigger('change');
					$('#permanent_district_id').val(data.permanent_district_id).trigger('change');
				}, 1000);
		  	})
		});

		
		/** 
		 * KYC Modal of the distributor
		 * Parameter: distributor_id
		 * **/
        $('body').on('click', '.addkyc', function () {
		  var product_id = $(this).data('id');
		  var product = $(this).data('type');
		  reset_kyc();
		      $('#modelHeadingKyc').html("Please Complete Your KYC");
		      $('#saveBtnKyc').val("Save Kyc");
		      $('#ajaxModelKyc').modal('show');
		      $('#user_id').val(product_id);
		      $('#user_type').val(product);
		  })



		/** 
		 * Create & Update the distributor
		 * Parameter: Form data
		 * **/
		if ($("#dataForm").length > 0) {
			
			$("#dataForm").validate({

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
					email: 'required',
					date_of_birth: 'required',
					mobile: 'required',
					permanent_address: 'required',
					permanent_state_id: 'required',
					permanent_district_id: 'required',
					permanent_city: 'required',
					permanent_pincode: 'required',
					present_address: 'required',
					present_state_id: 'required',
					present_district_id: 'required',
					present_city: 'required',
					present_pincode: 'required',
					status: 'required',
				},

				messages: {
					name: "Please enter category name.",
					email: "Please Enter description.",
					date_of_birth: "Please Select Status.",
					mobile: "Please Select Status.",
					permanent_address: "Please Select Status.",
					permanent_state_id: "Please Select Status.",
					permanent_district_id: "Please Select Status.",
					permanent_city: "Please Select Status.",
					permanent_pincode: "Please Select Status.",
					present_address: "Please Select Status.",
					present_state_id: "Please Select Status.",
					present_district_id: "Please Select Status.",
					present_city: "Please Select Status.",
					present_pincode: "Please Select Status.",
					status: "Please Select Status.",
				},



				submitHandler: function(form) {

					// form.preventDefault();

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
						url: "{{ url('distributor/store') }}",
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
									// $('.standardSelect').selectpicker('refresh');
									$("#"+index+"-error").html(value[0]);
								});
							}
							$('#saveBtn').html('Save Category');
						}
					});

				}
			})
		}


		$('#saveBtnKyc').click(function (e) {
			e.preventDefault();
			$(this).html('Sending..');

			var formData = new FormData($('#dataFormKyc')[0]);

			$.ajax({
				data: formData,
				url: "{{ url('kyc/storenew') }}",
				type: "POST",
				dataType: 'json',
				contentType: false, // Important for sending files
				processData: false, // Important for sending files

				success: function (data) {
					$('#dataFormKyc').trigger("reset");
					$('#ajaxModelKyc').modal('hide');
					table.draw();
					swal("Great! KYC has been Registered!", {
						icon: "success",
					});
				},
				error: function (data) {
					if (data.status == 422) {
						var x = data.responseJSON;
						$.each(x.errors, function (index, value) {
							$("#" + index).addClass("is-invalid");
							$("#" + index + "-error").html(value[0]);
						});
					}
					$('#saveBtnKyc').html('Save Changes');
				}
			});
		});




		/** 
		 * Delete the distributor
		 * Parameter: distributor_id
		 * **/
		$('body').on('click', '.deleteProduct', function () {

		    var product_id = $(this).data("id");

		    
			$.ajax({
				type: "GET",
				url: "{{ url('distributor/delete') }}"+'/'+product_id,
				success: function (data) {
					table.draw();
					swal("Great! distributor has been deleted!", {
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



	/** 
	 * Populate the Permanent District Dropdown
	 * Parameter: permanent_state_id
	 * **/
	$("#permanent_state_id").change(function () {
		var selectedState = $(this).val();
		$("#permanent_district_id").empty();

		$.ajax({
			url: "{{ url('dealer/finddistrict') }}" + '/' + selectedState,
			type: "GET",
			success: function (data) {

				var options_htm = '<option value="">Select District</option>';
				$.each(data, function (key, val) {
					options_htm += '<option value="' + key + '">' + val + '</option>';
				});
				$('#permanent_district_id').html(options_htm);
				$('#permanent_district_id').selectpicker('refresh');

			},
			error: function (data) {
				if (data.status == 422) {
					console.log(error);
				}
			}
		});
	});


	/** 
	 * Populate the Present District Dropdown
	 * Parameter: present_state_id
	 * **/
	$("#present_state_id").change(function () {
		var selectedState = $(this).val();
		$("#present_district_id").empty();

		$.ajax({
			url: "{{ url('dealer/finddistrict') }}" + '/' + selectedState,
			type: "GET",
			success: function (data) {

				var options_htm = '<option value="">Select District</option>';
				$.each(data, function (key, val) {
					options_htm += '<option value="' + key + '">' + val + '<option>';
				});
				$('#present_district_id').html(options_htm);
				$('#present_district_id').selectpicker('refresh');

			},
			error: function (data) {
				if (data.status == 422) {
					console.log(error);
				}
			}
		});
	});


	/** 
	 * Reset KYC Modal
	 * **/
	function reset_kyc()
	{
		$("#user_id").val("");
    	$("#user_type").val("");
    	$("#kyc_document_id").val("").trigger('change');;
    	$("#kyc_document_no").val("");
    	$("#kyc_document_image").val("");

		$("#kyc_document_id").removeClass("is-invalid");
		$("#kyc_document_no").removeClass("is-invalid");
		$("#kyc_document_image").removeClass("is-invalid");

		$("#kyc_document_id-error").html("");
        $("#kyc_document_no-error").html("");
        $("#kyc_document_image-error").html("");
		$('#ajaxModelKyc').modal('hide');
	}




	/** 
	 * Reset distributor Modal
	 * **/
    function reset_modal() {
    	$("#distributor_id").val("");
    	$("#name").val("");
    	$("#date_of_birth").val("");
    	$("#email").val("");
    	$("#aadhar").val("");
    	$("#mobile").val("");
    	$("#rating").val("");
    	$("#type_id").val("");
    	$("#permanent_address").val("");
    	$("#permanent_state_id").val("");
    	$("#permanent_district_id").val("");
    	$("#permanent_city").val("");
    	$("#permanent_pincode").val("");
    	$("#present_address").val("");
    	$("#present_state_id").val("");
    	$("#present_district_id").val("");
    	$("#present_city").val("");
    	$("#present_pincode").val("");
    	$('#status').val("").trigger('change');;
		$('#ajaxModel').modal('hide');

        $("#name").removeClass("is-invalid");
        $("#date_of_birth").removeClass("is-invalid");
        $("#email").removeClass("is-invalid");
        $("#aadhar").removeClass("is-invalid");
        $("#mobile").removeClass("is-invalid");
        $("#rating").removeClass("is-invalid");
        $("#type_id").removeClass("is-invalid");
        $("#permanent_address").removeClass("is-invalid");
        $("#permanent_state_id").removeClass("is-invalid");
        $("#permanent_district_id").removeClass("is-invalid");
        $("#permanent_city").removeClass("is-invalid");
        $("#permanent_pincode").removeClass("is-invalid");
        $("#present_address").removeClass("is-invalid");
        $("#present_state_id").removeClass("is-invalid");
        $("#present_district_id").removeClass("is-invalid");
        $("#present_city").removeClass("is-invalid");
        $("#present_pincode").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#name-error").html("");
        $("#date_of_birth-error").html("");
        $("#email-error").html("");
        $("#aadhar-error").html("");
        $("#mobile-error").html("");
        $("#rating-error").html("");
        $("#type_id-error").html("");
        $("#permanent_address-error").html("");
        $("#permanent_state_id-error").html("");
        $("#permanent_district_id-error").html("");
        $("#permanent_city-error").html("");
        $("#permanent_pincode-error").html("");
        $("#present_address-error").html("");
        $("#present_state_id-error").html("");
        $("#present_district_id-error").html("");
        $("#present_city-error").html("");
        $("#present_pincode-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');		
		// $('.standardSelect').selectpicker('refresh');
    }


</script>
@stop
