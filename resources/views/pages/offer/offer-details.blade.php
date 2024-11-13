@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <h1>Offers <small>Details</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
		<a class="btn btn-primary float-right" href="{{ url('offers') }}" id="createNewProduct"> Offers List</a>
    </div>

</div>
<!-- PAGE-HEADER END -->


<div class="content mt-3">

		<div class="row">
			<div class="col-md-6">
				<div class="card radius-10">
					<div class="card-body">
						<h5 class="card-title">Offer Details:</h5>
						
                        <div class="row">
							<div class="col-md-12">
                                <div class="table-responsive">

                                    <table  class="table table-bordered text-nowrap border-bottom data-table w-100">
                                        <tr>
                                            <td>Offer Title</td>
                                            <td>{{ $offer->offer_title }}</td>
                                        </tr>
                                        <tr>
                                            <td>Offerr Code</td>
                                            <td>{{ $offer->offer_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Valid From</td>
                                            <td>{{ $offer->valid_from }}</td>
                                        </tr>
                                        <tr>
                                            <td>Valid Till</td>
                                            <td>{{ $offer->valid_till }}</td>
                                        </tr>
                                    </table>
                                </div>
							</div>
						</div>

						
						
						
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card radius-10">
					<div class="card-body">
						<h5 class="card-title">Offer Terms:</h5>
						<div class="row">
							<div class="col-md-12">
								{{ $offer->terms }}
							</div>
						</div>
					</div>
				</div>

                <div class="card radius-10">
					<div class="card-body">
						<h5 class="card-title">Offer Details:</h5>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-12">
									{{ $offer->details }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>

		
		
		
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex justify-content-between">
					<h5 class="card-title">Gifts:</h5>
					<button type="button" class="modal-effect btn btn-primary d-grid addkyc" data-id="{{$offer->id}}" data-bs-effect="effect-scale" data-bs-toggle="modal" id="addkyc" data-bs-target="#addkyc"> Add Gift</button>
				</div>
				<hr>
            
				<div class="table-responsive">
				
				


					<table  class="table table-bordered text-nowrap border-bottom gifts-table w-100">
						<thead>
							<tr>
								<th class="border-bottom-0">Sr.</th>
                                <th class="border-bottom-0">Title</th>
                                <th class="border-bottom-0">Details</th>
								<th class="border-bottom-0">Points</th>
								<th class="border-bottom-0">Image</th>
								<th class="border-bottom-0">Status</th>
								<th class="border-bottom-0">Updated At</th>
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

	@include('view-modals/gift_add') 

@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
		let offer_id = '{{$offer->id}}'
        var table = $('.gifts-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getGiftsData') }}/"+offer_id,
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'title', name: 'title'},
		        {data: 'details', name: 'details'},
		        {data: 'points', name: 'points'},
		        {data: 'image', name: 'image', orderable: false, searchable: false},
		        {data: 'status', name: 'status', orderable: false, searchable: false},
		        {data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    }
		});

		
    });


	$('body').on('click', '.addkyc', function () {
		var product_id = $(this).data('id');
		// reset_kyc();
		$('#modelHeadingKyc').html("Add Gift");
		$('#saveBtnKyc').val("Save Gift");
		$('#ajaxModelKyc').modal('show');
		$('#giftoffer_id').val(product_id);
	})


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

		swal({title: "Are You Sure", 
			text: "You want to inactive this gift record?",  
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

				swal({    title: "Deleting Data ...", text: "Bayanix Management System", icon: "success",  showConfirmButton: false });
				$.ajax({type: "GET", url: "{{ url('gift/delete') }}"+'/'+product_id,
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



</script>
@stop
