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
            <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/options/'.$product->id)}}">Product Options</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="{{url('product/variants/'.$product->id)}}">All Variants & Prices</a>
            <a class="flex-sm-fill text-sm-center nav-link active" href="{{url('product/seo_data/'.$product->id)}}">SEO Details</a>
        </nav>

            {!! Form::open(['id' => 'programForm', 'name' => 'programForm', 'class'=>'form-horizontal']) !!}
            {{csrf_field()}}

            {!! Form::hidden('product_id', $product->id) !!}
            <div class="form-row">
                <div class="col-md-12 col-lg-12">

                    <div class="col-xl-12 mb-3">
                        <label for="name">SEO Meta Title</label>
                        {!! Form::text('title', $seo_data ? $seo_data->title : '', ['class'=>"form-control", 'id'=>"title", 'placeholder'=>"Enter SEO Title", 'required']); !!}
                        <span class="text-danger" id="title-error"></span>
                    </div>


                    <div class="col-xl-12 mb-3">
                        <label for="short_description">SEO Meta Description</label>
                        {!! Form::textarea('description', $seo_data ? $seo_data->description : '', ['class'=>"form-control", 'id'=>"description", 'placeholder'=>"Enter Short description", 'rows'=>4, 'required']); !!}
                        <span class="text-danger" id="description-error"></span>
                    </div>

                    <div class="col-xl-12 mb-3">
                        <label for="name">Alias</label>
                        {!! Form::text('alias', $seo_data ? $seo_data->alias : '', ['class'=>"form-control", 'id'=>"alias", 'placeholder'=>"Enter SEO alias"]); !!}
                        <span class="text-danger" id="alias-error"></span>
                    </div>

                    <div class="col-xl-12 col-lg-4">
                        {!! Form::submit('Save Product', ['class'=>'btn btn-primary', 'id'=>'submitbtn']); !!}
                    </div>

                </div>


                
            </div>
            {!! Form::close(); !!}

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

            var success_url = "{{url('product/seo_data/'.$product->id)}}";

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
                    title: 'required',
                    description: 'required',
                },

                messages: {
                    product_id: "Please enter product.",
                    title: "Please enter title.",
                    description: "Please enter description.",
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

                    $.ajax({
                        data: vals,
                        url: "{{ url('product/store_seo_details') }}",
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





   

</script>
@stop