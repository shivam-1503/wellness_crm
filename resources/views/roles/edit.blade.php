@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Roles <small>Edit</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
	</div>

</div>
<!-- PAGE-HEADER END -->


@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif



<div class="content mt-3">

    <div class="card shadow mb-4">

        <div class="card-header">
            <strong>Edit Role</strong>
        </div>

        <div class="card-body">

{!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <strong>Select the Permissions for this Role:</strong>
            
        @foreach($permissions as $key => $permission)
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <span class="badge bg-primary">{{@$heads[$key]}} Management</span>
                    </div>
                    @foreach($permission as $value)
                <div class="col-sm-3 mt-2">
                    {{ Form::checkbox('permission[]', $value->name, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name form-check-input')) }}                    
                    {{ $value->name }}
                </div>
            @endforeach
            </div>
            @endforeach
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}

</div>
</div>
</div>

@endsection