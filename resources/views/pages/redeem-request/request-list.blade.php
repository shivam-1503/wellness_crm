@extends('layouts.app')
@section('content')

	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title">Redeem Requests <small> List & Management</small></h1>
		</div>
		
		
		<div class="card radius-10">
			<div class="card-body">
				
				<div class="table-responsive">

					<table  class="table table-bordered text-nowrap border-bottom data-table w-100">
						<thead>
							<tr>
								<th class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">User Name</th>
                                <th class="border-bottom-0">Phone</th>
                                <th class="border-bottom-0">Offer</th>
                                <th class="border-bottom-0">Gift</th>
                                <th class="border-bottom-0">Points</th>
								<th class="border-bottom-0">Status</th>
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
    @include('modals/process_redeem_request') 
@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

		// $(".standardSelect").selectpicker();

        $('.standardSelect').on('change', function () {
            // $(this).valid();
            // $('.standardSelect').selectpicker('refresh');
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
		    ajax: "{{ url('getRedeemRequestsData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'user', name: 'user'},
		        {data: 'phone', name: 'phone', orderable: false, searchable: false},
		        {data: 'offer', name: 'offer', orderable: false, searchable: false},
		        {data: 'gift', name: 'gift', orderable: false, searchable: false},
		        {data: 'points', name: 'points', orderable: false, searchable: false},
		        {data: 'status', name: 'status', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    }
		});




        /** 
		 * Edit the Dealer Section
		 * Parameter: dealer_id
		 * **/
		$('body').on('click', '.editProduct', function () {
		  	var product_id = $(this).data('id');
		  	$('#modelHeading').html("Edit category");
            $('#saveBtn').val("Save Changes");
            $('#ajaxModel').modal('show');
            $('#request_id').val(product_id);
		});




        /** 
		 * Create & Update the Dealer
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
					status: 'required',
				},

				messages: {
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
						url: "{{ url('request/update_status') }}",
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




    });


    function reset_modal()
	{
		$("#request_id").val("");
    	// $("#status").val("").trigger('change');
		$('#ajaxModel').modal('hide');
	}
</script>
@stop
