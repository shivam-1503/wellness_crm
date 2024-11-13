@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Expenses <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Expenses</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage</li>
        </ol>
    </div>

    <div class="float-end">
		<!-- <a class="btn btn-primary float-end" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-plus"></i> Create Expense </a> -->
    </div>

</div>
<!-- PAGE-HEADER END -->



	<div class="content mt-3">

        <!-- Default box -->
        <div class="card">

        	<div class="card-header">
        		Expenses List
        	</div>

            <div class="card-body">
                <table class="table table-bordered table-hover data-table" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Vendor</th>
                            <th>Amount</th>
                            <th>Balance</th>
                            <th>Invoice Date</th>
                            <th>Action</th>
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

	{{-- @include('view-modals/expanse_addedit') --}}

    @include('view-modals/make_payment')

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
		    ajax: "{{ url('getExpansesData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'title', name: 'title'},
		        {data: 'category', name: 'category'},
		        {data: 'vendor', name: 'vendor'},
		        {data: 'amount', name: 'amount', orderable: false, searchable: false},
		        {data: 'balance', name: 'balance', orderable: false, searchable: false},
		        {data: 'invoice_date', name: 'invoice_date', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    }
		});

        table.on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({placement: 'top',});
        });


		$('#createNewProduct').click(function () {
		    reset_modal();
		
		    $('#saveBtn').val("Create");
		    $('#dataForm').trigger("reset");
		    $('#ajaxModalHeading').html("Create New Expense");
		    $('#ajaxModel').modal('show');
		});


        $('body').on('click', '.make_payment', function () {
		    reset_modal();
		
            var expanse_id = $(this).data('id');
            var vendor_id = $(this).data('vendor_id');

		    $('#saveBtn').val("Make Payment Now!");
		    $('#dataForm').trigger("reset");
		    $('#ajaxModalHeading').html("Make Payment");

            $('#expanse_id').val(expanse_id);
		    $('#vendor_id').val(vendor_id);

		    $('#ajaxModel').modal('show');
		});


		// $('body').on('click', '.editProduct', function () {
		//   var product_id = $(this).data('id');
		//   reset_modal();

		//   $.get("{{ url('expanse/edit') }}" +'/' + product_id, function (data) {
		//       $('#ajaxModalHeading').html("Edit Expense Category");
		//       $('#saveBtn').val("Save Changes");
		//       $('#ajaxModel').modal('show');
		//       $('#expanse_id').val(data.id);
		//       $('#cat_id').val(data.expanse_category_id);
		//       $('#vendor_id').val(data.vendor_id);
		//       $('#title').val(data.title);
		//       $('#description').val(data.description);
		//       $('#amount').val(data.amount);
		//       $('#payment_mode').val(data.payment_mode);
		//       $('#payment_ref_no').val(data.payment_ref_no);
		//       $('#payment_date').val(data.payment_date);
		//       $('#remarks').val(data.remarks);
		// 	  $('.standardSelect').selectpicker('refresh');
		//   })
		// });





	$('#saveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Sending..');

		if($('#expanse_id').val() == "") {
			var txt = "Create";
		}
		else {
			var txt = "Update";
		}

        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to '+txt+' this Expense?',

            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: txt+" Expense!",
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
			cat_id: 'required',
			title: 'required',
            amount: {
                required: true,
                number: true,
            },
		},

		messages: {
			cat_id: "Please Enter Category Name.",
			title: "Please Select Status.",
            amount: {
                required: "Please Enter the Amount",
                number: "Amount must be Numeric",
            },
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
					url: "{{ url('create_payment') }}",
					type: "POST",
					dataType: 'json',

					success: function (data) {
                        if(data.success) {
                            $('#dataForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            // table.draw();
                            swal({
                                title: "Good job!",
                                text: data.msg,
                                icon: "success",
                            });
                        }
                        else {
                            swal({
                                title: "Error!",
                                text: data.msg,
                                icon: "error",
                            });
                        }
						
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
				text: "Once deleted, you will not be able to recover this Expense!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
		    })
			.then((willDelete) => {
  				if (willDelete) {

					$.ajax({
				        type: "GET",
				        url: "{{ url('expanse/delete') }}"+'/'+product_id,
				        success: function (data) {
				            table.draw();
				            swal("Great! Expense has been deleted!", {
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
					swal("Your Expense delete request Cancelled!")
				}

			})


		});

		$('.standardSelect').selectpicker('refresh');

    });



	$('#cat_id').change(function() {
        var cat_id = $('#cat_id').val();
        getSubCats(cat_id);
    })


    function getSubCats(cat_id, category=false)
    {
        $.ajax({
			type: "get",
			url: "{{url('getExpenseSubCatsbyCatId/')}}/"+cat_id,
			dataType: "json",
			success: function(res) {

				if (res.success) {
					var options_htm = '<option value="">Select Sub Category</option>';
					$.each(res.data, function(key, val) {
						options_htm += '<option value="' + key + '">' + val + '</option>';
					});

					$('#sub_cat_id').html(options_htm);

                    if(category) {
                        $('#sub_cat_id').val(category);
                    }
                    $('.standardSelect').selectpicker('refresh');
				}
			}
		})
    }


    function reset_modal() {
    	$("#cat_id").val("");
    	// $("#name").val("");
    	// $('#status').val("");
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


	function view_payment(payment_id)
    {
        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to approove this payment?',
            content: {
                element: "input",
                attributes: {
                    placeholder: "Enter Your Remarks Here..",
                },
            },

            //buttons: true,
            
            // button: {
            //     text: "Approove Payment!",
            //     closeModal: false,
            // },

            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "Approove Payment!",
                    closeModal: false,
                }
            },

        })
        .then(remarks => {

            if(remarks != null) {
                var id = payment_id;
                $.ajax({
                    data: {"_token": "{{ csrf_token() }}", 'id': id, 'remarks': remarks},
                    url: "{{ url('comfirm_payment_store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function (data) {
                        swal({
                            title: "Good job!",
                            text: data.msg,
                            icon: "success",
                        }).then(refresh => {
                            $(".data-table").DataTable().ajax.reload();
                        })
                    },

                    error: function (data) {
                        if (data.status == 422) {
                            var x = data.responseJSON;
                            $.each(x.errors, function( index, value ) {
                                console.log(index);
                                $("#"+index).addClass("is-invalid");
                                $('.standardSelect').selectpicker('refresh');
                                $("#"+index+"-error").html(value[0]);
                            });
                        }
                        $('#saveBtn').html('Save Changes');
                    }
                });
            }
            else {
                swal("Oh noes!", "Process Cancelled!", "error"); 
            }
        })
        .catch(err => {
            if (err) {
                swal("Oh noes!", "The AJAX request failed!", "error");
            } else {
                swal.stopLoading();
                swal.close();
            }
        });        
    }




    function reject_payment(payment_id)
    {
        swal({
            icon: 'warning',
            closeOnClickOutside: false,
            text: 'Are you sure, You want to Reject this payment?',
            dangerMode: true,
            content: {
                element: "input",
                attributes: {
                    placeholder: "Enter Your Remarks Here..",
                },
            },
            button: {
                text: "Approove Payment!",
                closeModal: false,
            },
        })
        .then(remarks => {
            var id = payment_id;
            $.ajax({
                data: {"_token": "{{ csrf_token() }}", 'id': id, 'remarks': remarks},
                url: "{{ url('reject_payment_store') }}",
                type: "POST",
                dataType: 'json',

                success: function (data) {
                    swal({
                        title: "Good job!",
                        text: data.msg,
                        icon: "success",
                    }).then(refresh => {
                        $(".data-table").DataTable().ajax.reload();
                    })
                },

                error: function (data) {
                    if (data.status == 422) {
                        var x = data.responseJSON;
                        $.each(x.errors, function( index, value ) {
                            console.log(index);
                            $("#"+index).addClass("is-invalid");
                            $('.standardSelect').selectpicker('refresh');
                            $("#"+index+"-error").html(value[0]);
                        });
                    }
                    $('#saveBtn').html('Save Changes');
                }
            });
        })
        .catch(err => {
            if (err) {
                swal("Oh noes!", "The AJAX request failed!", "error");
            } else {
                swal.stopLoading();
                swal.close();
            }
        });   
    }

</script>
@stop
