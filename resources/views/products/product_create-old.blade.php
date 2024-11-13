@extends('layouts.app')
@section('title', 'Add New Product')

@section('content')

<script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>

<!-- <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
    <li class="breadcrumb-item active">Sidenav Light</li>
</ol> -->
<div class="container-fluid">
    <div class="row ">
        <div class="col-md-12 mt-3">
            <form method="post" action="{{route('product.store')}}" id="add_product_form">
                @csrf
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"
                                placeholder="Product name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea id="short_description" name="short_description" rows="5"></textarea>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="regular_price">Tax</label>
                                <select class="form-control" name="tax" id="tax"></select>
                            </div>
                            <div class="col">
                                <label for="show_price">Show price</label>
                                <input type="number" step="any" min='0' name="show_price" class="form-control"
                                    id="show_price" aria-describedby="emailHelp" placeholder="">
                            </div>
                            <div class="col">
                                <label for="regular_price">Regular price</label>
                                <input type="number" step="any" min='0' name="regular_price" class="form-control"
                                    id="regular_price" aria-describedby="emailHelp" placeholder="">
                            </div>
                            <div class="col">
                                <label for="sale_price">Sale price</label>
                                <div class="input-group mb-3">
                                    <input type="number" step="any" min='0' name="sale_price" class="form-control"
                                        id="sale_price" aria-describedby="emailHelp" placeholder="">
                                    <small id="emailHelp" class="form-text text-muted">
                                        <div class="form-check">
                                            <input type="checkbox" value="1" name="sale_schedule"
                                                class="form-check-input" id="schedule_date_button">
                                            <label class="form-check-label" for="schedule_date_button">Schedule</label>
                                        </div>

                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="schedule_date" style="display:none;">
                            <div class="col">
                                <label>From</label>
                                <input type="text" class="form-control " id="schedule_from_date"
                                    name="schedule_from_date">
                            </div>
                            <div class="col">
                                <label>To</label>
                                <input type="text" class="form-control" id="schedule_to_date" name="schedule_to_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Specifications">Specifications</label>

                            <div id="field">
                                <div id="field0" class="form-group row">
                                    <!-- <div class="col">
                                        <input type="text" placeholder="Name" class="form-control"
                                            name="specification[0][name]">
                                    </div>
                                    <div class="col">
                                        <input type="text" placeholder="Value" class="form-control"
                                            name="specification[0][value]">

                                    </div>
                                    <div class="col"></div> -->
                                </div>
                            </div>
                            <button id="add-more" name="add-more" class="btn btn-success btn-sm">Add
                                More</button>

                        </div>

                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="card  mb-3">
                            <div class="card-header">Add New Product</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <div class="custom-control custom-switch">
                                        <input checked type="checkbox" class="custom-control-input" name="status"
                                            id="status">
                                        <label class="custom-control-label" for="status">Active</label>
                                    </div>
                                </div>
                                <input type="submit"
                                    class="btn purple-gradient btn-rounded waves-effect waves-light btn-sm" name="save"
                                    Value="Publish">
                                <input type="reset" onclick="return confirm('Do you want to reset');"
                                    class="btn peach-gradient btn-rounded waves-effect waves-light btn-sm" name="reset"
                                    Value="Reset">
                                <a href="{{route('product.list')}}" onclick="return confirm('Are you Sure');"
                                    class="btn btn-warning btn-sm">Cancel</a>
                                <a href="{{route('product.list')}}" class='btn btn-link' title="All Products">All
                                    Products</a>
                            </div>
                        </div>
                        <div class="card  mb-3">
                            <div class="card-header">Category</div>
                            <div class="card-body">
                                <select class="form-control" name="category[]" id="category" multiple="multiple">
                                </select>
                            </div>
                        </div>
                       <!--  <div class="card  mb-3">
                            <div class="card-header">Attribute Set</div>
                            <div class="card-body">
                              
                            </div>
                        </div> -->


                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection



@section('scripting')

<script>
var dateFormat = "mm/dd/yy",
    from = $("#schedule_from_date")
    .datepicker({
        minDate: 1,
        changeMonth: true,
        numberOfMonths: 1
    })
    .on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
    }),
    to = $("#schedule_to_date").datepicker({
        minDate: 1,
        changeMonth: true,
        numberOfMonths: 1
    })
    .on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
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

var taxes_options = $.ajax({
    type: "get",
    url: "{{url('admin/tax/')}}/1?sel=true",
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


var category_options = $.ajax({
    type: "get",
    url: "{{url('admin/product/category/')}}/1?sel=true",
    dataType: "json",
    success: function(res) {

        if (res.success == 1) {
            var data = res.data;
            var options_htm = '';
            $.each(data, function(key, val) {
                options_htm += '<option value="' + key + '">' + val + '<option>';
            });
            $('#category').html(options_htm);
        }
    }
});

var attributes_options = $.ajax({
    type: "get",
    url: "{{url('admin/product/attribute/')}}/1?sel=true",
    dataType: "json",
    success: function(res) {
        if (res.success == 1) {
            var data = res.data;
            var options_htm = '';
            $.each(data, function(key, val) {
                options_htm += '<option value="' + key + '">' + val + '<option>';
            });
            $('#attribute').html(options_htm);
        }
    }
});



ClassicEditor
    .create(document.querySelector('#description'), {
        removePlugins: ['insert image', 'insert media'],
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#short_description'), {
        removePlugins: ['insert image', 'insert media'],
    })
    .catch(error => {
        console.error(error);
    });

$(document).ready(function() {
    $('#schedule_date_button').click(function() {
        $('#schedule_date').toggle();

    });
    $('#tax').select2({
        placeholder: 'Select Tax Type',
    });
    $('#attribute').select2({
        placeholder: 'Select Attribute set',
    });
    $('#category').select2({
        placeholder: 'Select Category',
    });

    $("#add_product_form").submit(function(e) {

        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var Method = form.attr('method');
        $.ajax({
            type: Method,
            url: url,
            dataType: "json",
            data: form.serialize(),
            success: function(res) {
                if (res.success == 1) {
                    swal({
                        title: "Good job!",
                        text: res.message,
                        icon: "success",
                    }).then(function() {
                        window.location = "{{url('admin/product/ad/images/')}}/" +
                            res.data.id;
                    });

                    $("#add_product_form").trigger("reset");



                } else {
                    swal({
                        title: "Errors!",
                        text: res.message,
                        icon: "error",
                    });

                }


            },
            error: function(data) {
                var response = JSON.parse(data.responseText);
                var errorString = '';
                $.each(response.errors, function(key, value) {
                    errorString += '' + value + '\n';
                });
                errorString += '';
                swal({
                    title: "Errors!",
                    text: errorString,
                    icon: "error",
                });

            }
        });


    });


    //multiple fields add script

    var next = 0;
    $("#add-more").click(function(e) {
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = ' <div class="form-group row" id="field' + next + '" name="field' + next +
            '"><div class="col"><input type="text" placeholder="Name" class = "form-control" name="specification[' +
            next +
            '][name]"> </div> <div class = "col"><input type = "text" placeholder = "Value" class = "form-control" name="specification[' +
            next + '][value]"></div><div class="col"><button id="remove' +
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
            var fieldNum = this.id.charAt(this.id.length - 1);
            var fieldID = "#field" + fieldNum;
            $(this).remove();
            $(fieldID).remove();
        });
    });

    //multiple fields add script

});
</script>
@endsection