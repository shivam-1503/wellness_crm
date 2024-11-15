@extends('layouts.app')
@section('content')




	<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Degrees <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Docter details</a></li>
            <li class="breadcrumb-item active" aria-current="page">Degree</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->




	<div class="content mt-3">

        <!-- Default box -->
        <div class="card">

            <div class="card-body">
                <table class="table table-bordered table-hover data-table" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Last Update</th>
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
		    ajax: "{{ url('getDegreesData') }}",
		    columns: [
		        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		        {data: 'name', name: 'name'},
		        {data: 'status', name: 'status', orderable: false, searchable: false},
		        {data: 'updated_at', name: 'status', orderable: false, searchable: false},
		        {data: 'action', name: 'action', orderable: false, searchable: false},
		    ],

		    language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
		    }
		});

    });


    function reset_modal() {
    	$("#cat_id").val("");
    	$("name").val("");
    	//$('#status').val("").trigger("chosen:updated");
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
