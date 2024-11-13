@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Employees <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
        @can('create-employee')
            <a class="btn btn-primary float-right" href="{{url('employee/create')}}" id="createNewProduct"> <i class="fa fa-plus"></i> Create Employee</a>    
        @endcan
    </div>

</div>
<!-- PAGE-HEADER END -->



    <div class="content mt-3">

        <div class="card shadow mb-4">
        <!-- Default Card Example -->
            <div class="card-header">
            Employee List
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered  data-table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>EMP Code</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Email</th>
                                <th>Phone</th>
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
            ajax: "{{ url('getEmployeesData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'employee_code', name: 'employee_code'},
                {data: 'name', name: 'name'},
                {data: 'designation', name: 'designation'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
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
                            url: "{{ url('employee/delete') }}"+'/'+customer_id,
                            success: function (data) {
                                table.draw();
                                swal("Great! Employee has been deleted!", {
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
                        swal("Your Employee delete request Cancelled!")
                    }

                })


            });




            $('body').on('click', '.grantAccess', function () {

                var customer_id = $(this).data("id");

                swal({
                    title: "Are you sure?",
                    text: "You want to create this user system Access!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            type: "GET",
                            url: "{{ url('employee/grantAccess') }}"+'/'+customer_id,
                            success: function (data) {
                                table.draw();
                                swal({
                                    title: "Great Job!",
                                    text: "Employee has granted the System Access Successfully!",
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
                        swal("Your Employee delete request Cancelled!")
                    }

                })
            });


            $('body').on('click', '.suspendAccess', function () {

                var customer_id = $(this).data("id");
                var access = $(this).data("access");

                var str = access==1 ? 'Suspend' : 'Grant';
                swal({
                    title: "Are you sure?",
                    text: "You want to "+ str +" user system Access!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            type: "GET",
                            url: "{{ url('employee/suspendAccess') }}"+'/'+customer_id,
                            success: function (data) {
                                table.draw();
                                swal({
                                    title: "Great Job!",
                                    text: data.msg,
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
                        swal("Your Customer delete request Cancelled!")
                    }

                })
            });






    });

</script>
@endsection
