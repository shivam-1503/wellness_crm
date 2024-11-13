@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>KRAs <small>Create</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">KRAs </a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </div>

    <!-- <div class="float-end">
		<a class="btn btn-primary float-end" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-plus"></i> Create KPI</a>
    </div> -->

</div>
<!-- PAGE-HEADER END -->



	<div class="content mt-3">

        <!-- Default box -->
        <div class="card">

        	<div class="card-header">
				KRAs Management
        	</div>

            <div class="card-body">
                <table class="table table-bordered table-hover data-table" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>KPI</th>
                            <th>Target</th>
                            <th>Weightage</th>
                            <th>Frequency</th>
                            <th>Status</th>
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
		    ajax: "{{ url('getKpisData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'group', name: 'group'},
		        {data: 'title', name: 'title'},
		        {data: 'description', name: 'description'},
		        {data: 'unit', name: 'unit'},
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
		    $('#modelHeading').html("Create New KPI");
		    $('#ajaxModel').modal('show');
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('kpi/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Edit KPI");
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#kpi_id').val(data.id);
		      $('#title').val(data.title);
		      $('#kpi_group_id').val(data.kpi_group_id);
		      $('#description').val(data.description);
		      $('#unit').val(data.unit);
		      $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');
		  })
		});

		$('#saveBtn').click(function (e) {
		    e.preventDefault();
		    $(this).html('Sending..');

		    $.ajax({
		        data: $('#dataForm').serialize(),
		        url: "{{ url('kpi/store') }}",
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

		$('body').on('click', '.deleteProduct', function () {

		    var product_id = $(this).data("id");

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
				        url: "{{ url('kpi/delete') }}"+'/'+product_id,
				        success: function (data) {
				            table.draw();
				            swal("Great! KPI has been deleted!", {
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
					swal("Your KPI delete request Cancelled!")
				}

			})


		});

		$('.standardSelect').selectpicker('refresh');

		//$(".standardSelect").select2();

    });


    function reset_modal() {
    	$("#cat_id").val("");
    	$("title").val("");
    	$("description").val("");
    	$("type").val("");
    	$('#status').val("");
		$('.standardSelect').selectpicker('refresh');

        $("#title").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#title-error").html("");
        $("#description-error").html("");
        $("#description-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');
    }

</script>
@stop
