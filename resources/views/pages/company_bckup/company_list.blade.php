@extends('layouts.app')

@section('content')

<script type="text/javascript">
    function deletion()
    {
        var x = confirm('Do you really want to delete?');

        if(x)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

<!-- Page Heading -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-primary">Company List
        <span class="pull-right"><a href="{{ url('sales/company/add') }}" class="btn btn-sm btn-primary" style="float:right;"><i class="fa fa-plus"></i> Add New</a></span></h4>
    </div>
   
    <div class="card-body">
        <div class="">
            <table class="table table-bordered dt-responsive" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Company Type</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
              
                <tbody>
                    @php $i=1; @endphp
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $company_types[$row->company_type_id_fk] }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->phone }}</td>

                        <td>
                        <a href="" title="edit" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{url('sales/company/edit/'.$row->id)}}" title="edit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{url('sales/company/delete/'.$row->id)}}" title="Delete" class="btn btn-danger btn-sm" onclick="return deletion();"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @php $i++; @endphp
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
