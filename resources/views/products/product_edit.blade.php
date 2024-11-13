@extends('layouts.app')
@section('content')

@php $statuses = [''=>'Select', 1=>'Active', 0=>'Inactive']; @endphp

@extends('layouts.app')
@section('content')




	<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1>Product <small>Edit</small></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="float-end">
		<a class="btn btn-primary float-right" href=" {{ url('/products') }}" id="createNewProduct"> Product List</a>
    </div>

</div>
<!-- PAGE-HEADER END -->




<div class="content mt-3">


    <div class="card radius-10">
        <div class="card-body">

        <nav class="nav nav-pills flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link active" aria-current="page" href="{{url('product/edit/'.$product->id)}}">Product Basic Details</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/images/'.$product->id)}}">Product Images</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/variants/'.$product->id)}}">All Variants & Prices</a>
            <!-- <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/seo_data/'.$product->id)}}">SEO Details</a> -->
        </nav>

            {!! Form::open(['id' => 'programForm', 'name' => 'programForm', 'class'=>'form-horizontal']) !!}
            {{csrf_field()}}

            {!! Form::hidden('product_id', $product->id) !!}
            <div class="form-row">
                <div class="col-md-8 col-lg-8">

                    <div class="col-xl-12 mb-3">
                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="name">Product Name</label>
                                {!! Form::text('name', $product->name, ['class'=>"form-control", 'id'=>"name", 'placeholder'=>"Enter Product name", 'required']); !!}
                                <span class="text-danger" id="name-error"></span>
                            </div>

                            <div class="col-xl-6">
                                <label for="name">Product Code</label>
                                {!! Form::text('sku', $product->sku, ['class'=>"form-control", 'id'=>"sku", 'placeholder'=>"Enter Product SKU", 'readonly']); !!}
                                <span class="text-danger" id="sku-error"></span>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-12 mb-3">
                            <div class="form-row">
                                <div class="col-xl-6 mb-0 form-group">
                                    <label>Category</label>
                                    {{ Form::select('category', [], '', ['class'=>'standardSelect form-control', 'title'=>'Select category', 'id'=>'category', 'required']) }}
                                    <span class="text-danger" id="category-error"></span>
                                </div>
                                <div class="col-xl-6 mb-0 form-group">
                                    <label>Sub Category</label>
                                    {{ Form::select('sub_category', [], '', ['class'=>'standardSelect form-control', 'title'=>'Select Sub category', 'id'=>'sub_category']) }}
                                    <span class="text-danger" id="category-error"></span>
                                </div>
                            </div>
                        </div>

                    <div class="col-xl-12 mb-3">
                        <label for="short_description">Short Description</label>
                        {!! Form::textarea('short_description', $product->short_description, ['class'=>"form-control", 'id'=>"short_description", 'placeholder'=>"Enter Short description", 'rows'=>3, 'required']); !!}
                        <span class="text-danger" id="short_description-error"></span>
                    </div>

                    <div class="col-xl-12 mb-3">
                        <label for="description">Description</label>
                        {!! Form::textarea('description', $product->description, ['class'=>"form-control", 'id'=>"description", 'placeholder'=>"Enter description", 'rows'=>3, 'required']); !!}
                        <span class="text-danger" id="description-error"></span>
                    </div>

                </div>



                


                <div class="col-md-4 col-lg-4">

                    <div class="card  mb-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Attribute Set</label>
                                {{ Form::select('attribute[]', [], '', ['class'=>'standardSelect form-control', 'title'=>'Select attributes', 'id'=>'attribute']) }}
                            </div>
                        </div>
                    </div>

                    <div class="card  mb-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tax</label>
                                {{ Form::select('tax', [], $product->tax, ['class'=>'standardSelect form-control', 'title'=>'Select Tax', 'id'=>'tax']) }}
                                <span class="text-danger" id="tax-error"></span>
                            </div>


                            <div class="form-group">
                                <label>HSN Code</label>
                                {{ Form::text('hsn_code', $product->hsn_code, ['class'=>'form-control', 'placeholder'=>'Enter HSN Code', 'id'=>'tax']) }}
                                <span class="text-danger" id="hsn_code-error"></span>
                            </div>

                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Status</label>
                                {!! Form::select('status', $statuses, $product->status, ['class'=>'standardSelect form-control', 'title'=>'Select Status', 'data-live-search'=>'true', 'id'=>'status'])!!}
                                <span class="text-danger" id="status-error"></span>
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

        $(".standardSelect").selectpicker();

        $('.standardSelect').on('change', function () {
            // $(this).valid();
            $('.standardSelect').selectpicker('refresh');
        });

        // $('.select2').select2({
        //     theme: 'bootstrap-5',
        // });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        getCategoriesData();


        $('#schedule_date_button').click(function() {
            $('#schedule_date').toggle();
        });




        

        setTimeout(function() {
            $('#tax').val('{{$product->tax}}').trigger('change');
            $('#category').val('{{$product->category_id}}').trigger('change');
        }, 500);

        $('.standardSelect').selectpicker('refresh');


       


        if ($("#programForm").length > 0) {

            var success_url = "{{url('products')}}";

            $("#programForm").validate({

                errorClass: "is-invalid",

                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass);
                    $(element).parent().removeClass(errorClass);
                },

                errorPlacement: function(error, element) {
                    element.parent().append(error);
                    // $('.standardSelect').selectpicker('refresh');
                },

                rules: {
                    name: 'required',
                    short_description: 'required',
                    category: 'required',
                    tax: 'required',
                    hsn_code: 'required',
                    status: 'required',
                    'attribute[]': {
                        // required: true,
                        maxlength: 2 //this only use to validate length of string inputed, not length of array products
                    }

                },

                messages: {
                    name: "Please enter category name.",
                    short_description: "Please Enter short description.",
                    category: "Please Select Category.",
                    tax: "Please Select Tax Slab.",
                    hsn_code: "Please enter HSN Code.",
                    status: "Please Select Status.",
                    'attribute[]': {
                        // required: "Attributes are required",
                        maxlength: "Maximum 2 attributes are allowed to select." 
                    }
                },



                submitHandler: function(form) {

                    // form.preventDefault();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#submitbtn').html('Sending..');
                    var vals = $("#programForm").serializeArray();

                    console.log(vals);

                    // var vals = $("#dataForm").find('input,select').serializeArray();
                    // vals.push({name: 'description', value: CKEDITOR.instances.description.getData()});
                    // vals.push({name: 'salient_feature', value: CKEDITOR.instances.salient_feature.getData()});

                    $.ajax({
                        data: vals,
                        url: "{{ url('product/update') }}",
                        type: "POST",
                        dataType: 'json',

                        success: function(data) {
                            swal({
                                    title: "Great!",
                                    text: data.msg,
                                    icon: "success",
                                })
                                .then((willDelete) => {
                                    location.href = success_url;
                                });
                        },

                        error: function(data) {
                            if (data.status == 422) {
                                var x = data.responseJSON;
                                $.each(x.errors, function(index, value) {
                                    console.log(index);
                                    $("#" + index).addClass("is-invalid");
                                    $("#" + index + "-error").html(value[0]);
                                });
                            }
                            $('#submitbtn').html('Save Category');
                        }
                    });

                }
            })
        }

    });



    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }
        return date;
    }


    // var taxes_options = $.ajax({
    //     type: "get",
    //     url: "{{url('getTaxes')}}?sel=true",
    //     dataType: "json",
    //     success: function(res) {
    //         if (res.success == 1) {
    //             var data = res.data;
    //             var options_htm = '<option value="">Taxes</option>';
    //             $.each(data, function(key, val) {
    //                 options_htm += '<option value="' + key + '">' + val + '<option>';
    //             });
    //             $('#tax').html(options_htm);
    //         }
    //     }
    // });


    function getCategoriesData() {

        $.ajax({
            type: "get",
            url: "{{url('getCategories/')}}?sel=true",
            dataType: "json",
            success: function(res) {

                if (res.success == 1) {
                    var options_htm = '<option value="">Categories</option>';
                    $.each(res.data, function(key, val) {
                        options_htm += '<option value="' + key + '">' + val + '</option>';
                    });
                    $('#category').html(options_htm);
                }
            }
        })
    }






    // var attributes_options = $.ajax({
    //     type: "get",
    //     url: "{{url('getAttributes/')}}?sel=true",
    //     dataType: "json",
    //     success: function(res) {
    //         if (res.success == 1) {
    //             var data = res.data;
    //             var options_htm = '';
    //             $.each(data, function(key, val) {
    //                 options_htm += '<option value="' + key + '">' + val + '<option>';
    //             });
    //             $('#attribute').html(options_htm);
    //             $('#option').html(options_htm);
    //         }
    //     }
    // });



    var next = 0;
    $("#add-more").click(function(e) {
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = ' <div class="row mb-3" id="field' + next + '" name="field' + next +
            '"><div class="col-5"><input type="text" placeholder="Name" class = "form-control" name="specification[' +
            next +
            '][name]"> </div> <div class = "col-5"><input type = "text" placeholder = "Value" class = "form-control" name="specification[' +
            next + '][value]"></div><div class="col-2"><button id="remove' +
            (next - 1) +
            '" class="btn btn-danger remove-me btn-sm" >Remove</button></div></div><div id="field"></div></div>';
        var newInput = $(newIn);

        //        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        // $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source', $(addto).attr('data-source'));
        $("#count").val(next);

        $('.remove-me').click(function(e) {
            e.preventDefault();
            console.log("hello");
            var fieldNum = this.id.charAt(this.id.length - 1);
            var fieldID = "#field" + fieldNum;
            console.log(fieldID);
            $(this).remove();
            $(fieldID).remove();
        });
    });

    //multiple fields add script



    ClassicEditor
        .create(document.querySelector('#description'), {
            removePlugins: ['insert image', 'insert media'],
        })
        .catch(error => {
            console.error(error);
        });

</script>
@stop