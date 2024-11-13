@extends('layouts.app')
@section('content')

@php $statuses = [''=>'Select', 1=>'Active', 0=>'Inactive']; @endphp


<div class="main-container container-fluid">
    <div class="page-header">
        <h1 class="page-title"> Product <small> Edit</small></h1>
        <a href="{{url('products')}}" class="btn btn-primary d-grid mb-3"> Product List</a>
    </div>




    <div class="card radius-10">
        <div class="card-body">

        <nav class="nav nav-pills flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="{{url('product/edit/'.$product->id)}}">Product Basic Details</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/images/'.$product->id)}}">Product Images</a>
            <a class="flex-sm-fill text-sm-center nav-link active" href="{{url('product/options/'.$product->id)}}">Product Options</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/variants/'.$product->id)}}">All Variants & Prices</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/seo_data/'.$product->id)}}">SEO Details</a>
        </nav>

            {!! Form::open(['id' => 'programForm', 'name' => 'programForm', 'class'=>'form-horizontal']) !!}
            {{csrf_field()}}

            {!! Form::hidden('product_id', $product->id) !!}
            <div class="form-row">
                <div class="col-md-8 col-lg-8">

                    <div class="col-xl-12 mb-3">
                        <label for="name">Product Attribute</label>
                        {!! Form::text('name', $product->sku, ['class'=>"form-control", 'id'=>"name", 'placeholder'=>"Enter Product name", 'required']); !!}
                        <span class="text-danger" id="name-error"></span>
                    </div>

                    


                    <div class="col-xl-12 form-group mb-3">
                        <label for="name"> Option</label>
                        {{ Form::select('attribute_value_id[]', $attributes, '', ['class'=>'standardSelect form-control', 'title'=>'Select attributes', 'id'=>'attribute_value_id', 'multiple']) }}
                        <span class="text-danger" id="name-error"></span>
                    </div>


                    





                   



                    


                </div>






                <div class="col-md-4 col-lg-4">



                    {!! Form::submit('Save Product', ['class'=>'btn btn-primary', 'id'=>'submitbtn']); !!}


                    {!! Form::close(); !!}
                </div>
            </div>
            </form>

        </div>
    </div>



    <div class="card radius-10">
        <div class="card-body">

            <div class="table-responsive">
                                        
                <table class="table table-bordered text-nowrap border-bottom data-table w-100">

                    <thead>
                        <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Status</th>
                            <th scope="col">Save & Publish</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($options as $key => $obj)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$obj->attribute_value->value}}</td>
                            <td><img src="{{ asset('images/'.$obj->status.'.png') }}"></td>
                            <td><button class="btn btn-success" onclick="change_status({{$obj->id}})">Change Status</button></td>
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
    $(document).ready(function() {

        // $(".standardSelect").selectpicker();

        // $('.standardSelect').on('change', function () {
        //     // $(this).valid();
        //     $('.standardSelect').selectpicker('refresh');
        // });

        $('.select2').select2({
            theme: 'bootstrap-5',
        });

        $('.standardSelect').select2({
            
        });


        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#attribute').select2({
            placeholder: 'Select Attribute set',
        });


        setTimeout(function() {
            $('#attribute').val('').trigger('change');
        }, 500);



        if ($("#programForm").length > 0) {

            var success_url = "{{url('product/options/'.$product->id)}}";

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
                    product_id: 'required',
                },

                messages: {
                    product_id: "Please enter category name.",
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
                        url: "{{ url('product/store_options_details') }}",
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


    var attributes_options = $.ajax({
        type: "get",
        url: "{{url('getAttributes/')}}?sel=true",
        dataType: "json",
        success: function(res) {
            if (res.success == 1) {
                var data = res.data;
                var options_htm = '<option value="">Select Attribute<option>';
                $.each(data, function(key, val) {
                    options_htm += '<option value="' + key + '">' + val + '<option>';
                });
                $('#attribute').html(options_htm);
            }
        }
    });



    function change_status(id) {

        var success_url = "{{url('product/options/'.$product->id)}}";

        $.ajax({
            type: "get",
            url: "{{url('product/change_option_status')}}/"+id,
            dataType: "json",
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
            }
        });
    }


</script>
@stop