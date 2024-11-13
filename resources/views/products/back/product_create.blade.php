@extends('layouts.app')
@section('content')

@php $statuses = [''=>'Select', 1=>'Active', 0=>'Inactive']; $msg = ''; @endphp


	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title"> Product <small> Create New</small></h1>
			<a href="{{url('products')}}" class="btn btn-primary d-grid mb-3"> Product List</a>
		</div>

        @if (session('status'))
        <div class="alert alert-success  alert-dismissible fade show">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @php $msg = session('status'); @endphp
        @endif
		
		
		<div class="card radius-10">
			<div class="card-body">
				
				{!! Form::open(['id' => 'programForm', 'route' => 'product.store',  'name' => 'programForm', 'class'=>'form-horizontal', 'files' => true]) !!}
                {{csrf_field()}}
                <div class="form-row">
                    <div class="col-md-8 col-lg-8">
                        
                    <div class="col-xl-12 mb-3">
                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="name">Product Name</label>
                                {!! Form::text('name', '', ['class'=>"form-control", 'id'=>"name", 'placeholder'=>"Enter Product name", 'requireds']); !!}
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xl-6">
                                <label for="name">Product Code</label>
                                {!! Form::text('sku', '', ['class'=>"form-control", 'id'=>"sku", 'placeholder'=>"Enter Product Code", 'requireds']); !!}
                                @error('sku') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                        <div class="col-xl-12 mb-3">
                            <label for="short_description">Short Description</label>
                            {!! Form::textarea('short_description', '', ['class'=>"form-control", 'id'=>"short_description", 'placeholder'=>"Enter Short description", 'rows'=>3, 'requireds']); !!}
							@error('short_description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class="col-xl-12 mb-3">
                            <label for="description">Description</label>
							{!! Form::textarea('description', '', ['class'=>"form-control", 'id'=>"description", 'placeholder'=>"Enter description", 'rows'=>2, 'requireds']); !!}
							@error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-xl-12 mb-3">
                            <label class="form-label" for="inputImage">Product Image:</label>
                            <!-- <input 
                                type="file" 
                                name="image" 
                                id="inputImage"
                                class="form-control @error('image') is-invalid @enderror"> -->

                            {!! Form::file('image', ['class'=>'form-control']) !!}
                            
            
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>


                    <div class="col-md-4 col-lg-4">

                        <div class="card mb-3">
                            <div class="card-body">
								<div class="form-group">
                                    <label>Category</label>
									{{ Form::select('category', [], '', ['class'=>'standardSelect form-control', 'title'=>'Select category', 'id'=>'category']) }}
									@error('category') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
                                <div class="form-group">
                                    <label>Sub Category</label>
									{{ Form::select('sub_category', [], '', ['class'=>'standardSelect form-control', 'title'=>'Select Sub category', 'id'=>'sub_category']) }}
									@error('sub_category') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
                            </div>
                        </div>

                        <div class="card  mb-3">
                            <div class="card-body">
								<div class="form-group">
                                    <label>Tax</label>
                                    {{ Form::select('tax', [], '', ['class'=>'standardSelect form-control', 'title'=>'Select Tax', 'id'=>'tax']) }}
									@error('tax') <span class="text-danger">{{ $message }}</span> @enderror
								</div>


                                <div class="form-group">
                                    <label>HSN Code</label>
                                    {{ Form::text('hsn_code', '', ['class'=>'form-control', 'placeholder'=>'Enter HSN Code', 'id'=>'tax']) }}
									@error('hsn_code') <span class="text-danger">{{ $message }}</span> @enderror
								</div>

                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
								<div class="form-group">
                                    <label>Status</label>
									{!! Form::select('status', $statuses, '', ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status'])!!}
									@error('status') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
                            </div>
                        </div>

						

						{!! Form::submit('Save Product', ['class'=>'btn btn-primary', 'id'=>'submitbtn']); !!}


						{!! Form::close(); !!}
                    </div>
                </div>
            </form>
				
			</div>
		</div>
	</div>

	

@stop


@section('scripting')

<script type="text/javascript">

    $(document).ready(function() {

		// $(".standardSelect").selectpicker();

        // $('.standardSelect').on('change', function () {
        //     // $(this).valid();
        //     $('.standardSelect').selectpicker('refresh');
        // });

		$( '.select2' ).select2( {
			theme: 'bootstrap-5',
		} );

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

		getCategoriesData();


        $('#tax').select2({
            placeholder: 'Select Tax Type',
        });
        
        $('#sub_category').select2({
            placeholder: 'Select Sub Category',
        });

        $('#category').select2({
            placeholder: 'Select Category',
        });

        $('#status').select2({
            placeholder: 'Select Status',
        });




        var message = '{{$msg}}';

        if(message) {
            swal({
            title: "Good job!",
            text: message,
            icon: "success",
            })
        }

    });






    var taxes_options = $.ajax({
        type: "get",
        url: "{{url('getTaxes')}}?sel=true",
        dataType: "json",
        success: function(res) {
            if (res.success == 1) {
                var data = res.data;
                var options_htm = '<option value="">Taxes</option>';
                $.each(data, function(key, val) {
                    options_htm += '<option value="' + key + '">' + val + '<option>';
                });
                $('#tax').html(options_htm);
            }
        }
    });



	function getCategoriesData() {
		
		$.ajax({
			type: "get",
			url: "{{url('getCategories/')}}?sel=true",
			dataType: "json",
			success: function(res) {

				if (res.success == 1) {
					var options_htm = '<option value="">Categories</option>';
					$.each(res.data, function(key, val) {
						options_htm += '<option value="' + key + '">' + val + '<option>';
					});
					$('#category').html(options_htm);
				}
			}
		})
	}


    $('#category').change(function() {
        var cat_id = $('#category').val();
        $.ajax({
			type: "get",
			url: "{{url('getSubCategories/')}}?c="+cat_id,
			dataType: "json",
			success: function(res) {

				if (res.success == 1) {
					var options_htm = '<option value="">Categories</option>';
					$.each(res.data, function(key, val) {
						options_htm += '<option value="' + key + '">' + val + '<option>';
					});
					$('#sub_category').html(options_htm);
				}
			}
		})
    })




    ClassicEditor
    .create(document.querySelector('#description'), {
        removePlugins: ['insert image', 'insert media'],
    })
    .catch(error => {
        console.error(error);
    });

</script>
@stop
