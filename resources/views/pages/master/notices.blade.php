@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Notices <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="javascript:void(0)" id="createNewProduct"> <i class="fa fa-plus"></i> Create Notice</a>    
    </div>

</div>
<!-- PAGE-HEADER END -->



    <div class="content mt-3">

        <div class="card shadow mb-4">
        <!-- Default Card Example -->
            <div class="card-header">
                Notice List
            </div>

            <div class="card-body">
                <div class="">
                    <table class="table table-bordered dt-responsive  data-table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                            <tr>
                                <th>S.No.</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Last Modified</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>

    @include('view-modals/notices_addedit');

@stop

@section('scripting')

<script type="text/javascript">

    jQuery(document).ready(function( $ ) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getNoticesData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
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
		    $('#status').val('').trigger("chosen:updated");
		    $('#dataForm').trigger("reset");
		    $('#modelHeading').html("Create New Notice");
		    $('#ajaxModel').modal('show');
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('notice/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Edit Notice");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#notice_id').val(data.id);
		      $('#title').val(data.title);
		      $('#description').val(data.description);
		      $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');
		  })
		});

		$('#saveBtn').click(function (e) {
		    e.preventDefault();
		    $(this).html('Sending..');

		    $.ajax({
		        data: $('#dataForm').serialize(),
		        url: "{{ url('notice/store') }}",
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
		            $('#saveBtn').html('Save Changes');
		        }
		  });
		});


		$('.standardSelect').selectpicker('refresh');




        // Delete a record
            $('body').on('click', '.deleteProduct', function () {

                var customer_id = $(this).data("id");

                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            type: "GET",
                            url: "{{ url('notice/delete') }}"+'/'+customer_id,
                            success: function (data) {
                                table.draw();
                                swal("Great! Notice has been deleted!", {
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
                        swal("Your Notice delete request Cancelled!")
                    }

                })


            });



    });


    function reset_modal() {
    	$("#cat_id").val("");
    	$("name").val("");
    	//$('#status').val("").trigger("chosen:updated");
    	$('#status').val("");
		$('.standardSelect').selectpicker('refresh');

        $("#name").removeClass("is-invalid");
        $("#description").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#name-error").html("");
        $("#description-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');
    }

</script>
@endsection
