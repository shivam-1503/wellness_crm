@extends('layouts.app')
@section('content')

<style>

	
.responsive-table {
  overflow: auto;
}

table {
  width: 100%;
  border-spacing: 0;
  border-collapse: collapse;
  white-space:nowrap;
}

table th {
  background: #BDBDBD;
}

table tr:nth-child(odd) {
  background-color: #F2F2F2;
}
table tr:nth-child(even) {
  background-color: #E6E6E6;
}

th, tr, td {
  text-align: center;
  border: 1px solid #E0E0E0;
  padding: 5px;
}

img {
  font-style: italic;
  font-size: 11px;
}

.fa-bars{
  cursor: move;
}

	</style>


	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title"> Product Images <small> List </small></h1>

            <div>
			<a type="button" class="modal-effect btn btn-primary" href="{{ url('product/images') }}"> Manage Images</a>

            <span><a href="{{url('products')}}" class="btn btn-primary"> Product List</a></span>
</div>
		</div>
		
		
		<div class="card radius-10">
			<div class="card-body">
				
				<div class="table-responsive">

					<table id="sortable">
						<thead>
							<tr>
								<th class="border-bottom-0">#</th>
								<th class="border-bottom-0">Sr.</th>
								<th class="border-bottom-0">Image</th>
								<th class="border-bottom-0">Status</th>
								<th class="border-bottom-0">Last Update</th>
								<th class="border-bottom-0">Option</th>
								<th class="border-bottom-0">Action</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($images as $index=>$image)
                                <tr>
                                    <td><i class="fa fa-bars"></i></td>
                                    <td data-id="{{$index+1}}">{{$index+1}}</td>
                                    <td><img src="{{ asset('uploads/products/thumbs/'.$image->image) }}" style="width: 60px; height: 60px;" /></td>
                                    <td><img src="{{ asset('images/'.$image->is_thumb.'.png') }}"></td>
                                    <td>{{ date('d M, Y', strtotime($image->updated_at))}}</td>
									<td>
										{{ Form::select('image_variant', ['0'=>'General Image']+$options, $image->option_id, ['class'=>'standardSelect form-control', 'title'=>'Select Product Variant', 'id'=>'image_variant'.$image->id]) }}
									</td>
                                    <td>
                                        <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$image->id}}" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-edit">Make Thumb</i></a></abbr>


										<abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$image->id}}" data-original-title="Delete" class="btn btn-danger btn-sm setProduct"><i class="fa fa-edit">Assign Variant</i></a></abbr>
                                    </td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>


<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 



		$("#sortable tbody").sortable({
      		cursor: "move",
      		placeholder: "sortable-placeholder",
      		helper: function(e, tr)
      		{
        		var $originals = tr.children();

				
        		var $helper = tr.clone();

				console.log($helper);

        		$helper.children().each(function(index)
        		{
					// Set helper cell sizes to match the original sizes
					$(this).width($originals.eq(index).width());
				});
        		
				return $helper;
      		}
    	}).disableSelection();






		$('body').on('click', '.setProduct', function () {

		    var product_id = $(this).data("id");

			var x = $('#image_variant'+product_id).val();

			swal({title: "Are You Sure", 
				text: "You want to set this image as this Variant Image?",  
				type: "warning", icon: "warning",   
				showCancelButton: true,    
				confirmButtonColor: "#e6b034",  
				buttons: {
							cancel: "Cancel",
							confirm: {
								text: "Set Variant Image",
								closeModal: false,
							}
						},
				closeOnConfirm: false, 
				closeOnCancel: true })
			
			.then (isConfirm => {

				if(isConfirm){

                    swal({    title: "Deleting Data ...", text: "Record deletion is in process.", icon: "success",  showConfirmButton: false });
					$.ajax({type: "GET", url: "{{ url('product/set_variant_image') }}"+'/'+product_id+'/'+x,
						success: function (data) {
							swal({   
								title: "Good Job!",   
								type: "success", 
								text: data.msg,
								confirmButtonColor: "#71aa68",
							})
							.then(refresh => {
                                location.reload();
								});
							},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				}
			});
		});





		$('body').on('click', '.deleteProduct', function () {

			var product_id = $(this).data("id");

			swal({title: "Are You Sure", 
				text: "You want to set this image as Thumbnail Image?",  
				type: "warning", icon: "warning",   
				showCancelButton: true,    
				confirmButtonColor: "#e6b034",  
				buttons: {
							cancel: "Cancel",
							confirm: {
								text: "Set Thumb Image",
								closeModal: false,
							}
						},
				closeOnConfirm: false, 
				closeOnCancel: true })

			.then (isConfirm => {

				if(isConfirm){

					swal({    title: "Deleting Data ...", text: "Record deletion is in process.", icon: "success",  showConfirmButton: false });
					$.ajax({type: "GET", url: "{{ url('product/set_thumb_image') }}"+'/'+product_id,
						success: function (data) {
							swal({   
								title: "Good Job!",   
								type: "success", 
								text: data.msg,
								confirmButtonColor: "#71aa68",
							})
							.then(refresh => {
								location.reload();
								});
							},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				}
			});
		});

		// $('.standardSelect').selectpicker('refresh');

    });

</script>
@stop
