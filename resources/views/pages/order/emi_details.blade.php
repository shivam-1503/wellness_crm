@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Projects <small>List & Management</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary float-right" href="{{url('project/create')}}" id="createNewProduct"> <i class="fa fa-plus"></i> Create Project</a>    
    </div>

</div>
<!-- PAGE-HEADER END -->



    <div class="content mt-3">

        <div class="card shadow mb-4">
        <!-- Default Card Example -->
            <div class="card-header">
                Projects List
            </div>

            <div class="card-body">
                <div class="">
                    <table class="table table-bordered dt-responsive  data-table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>EMI Amount</th>
                                <th>Month</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($emi_details as $obj)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $obj->emi_amount }}</td>
                                    <td>{{ $obj->month }}</td>
                                    <td>{{ $obj->status }}</td>
                                    <td>{{ date('d M, Y', strtotime($obj->due_date)) }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
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

        $('.data-table').DataTable();

        // table.on( 'draw', function () {
        //     $('[data-toggle="tooltip"]').tooltip({placement: 'top',});
        // });





    });

</script>
@endsection
