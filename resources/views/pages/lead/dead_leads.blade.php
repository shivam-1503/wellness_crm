@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Lost Leads <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
    <a class="btn btn-primary" href="{{url('lead/create')}}" id="createNewProduct"><i class="fa fa-plus"></i> Add New Lead</a>
    </div>

</div>
<!-- PAGE-HEADER END -->


<div class="content mt-3">

    <div class="card shadow mb-4">

        <div class="card-header">
            <strong>Lost Leads List</strong>
        </div>

        <div class="card-body">
            <div class="">

                

                <table class="table table-bordered data-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20px">S.No.</th>
                            <th>Name</th>
                            <th>Customer</th>
                            <th>Stage</th>
                            <th>Assign to</th>
                            <th>Last Updated</th>
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
</div>


{{-- @include('view-modals/assign_lead'); --}}


@stop



@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getDeadLeadsData') }}",
            // ajax: {
            //     data: function ( d ) {
            //             d._token = "{{ csrf_token() }}";
            //         },
            //     url: "{{ url('getDeadLeadsData') }}",
            //     type: "POST",
            //     dataType: 'json',
            // },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                {data: 'client', name: 'first_name'},
                {data: 'stage', name: 'stage.name', orderable: false, searchable: false},
                {data: 'assignee', name: 'assignee.name', orderable: false, searchable: false},
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




        // Delete a record
        $('body').on('click', '.deleteProduct', function(e) {
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
                        url: "{{ url('product/delete') }}"+'/'+product_id,
                        success: function (data) {
                            table.draw();
                            swal("Great! Category has been deleted!", {
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
                    swal("Your category delete request Cancelled!")
                }

            });

        });


    });









</script>


@endsection
