@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Vendor <small>Details & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Expenses</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage</li>
        </ol>
    </div>

    <div class="float-end">
        @can('make-payment')
		    <a class="btn btn-primary make_payment" href="javascript:void(0)" id="make_payment"><i class="fa fa-plus"></i> Make Payment </a>
		@endcan

        @can('make-bill')
            <a class="btn btn-primary create_bill" href="javascript:void(0)" id="create_bill"><i class="fa fa-shopping-cart"></i> Create Bill </a>
        @endcan
        </div>

</div>
<!-- PAGE-HEADER END -->



	<div class="content mt-3">


        <div class="card">

        	<div class="card-header">
        		Vendor Details
        	</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="text-center mb-1"> {{ $vendor->business_name }}</h5>
                        
                        <p class="text-center text-secondary mt-3">{{ $vendor->address }}, {{ $vendor->city }} - {{ $vendor->pincode }}</p>

                        <hr>
                        <p class="text-muted mt-3">SPOC Details</p>
                            <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Name</h6>
                                <span>{{ $vendor->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Designaton</h6>
                                <span>{{ $vendor->position }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Email</h6>
                                <span>{{ $vendor->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Phone</h6>
                                <span>{{ $vendor->phone }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-8">
                        
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="card">
                                <div class="card-body text-center">

                                    <i class="far fa-cart-plus text-primary fa-3x"></i>
                                    <h6 class="mt-4 mb-2">Total Billed Amount</h6>
                                    <h4 class="mb-2 number-font">Rs. {{ number_format($vendor->total_billed_amount, 2) }}</h4>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="card">
                                <div class="card-body text-center">

                                    <i class="far fa-money-check text-primary fa-3x"></i>
                                    <h6 class="mt-4 mb-2">Total Amount Paid</h6>
                                    <h4 class="mb-2 number-font">Rs. {{ number_format($vendor->total_amount_paid, 2) }}</h4>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-3">
                            <div class="card">
                                <div class="card-body text-center">

                                    <i class="far fa-money-bill text-primary fa-3x"></i>
                                    <h6 class="mt-4 mb-2">Current Outstanding</h6>
                                    <h4 class="mb-2 number-font">Rs. {{ number_format($vendor->current_balance, 2) }}</h4>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-3">
                            <div class="card">
                                <div class="card-body text-center">

                                    <i class="far fa-calendar text-primary fa-3x"></i>
                                    <h6 class="mt-4 mb-2">Vendor Created At</h6>
                                    <h4 class="mb-2 number-font">{{ \Carbon\Carbon::parse($vendor->created_at)->diffForHumans();  }}</h4>

                                </div>
                            </div>
                        </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>

        <!-- Default box -->
        <div class="card">

        	<div class="card-header">
        		Vendor Transactions List
        	</div>

            {!! Form::hidden('vendor', $vendor_id, ['id'=>'vendor'])!!}
            
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-hover data-table" width="100%">
                    <thead>
                        <tr>
                            <th width="20px">S.No.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Sub Cat</th>
                            <th>Amount</th>
                            <th>Amount Paid</th>
                            <th>Balance</th>
                            <th>Payment Mode</th>
                            <th>Payment By</th>
                            <th>Transaction Date</th>
                            <th>Create Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->
    </div>

    @include('view-modals/make_payment')
    @include('view-modals/create_bill')

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
            "dom": 'Bfrtip',
		    "buttons": ['pdf',
                        {
                            extend: 'excel',
                            text: 'Excel',
                            title: 'Vendor Expense Report | Date: '+"{{date('d M, Y')}}",
                            orientation: 'landscape',
                        }, 
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Vendor Expense Report | Date: '+"{{date('d M, Y')}}",
                            orientation: 'landscape',
                        }, 'pageLength'], 	
		    "pageLength": 100,
		    "processing": false,
		    responsive: false,
            processing: true,
            serverSide: true,
            // ajax: "{{ url('getleadsData') }}",
            ajax: {
                data: function ( d ) {
                        d.vendor_id = $('#vendor').val();
                        d._token = "{{ csrf_token() }}";
                    },
                url: "{{ url('getExpenseReportData') }}",
                type: "POST",
                dataType: 'json',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                {data: 'title', name: 'title', orderable: false, searchable: false},
                {data: 'description', name: 'description', orderable: false, searchable: true},
                {data: 'category', name: 'category', orderable: false, searchable: true},
                {data: 'sub_category', name: 'sub_category', orderable: false, searchable: true},
                {data: 'amount', name: 'amount', orderable: false, searchable: false},
                {data: 'amount_paid', name: 'amount_paid', orderable: false, searchable: false},
                {data: 'balance', name: 'balance', orderable: false, searchable: false},
                {data: 'payment_mode', name: 'payment_mode', orderable: false, searchable: false},
                {data: 'payment_user', name: 'payment_user', orderable: false, searchable: false},
                {data: 'transaction_date', name: 'transaction_date', orderable: false, searchable: false},
                {data: 'date', name: 'date', orderable: false, searchable: false},
            ],

            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            order: [[0, 'desc']]
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
		
            // var expanse_id = $(this).data('id');
            var vendor_id = $('#vendor').val();


		    $('#saveBtn').val("Make Payment Now!");
		    $('#dataForm').trigger("reset");
		    $('#ajaxModalHeading').html("Make Payment");

            // $('#expanse_id').val(expanse_id);
		    $('#vendor_id').val(vendor_id);

		    $('#ajaxModel').modal('show');
		});




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

		$('.standardSelect').selectpicker('refresh');

    });


        $('body').on('click', '.create_bill', function () {
		    reset_modal();
		
            // var expanse_id = $(this).data('id');
            var vendor_id = $('#vendor').val();


		    $('#billBtn').val("Create Bill Now!");
		    $('#billForm').trigger("reset");
		    $('#billModalHeading').html("Create Bill");

            // $('#expanse_id').val(expanse_id);
		    $('#vendor_ids').val(vendor_id);

		    $('#billModel').modal('show');
		});


        $('#billBtn').click(function (e) {
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
                    $('#billForm').submit();
                }
                else {
                    swal("Oh noes!", "Process Cancelled!", "error"); 
                    $('#Model').modal('hide');
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


        $("#billForm").validate({

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

                $('#billBtn').html('Sending..');

                $.ajax({
                        data: $('#billForm').serialize(),
                        url: "{{ url('expanse_request/store') }}",
                        type: "POST",
                        dataType: 'json',

                        success: function (data) {
                            if(data.success) {
                                $('#billForm').trigger("reset");
                                $('#billModel').modal('hide');
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
                            $('#billBtn').html('Save Changes');
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
