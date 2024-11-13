@extends('layouts.app')
@section('content')

<style>
@font-face {
    font-family: 'Glyphicons Halflings';
    src: url('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/fonts/glyphicons-halflings-regular.eot');
    src: url('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'),
        url('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/fonts/glyphicons-halflings-regular.woff2') format('woff2'),
        url('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/fonts/glyphicons-halflings-regular.woff') format('woff'),
        url('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/fonts/glyphicons-halflings-regular.ttf') format('truetype'),
        url('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular') format('svg');
}

.glyphicon {
    position: relative;
    top: 1px;
    display: inline-block;
    font: normal normal 14px/1 'Glyphicons Halflings';
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
    margin-right: 2px;
}

/* Add icons you will be using below */

.glyphicon-download:before {
    content: "\e026";
}

.glyphicon-resize-vertical:before {
    content: "\e119";
}

.glyphicon-fullscreen:before {
    content: "\e140";
}

.glyphicon-resize-full:before {
    content: "\e096";
}

.glyphicon-remove:before {
    content: "\e014";
}


.glyphicon-repeat:before {
    content: "\e027";
}

.glyphicon-upload:before {
    content: "\e027";
}

.glyphicon-trash:before {
    content: "\e020";
}

.glyphicon-zoom-in:before {
    content: "\e015";
}

.glyphicon-eye-open:before {
    content: '\e105';
}
</style>


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title"> Product Images<small> List & Management</small></h1>
			<a href="{{url('products')}}" class="btn btn-primary d-grid mb-3"> Product List</a>
		</div>
		
		
		<div class="card radius-10">
            <!-- <div class="card-header">Product Images
            <span class="float-end"> || Product Name: {{$product->name}}</span>
            </div> -->

            
                
            <div class="card-body">

                <nav class="nav nav-pills flex-column flex-sm-row mb-4">
                    <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="{{url('product/edit/'.$product->id)}}">Product Basic Details</a>
                    <a class="flex-sm-fill text-sm-center nav-link active" href="{{url('product/images/'.$product->id)}}">Product Images</a>
                    <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/variants/'.$product->id)}}">All Variants & Prices</a>
                    <!-- <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/seo_data/'.$product->id)}}">SEO Details</a> -->
                </nav>

            
                @csrf
                <div class="file-loading">
                    <input id="product_images" name="product_images[]" type="file" multiple>
                </div>

            </div>
				
		</div>
	</div>

	

@stop


@section('scripting')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
    dialog. bootstrap 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
<!-- the main fileinput plugin file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/fileinput.min.js"></script>
<!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/themes/fas/theme.min.js"></script>



<script type="text/javascript">

    $(document).ready(function() {


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 


        $('.btn-close').click(function(){
            alert("hello");
        })


        $("#product_images").fileinput({
            theme: 'fa5',
            uploadUrl: "{{url('product/image/store/'.$product_id)}}",
            maxFileCount: 10,
    
            uploadExtraData: function() {
                return {
                    _token: $("input[name='_token']").val(),
                };
            },
            allowedFileExtensions: ['jpg', 'jpeg', 'png'],
            overwriteInitial: false,
            maxFileSize: 4096,
            slugCallback: function(filename) {
                return filename.replace('(', '_').replace(']', '_');
            },


            initialPreview: [@foreach($items as $item)
                '{{asset("uploads/products/thumbs/".$item->image)}}',

                @endforeach
            ],
            initialPreviewAsData: true,
            initialPreviewConfig: [
                @foreach($items as $item)
                {
                    filename: "{{$item->image}}",
                    downloadUrl: '{{asset("uploads/products/thumbs/".$item->image)}}',
                    key: '{{$item->id}}',
                    extra: function() {
                        return {
                            _token: $("input[name='_token']").val(),
                        };
                    }
                },

                @endforeach

            ],
            deleteUrl: "{{url('product/image/delete')}}",
        }).on('filesorted', function(e, params) {
    console.log('File sorted params', params);
});





    });



</script>
@stop
