@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Default Contents <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Default Contents</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage</li>
        </ol>
    </div>

    <div class="float-end">
		<a class="btn btn-primary float-end" href="javascript:void(0)" id="createNewProduct"><i class="fa fa-plus"></i> Create Default Content</a>
    </div>

</div>
<!-- PAGE-HEADER END -->



	<div class="content mt-3">

        <!-- Default box -->
        <div class="card">

        	<div class="card-header">
        		Default Content List
        	</div>

            <div class="card-body">
                <table class="table table-bordered table-hover data-table" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Title</th>
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

	@include('view-modals/default_content_addedit')
	@include('view-modals/default_content_details')

@stop


@section('scripting')


<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

    $(document).ready(function() {


		$(".standardSelect").selectpicker();

        $('.standardSelect').on('change', function () {
            $(this).valid();
            $('.standardSelect').selectpicker('refresh');
        });


		CKEDITOR.replace( 'content', {
			toolbarGroups: [
				{ name: 'basicstyles', groups: [ 'basicstyles' ] },
				{ name: 'links', groups: [ 'links' ] },
				{ name: 'paragraph',   groups: [ 'list', 'blocks', 'align', 'paragraph' ] },
				{ name: 'styles', groups: [ 'styles' ] },
				{ name: 'colors', groups: [ 'colors' ] },
			]

			// NOTE: Remember to leave 'toolbar' property with the default value (null).
		});
		

		

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		var table = $('.data-table').DataTable({
		    processing: true,
		    serverSide: true,
		    ajax: "{{ url('getDefaultContentsData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'type', name: 'type'},
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
		    $('#modelHeading').html("Create New Property Type");
		    $('#ajaxModel').modal('show');
		});


		$('body').on('click', '.editProduct', function () {
		  var product_id = $(this).data('id');
		  reset_modal();
		  $.get("{{ url('default_content/edit') }}" +'/' + product_id, function (data) {
		      $('#modelHeading').html("Edit Default Content: "+data.type);
		      $('#saveBtn').val("Save Changes");
		      $('#ajaxModel').modal('show');
		      $('#content_id').val(data.id);
		      // $('#content').val(data.content);
		      $('#description').val(data.description);
		      $('#status').val(data.status);
			  $('.standardSelect').selectpicker('refresh');

			  CKEDITOR.instances['content'].setData(data.content);

		  })
		});


		$('body').on('click', '.viewProduct', function () {
		  var product_id = $(this).data('id');
		  $.get("{{ url('default_content/edit') }}" +'/' + product_id, function (data) {
		     	 $('#modelHeading_data').html("Default Content Details: "+data.type);
		      	$('#detailsModel').modal('show');
		      	$('#content_data').html(data.content);
		      	$('#description_data').html(data.description);

			  	var status = (data.status == 1) ? "Active" : "Inactive";

			  	if(data.status == 1) {
					$('#status_bar').removeClass('btn-danger');
         			$('#status_bar').addClass("btn-primary");
				}
				else {
					$('#status_bar').removeClass('btn-primary');
         			$('#status_bar').addClass("btn-danger");
				}


		      	$('#status_data').html(status);
		  })
		});


		$('#saveBtn').click(function (e) {
		    e.preventDefault();
		    $(this).html('Sending..');

			CKEDITOR.instances['content'].updateElement();
		    $.ajax({
		        data: $('#dataForm').serialize(),
		        url: "{{ url('default_content/store') }}",
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
				        url: "{{ url('property_type/delete') }}"+'/'+product_id,
				        success: function (data) {
				            table.draw();
				            swal("Great! Property Type has been deleted!", {
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
					swal("Your Property Type delete request Cancelled!")
				}

			})


		});

		$('.standardSelect').selectpicker('refresh');

		//$(".standardSelect").select2();

    });


    function reset_modal() {
    	$("#cat_id").val("");
    	$("name").val("");
    	//$('#status').val("").trigger("chosen:updated");
    	$('#status').val("");
		$('.standardSelect').selectpicker('refresh');

        $("#name").removeClass("is-invalid");
        $("#country_id_fk").removeClass("is-invalid");
        $("#status").removeClass("is-invalid");

        $("#name-error").html("");
        $("#country_id_fk-error").html("");
        $("#status-error").html("");

        $('#saveBtn').html('Save Changes');
    }

</script>
@stop
