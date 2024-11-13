@extends('layouts.app')
@section('content')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Lead <small>{{isset($lead_id) ? "Edit" : "Create"}}</small></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class="active">Dashboard</li>
                    <li class="active">Lead</li>
                    <li class="active">{{isset($lead_id) ? "Edit" : "Create"}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">

    <div class="card shadow mb-4">
        <div class="card-header">
            Lead Details
            <a class="btn btn-primary btn-sm float-right" href="{{url('lead/create')}}"> <i class="fa fa-arrow-left"></i> Add New Lead</a>
        </div>

        <div class="card-body">

            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link" href="{{ url('/lead/details/'.$lead_id) }}" role="tab">General</a>

                    <a class="nav-item nav-link" href="{{ url('/lead/products/'.$lead_id) }}" role="tab">Products</a>

                    <a class="nav-item nav-link active" href="{{ url('/lead/quote/'.$lead_id) }}" role="tab">Quotes</a>

                    <a class="nav-item nav-link" href="{{ url('/lead/products') }}" role="tab">Invoices</a>
                </div>
            </nav>

            @if(!empty($quote))
            <div class="card">
                <div class="card-header">
                    Customer Information
                </div>

                <div class="card-body">
                    <div class="mt-3 mb-3 clearfix">

                        @if($quote->quote_stage == 3)
                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" class="btn btn-primary float-right">Create Invoice </a>
                            </div>
                        </div>
                        @endif


                        @php
                            $quote_date = $quote->is_quoted != 1 ? date('Y-m-d') : date('Y-m-d', strtotime($quote->quote_date));

                            $due_date  = is_null($quote->due_date) ? date('Y-m-d', strtotime('+7 days')) : date('Y-m-d', strtotime($quote->due_date));
                        @endphp

                        {{ Form::open(['id'=>'dataForm'])}}
                        {{ Form::hidden('customer_id', $quote->customer_id_fk, ['id'=>'customer_id']) }}
                        {{ Form::hidden('lead_id', $quote->lead_id_fk, ['id'=>'customer_id']) }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row  form-group">
                                    <div class="col-md-6">
                                        <label for="cus_name"><b>Creation Date <k>*</k></b></label>
                                            {{ Form::date('quote_date', $quote_date, array('class'=>'form-control'))}}

                                            @if ($errors->has('created_at'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('created_at') }}</strong>
                                                </span>
                                            @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cus_name"><b>Due Date <k>*</k></b></label>
                                            {{ Form::date('due_date', $due_date, array('class'=>'form-control'))}}

                                            @if ($errors->has('due_date'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('due_date') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>

                                <div class="row  form-group">
                                    <div class="col-md-6">
                                        <label for="cus_name"><b>Customer <k>*</k></b></label>
                                            {{ Form::text('name', $lead->first_name.' '.$lead->last_name, ['class'=>'form-control', 'disabled'=>'disabled']) }}
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cus_name"><b>Company </b></label>
                                            {{ Form::text('company', $lead->company, ['class'=>'form-control']) }}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="cus_name"><b>Email Id <k>*</k></b></label>
                                            {{ Form::text('email', $lead->email, ['class'=>'form-control']) }}

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cus_name"><b>Subject <k>*</k></b></label>
                                            {{ Form::text('mail_subject', $quote->subject, ['class'=>'form-control']) }}

                                            @if ($errors->has('mail_subject'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('mail_subject') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <label for="cus_name"><b>Instructions<span style="color:red;">*</span></b></label><br>
                                <textarea name="instructions" id="instructionsId" class="instructionsClass">{{$quote->instructions}}</textarea>
                                <script>
                                    CKEDITOR.replace('instructionsId', {
                                                toolbarGroups: [{
                                                  "name": "basicstyles",
                                                  "groups": ["basicstyles"]
                                                },

                                                {
                                                  "name": "paragraph",
                                                  "groups": ["list"]
                                                },
                                                {
                                                  "name": "document",
                                                  "groups": ["mode"]
                                                },

                                                {
                                                  "name": "styles",
                                                  "groups": ["styles"]
                                                },
                                              ],
                                            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar',
                                            height:135,
                                        });
                                </script>

                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-md-12" align="right">
                                <button type="button" class="btn btn-primary btn-sm" id="send_mail"><i class="fa fa-cart-o"></i> Create & E-mail </button>
                            </div>
                        </div>

                        {{ Form::close() }}



                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Quote Details:
                                    </div>

                                    <div class="card-body">
                                        <table id="cart" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width:15%">Stage</th>
                                                    <th style="width:15%">Amount</th>
                                                    <th style="width:15%">Due Date</th>
                                                    <th style="width:15%">Created at</th>
                                                    <th style="width:17%">Created By</th>
                                                    <th style="width:15%">Update Stage</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td><button class="{{$stage_bg[$quote->quote_stage]}}">{{$stages[$quote->quote_stage]}}</button></td>
                                                    <td>INR {{$quote->amount}}</td>
                                                    <td>{{date('d M, Y', strtotime($quote->due_date))}}</td>
                                                    <td>{{date('d M, Y', strtotime($quote->created_at))}}</td>
                                                    <td>{{$quote->user->name}} <a href="{{ url('generate-pdf')}}">Download</a></td>
                                                    <td>
                                                        {{ Form::select('quote_stage',array(''=>'Please select')+$stages, $quote->quote_stage,['class'=>'form-control', 'id'=>'quote_stage']) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-----------  Main quote Product Details Ends From Here  ----------->
                        <div class="row">
                            <div class="col-md-12">

                                <div id="quote-accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <span class="mb-0">
                                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapse_{{$quote->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                Product Details
                                                </button>
                                            </span>
                                        </div>

                                        <div id="collapse_{{$quote->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#quote-accordion">
                                            <div class="card-body">

                                                <table id="cart" class="table table-hover table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:15%">Product</th>
                                                            <th style="width:15%">Quantity</th>
                                                            <th style="width:20%">Unit Price</th>
                                                            <th style="width:15%">Tax</th>
                                                            <th style="width:15%">Tax Amt.</th>
                                                            <th style="width:20%" class="text-center">Subtotal</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    @php $total = 0 @endphp

                                                    @if($cart)

                                                        @foreach($cart as $id => $details)

                                                            <?php $total += $details['cost']; ?>

                                                            <tr>
                                                                <td data-th="Product">{{ $details['name'] }}</td>
                                                                <td data-th="Quantity">{{ $details['quantity'] }}</td>
                                                                <td data-th="Price">INR {{ $details['price'] }}</td>
                                                                <td data-th="Quantity">{{ $details['tax'] }}%</td>
                                                                <td data-th="Quantity">INR {{ $details['tax_amount'] }}</td>
                                                                <td data-th="Subtotal" class="text-center">INR {{ $details['cost'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    </tbody>

                                                    <tfoot>
                                                    <tr class="visible-xs">
                                                        <td colspan="5"></td>
                                                        <td class="text-center"><strong>Total {{ $total }}</strong></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-----------  Main quote Product Details Ends From Here  ----------->


                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="mt-4 text-center">
                    SORRY! NO QUOTES FOUND!
                </div>
            @endif


            @if(!empty($deleted_quotes))

            <div class="text-center m-3">
                <h4>Previous Quotations</h4>
            </div>

            <div id="accordion">
                @foreach($deleted_quotes as $key => $old_cart)
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <p class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse_{{$old_cart['order']->id}}" aria-expanded="true" aria-controls="collapseOne">
                            Quote: {{$old_cart['order']->quote_name}}
                            </button>

                            <span class="pull-right">Dated:  {{date('d M, Y h:i A', strtotime($old_cart['order']->created_at))}}</span>
                        </p>
                    </div>

                    <div id="collapse_{{$old_cart['order']->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <table id="cart" class="table table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th style="width:10%">Sr.</th>
                                        <th style="width:30%">Product</th>
                                        <th style="width:20%">Price</th>
                                        <th style="width:20%">Quantity</th>
                                        <th style="width:20%" class="text-center">Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @php $total = 0 @endphp

                                @if($cart)
                                    @foreach($old_cart['cart'] as $id => $details)

                                        <?php $total += $details['cost'] ?>

                                        <tr>
                                            <td>{{$id+1}}.</td>
                                            <td data-th="Product">{{ $details['name'] }}</td>
                                            <td data-th="Price">INR {{ number_format($details['cost'] /  $details['quantity'], 2) }}</td>
                                            <td data-th="Quantity">{{ $details['quantity'] }}</td>
                                            <td data-th="Subtotal" class="text-center">INR {{ number_format($details['cost'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                </tbody>

                                <tfoot>
                                <tr class="visible-xs">
                                    <td colspan="4"></td>
                                    <td class="text-center"><strong>Total {{ number_format($total, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>

    </div>
</div>

@stop



@section('scripting')

<script type="text/javascript">

    $('#save_cart').click(function (e) {
        e.preventDefault();

        if ($("#dataForm").length > 0) {

            $("#dataForm").validate({

                errorClass: "is-invalid",

                unhighlight: function(element, errorClass, validClass) {
                    console.log(validClass);
                    $(element).removeClass(errorClass);
                    $(element).parent().removeClass(errorClass);
                    $('.standardSelect').selectpicker('refresh');
                },

                errorPlacement: function(error, element) {
                    element.parent().append( error );
                    $('.standardSelect').selectpicker('refresh');
                },


                rules: {
                    first_name: 'required',
                    status: 'required',
                    phone: {
                        required: true,
                        number: true,
                    },
                },

                messages: {
                    first_name: "Please Enter First Name.",
                    status: "Please Select Status.",
                    phone: {
                        required: "Please Enter Phone No",
                        number: "Phone No. must be a number.",
                    }
                },



                submitHandler: function(form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#saveBtn').html('Sending..');

                    $.ajax({
                        data: $('#dataForm').serialize(),
                        url: "{{ url('customer/store') }}",
                        type: "POST",
                        dataType: 'json',

                        success: function (data) {
                            swal({
                                title: "Good job!",
                                text: data.msg,
                                icon: "success",
                            })
                            .then((willDelete) => {
                                window.location.replace("{{url('customers')}}");
                            });
                        },

                        error: function (data) {
                            if (data.status == 422) {
                                var x = data.responseJSON;
                                $.each(x.errors, function( index, value ) {
                                    console.log(index);
                                    $("#"+index).addClass("is-invalid");
                                    $('.standardSelect').selectpicker('refresh');
                                    $("#"+index+"-error").html(value[0]);
                                });
                            }
                            $('#saveBtn').html('Save Changes');
                        }
                    });

                }
            })
        }

    });



    $('#send_mail').click(function() {
        var product_id = 19;
        $.ajax({
            type:"GET",
            url:"{{url('lead/quote/send_mail')}}/"+product_id,
            success: function (response) {
                alert("Mail Sent");
            }
        })
    });

</script>

@endsection
