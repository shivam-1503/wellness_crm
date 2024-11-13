@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Vendors <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Vendor</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage</li>
        </ol>
    </div>

    <div class="float-end">
		@can('create-vendor')
			<a class="btn btn-primary float-end" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-plus"></i> Create Vendor</a>
		@endcan
	</div>

</div>
<!-- PAGE-HEADER END -->



	<div class="content mt-3">

        <!-- Default box -->
        <div class="card">

        	<div class="card-header">
        		Vendors List
        	</div>

            <div class="card-body">
                <table class="table table-bordered table-hover data-table" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Business</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>City</th>
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

	@include('view-modals/vendor_addedit')
	@include('view-modals/vendor_deals_in')

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
		    ajax: "{{ url('getVendorsData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'business_name', name: 'business_name'},
		        {data: 'name', name: 'name'},
		        {data: 'phone', name: 'phone'},
		        {data: 'city', name: 'city'},
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
		    $('#dataForm').trigger("reset");
		    $('#ajaxModalHeading').html("Create New Vendor");
		    $('#ajaxModel').modal('show');
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('vendor/edit') }}" +'/' + product_id, function (data) {
		      $('#ajaxModalHeading').html("Edit Vendor Details");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#vendor_id').val(data.id);
		      $('#business_name').val(data.business_name);
		      $('#name').val(data.name);
		      $('#position').val(data.position);
		      $('#email').val(data.email);
		      $('#phone').val(data.phone);
		      $('#state_id').val(data.state_id);
		      $('#address').val(data.address);
		      $('#city').val(data.city);
		      $('#pincode').val(data.pincode);
		      $('#pan').val(data.pan);
		      $('#website').val(data.website);
		      
			 
			  $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');
		  })
		});




		$('body').on('click', '.dealsIn', function () {
		  	var product_id = $(this).data('id');
		  	// reset_modal();
		  	$.get("{{ url('vendor/deals') }}" +'/' + product_id, function (data) {
		      	$('#ajaxCatModalHeading').html("Manage Expnse Categories for Vendor");
		      	$('#saveCatBtn').val("Save Changes");
		      	$('#ajaxCatModel').modal('show');
		      	$('#deals_vendor_id').val(product_id);

			  	$(data).each(function(key, value){
					$( "#cat_"+value ).prop( "checked", true );
				});
		  	})
		});



	
	$('#saveCatBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Sending..');

        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to add these categories to this Vendor?',

            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "Add Category!",
                    closeModal: false,
                }
            },
        })
        .then(confirm => {

            if(confirm) {
				
				$('#saveBtn').html('Sending..');

				$.ajax({
					data: $('#catForm').serialize(),
					url: "{{ url('vendor/categories/store') }}",
					type: "POST",
					dataType: 'json',

					success: function (data) {
						$('#catForm').trigger("reset");
						$('#ajaxCatModel').modal('hide');
						// table.draw();
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
            else {
                swal("Oh noes!", "Process Cancelled!", "error"); 
				$('#ajaxCatModel').modal('hide');
            }
        })
        .catch(err => {
            if (err) {
                swal("Oh noes!", "The AJAX request failed!", "error");
				$('#ajaxCatModel').modal('hide');
            } else {
                swal.stopLoading();
                swal.close();
            }
        });        
    });



	$('#saveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Sending..');

		if($('#vendor_id').val() == "") {
			var txt = "Create";
		}
		else {
			var txt = "Update";
		}

        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to '+txt+' this Vendor?',

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
			business_name: 'required',
			name: 'required',
			state_id: 'required',
			city: 'required',
			pincode: 'required',
			email: {
				required: true,
				email: true,
			},
			phone: {
				required: true,
				number: true,
			},
		},

		messages: {
			business_name: "Please Enter Business Name.",
			name: "Please Enter Company Name.",
			pincode: "Please Enter Pincode.",
			state_id: "Please Select State You Belong.",
			city: "Please Enter Your City.",
			email: {
				required: "Please Enter Email Id",
				email: "Please Enter Valid Email Id",
			},
			phone: {
				required: "Please Enter Phone No",
				number: "Phone No. must be a number.",
			}
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
					url: "{{ url('vendor/store') }}",
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
    	$("#vendor_id").val("");
    	$("#name").val("");
    	$('#business_name').val("");
    	$('#position').val("");
    	$('#email').val("");
    	$('#phone').val("");
    	$('#state_id').val("");
    	$('#address').val("");
    	$('#city').val("");
    	$('#pincode').val("");
    	$('#pan').val("");
    	$('#website').val("");
    	$('#status').val("");
		$('.standardSelect').selectpicker('refresh');

        $("#name").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#name-error").html("");
        $("#status-error").html("");
		
        $('#saveBtn').html('Save Changes');
    }

</script>
@stop
