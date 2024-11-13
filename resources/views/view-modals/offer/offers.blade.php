@extends('layouts.app')
@section('content')

	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title">Offers <small> List & Management</small></h1>

			<button type="button" class="modal-effect btn btn-primary d-grid mb-3" data-bs-effect="effect-scale" data-bs-toggle="modal" id="createNewProduct" data-bs-target="#ajaxModel"> Add Offer</button>

		</div>
			   
			    
			    
		
		<div class="card radius-10">
			<div class="card-body">
						<div class="table-responsive">
							<table class="table app-table-hover mb-0 text-left category-table">
								<thead>
									<tr>
										<th class="cell">Sr.</th>
										<th class="cell">Offer</th>
										<th class="cell">Code</th>
										<th class="cell">Start date</th>
										<th class="cell">End Date</th>
										<th class="cell">Banner</th>
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
@include('modals/offer_addedit') 
@include('modals/gift_add') 

@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

		// $(".standardSelect").selectpicker();

        // $('.standardSelect').on('change', function () {
        //     $(this).valid();
        //     $('.standardSelect').selectpicker('refresh');
        // });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        
		var table = $('.category-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getOffersData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'offer_title', name: 'offer_title'},
		        {data: 'offer_code', name: 'offer_code'},
		        {data: 'valid_from', name: 'valid_from'},
		        {data: 'valid_till', name: 'valid_till'},
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

		$('#createNewProduct').click(function () {
		    reset_modal();
		    $('#saveBtn').val("Create");
		    $('#status').val('').trigger("chosen:updated");
		    $('#dataForm').trigger("reset");
		    $('#modelHeading').html("Create New Offer");
			$('#ajaxModel').modal('show');
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('offer/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Edit category");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#offer_id').val(data.id);
		      $('#title').val(data.title);
		      $('#start_date').val(data.start_date);
		      $('#end_date').val(data.end_date);
			  var imageUrl = "{{ url('offer/') }}" + '/' + data.banner;
              $('#banner').attr('src', imageUrl);
		      $('#offer_code').val(data.offer_code);
		      $('#description').val(data.description);
		      $('#terms').val(data.terms);
		      $('#status').val(data.status);
			  // $('.standardSelect').selectpicker('refresh');
		  })
		});


		$('body').on('click', '.addkyc', function () {
		  var product_id = $(this).data('id');
		  reset_kyc();
		      $('#modelHeadingKyc').html("Add Gift");
		      $('#saveBtnKyc').val("Save Gift");
		      $('#ajaxModelKyc').modal('show');
		      $('#giftoffer_id').val(product_id);
		  })

		$('#saveBtn').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');

    var formData = new FormData($('#dataForm')[0]);

    $.ajax({
        data: formData,
        url: "{{ url('offer/store') }}",
        type: "POST",
        dataType: 'json',
        contentType: false, // Important for sending files
        processData: false, // Important for sending files

        success: function (data) {
            $('#dataForm').trigger("reset");
            $('#ajaxModel').modal('hide');
                table.draw();
        },
        error: function (data) {
            if (data.status == 422) {
                var x = data.responseJSON;
                $.each(x.errors, function (index, value) {
                    $("#" + index).addClass("is-invalid");
                    $("#" + index + "-error").html(value[0]);
                });
            }
            $('#saveBtn').html('Save Changes');
        }
    });
});


$('#saveBtnKyc').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');

    var formData = new FormData($('#dataFormKyc')[0]);

    $.ajax({
        data: formData,
        url: "{{ url('gift/store') }}",
        type: "POST",
        dataType: 'json',
        contentType: false, // Important for sending files
        processData: false, // Important for sending files

        success: function (data) {
            $('#dataFormKyc').trigger("reset");
            $('#ajaxModelKyc').modal('hide');
                table.draw();
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



		$('body').on('click', '.deleteProduct', function () {

		    var product_id = $(this).data("id");

		    
			$.ajax({
				type: "GET",
				url: "{{ url('offer/delete') }}"+'/'+product_id,
				success: function (data) {
					table.draw();
					swal("Great! Offer has been deleted!", {
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
	function reset_kyc()
	{
		$("#giftoffer_id").val("");
    	$("#gift_status").val("");
    	$("#points").val("");
    	$("#gift_title").val("");
    	$("#specitfication").val("");
    	$("#image").val("");

		$("#gift_status").removeClass("is-invalid");
		$("#points").removeClass("is-invalid");
		$("#gift_title").removeClass("is-invalid");
		$("#specitfication").removeClass("is-invalid");
		$("#image").removeClass("is-invalid");

		$("#gift_status-error").html("");
        $("#points-error").html("");
        $("#gift_title-error").html("");
        $("#specitfication-error").html("");
        $("#image-error").html("");
		
		$('#ajaxModelKyc').modal('hide');
	}

    function reset_modal() {
    	$("#offer_id").val("");
    	$("#title").val("");
    	$("#offer_code").val("");
    	$("#banner").val("");
    	$("#start_date").val("");
    	$("#end_date").val("");
    	$("#terms").val("");
    	$("#description").val("");
    	$('#status').val("");
		$('#ajaxModel').modal('hide');

        $("#title").removeClass("is-invalid");
        $("#offer_code").removeClass("is-invalid");
        $("#start_date").removeClass("is-invalid");
        $("#end_date").removeClass("is-invalid");
        $("#terms").removeClass("is-invalid");
        $("#description").removeClass("is-invalid");
        $("#banner").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#title-error").html("");
        $("#offer_code-error").html("");
        $("#banner-error").html("");
        $("#start_date-error").html("");
        $("#end_date-error").html("");
        $("#terms-error").html("");
        $("#description-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');		
		// $('.standardSelect').selectpicker('refresh');
    }

</script>
@stop
