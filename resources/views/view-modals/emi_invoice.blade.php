<!DOCTYPE html>
<html>
    <head>
        <title>EMI Invoice</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <!-- <link rel="stylesheet" href="{{ asset('backend_assets/custom/css/invoice_1.css') }}"> -->

        <style>

            @import url("https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900");
            
            * {
                margin: 0;
                box-sizing: border-box;
                -webkit-print-color-adjust: exact;
            }

            body {
                background: #FFF;
                font-family: 'Roboto', sans-serif;
            }

            ::selection {
                background: #f31544;
                color: #FFF;
            }

            ::moz-selection {
                background: #f31544;
                color: #FFF;
            }

            .clearfix::after {
                content: "";
                clear: both;
                display: table;
            }

            .col-left {
                float: left;
            }

            .col-left p {
                font-size: .9em;
                color: #666;
                margin-bottom: .5em;
            }

            .col-right {
                float: right;
            }

            h1 {
                font-size: 1.5em;
                color: #444;
            }

            h2 {
                font-size: 1em;
            }

            h3 {
                font-size: 1.2em;
                font-weight: 300;
                line-height: 2em;
            }

            p {
                font-size: .85em;
                color: #666;
                line-height: 1.3em;
            }

            a {
                text-decoration: none;
                color: #00a63f;
            }

            #invoiceholder {
                width: 100%;
                height: 100%;
                padding: 0;
            }

            #invoice {
                position: relative;
                margin: 0 auto;
                width: 740px;
                padding: 30px 0;
                background: #FFF;
            }

            [id*='invoice-'] {
                /* Targets all id with 'col-' */
                /*  border-bottom: 1px solid #EEE;*/
                padding: 20px;
            }

            #invoice-top {
                border-bottom: 2px solid #00a63f;
            }

            #invoice-mid {
                min-height: 110px;
            }

            #invoice-bot {
                min-height: 240px;
                margin-bottom: 40px;
            }

            .logo {
                display: inline-block;
                vertical-align: middle;
                width: 110px;
                overflow: hidden;
            }

            .info {
                display: inline-block;
                vertical-align: middle;
                margin-left: 20px;
            }

            .logo img,
            .clientlogo img {
                width: 100%;
            }

            .clientlogo {
                display: inline-block;
                vertical-align: middle;
                width: 50px;
            }

            .clientinfo {
                display: inline-block;
                vertical-align: middle;
                margin-left: 20px
            }

            .title {
                float: right;
            }

            .title p {
                text-align: right;
            }

            #message {
                margin-bottom: 30px;
                display: block;
            }

            h2 {
                margin-bottom: 12px;
                color: #444;
            }

            .col-right td {
                color: #666;
                padding: 5px 8px;
                border: 0;
                font-size: 0.85em;
                border-bottom: 1px solid #eeeeee;
            }

            .col-right label {
                font-weight: 600;
                margin-left: 10px;
                color: #444;
                font-family: 'Roboto';
            }

            .col-right td {
                text-align:right
            }
            .col-right td span:first-child {
                float:left;
            }

            .table-invoice {
                width: 100%;
                border-collapse: collapse;
            }

            .table-main td {
                padding: 10px;
                border-bottom: 1px solid #cccaca;
                font-size: 0.8em;
                text-align: center;
            }

            .tabletitle th {
                border-bottom: 2px solid #ddd;
                /* text-align: right; */
            }

            /* .tabletitle th:nth-child(5) {
                text-align: right;
            } */

            .table-main th {
                font-size: 0.8em;
                text-align: center;
                padding: 5px 10px;
            }

            .item {
                width: 50%;
            }

            .list-item td {
                text-align: center;
            }

            .total-row th,
            .total-row td {
                text-align: right;
                font-weight: 700;
                font-size: .85em;
                border: 0 none;
            }

            .table-main {
                width: 100%;
                border-collapse: collapse;
            }

            .instruction {
                margin-top: 20px;
            }

            .instruction_content {
                font-size: .85em;
                color: #666;
                line-height: 1.3em;
                text-align: justify;
            }

            .footer-invoice {
                position: absolute;
                bottom: 20px;
                left: 0;
                right: 0;
                text-align: center;
                border-top: 1px solid #eeeeee;
                padding: 15px 20px;
                color: #666;
                font-size: .85em;
            }
            
        </style>

    </head>

    <body>

    @php
        $company_data = $data['company_data'];
        $customer_data = $data['customer_data'];
        $order_data = $data['order_data'];
        $emi_data = $data['emi_data'];
    @endphp

    <div id="invoiceholder">
            <div id="invoice">
                <div id="invoice-top">
                    <div class="logo"><img src="{{$company_data->logo}}" alt="Logo" /></div>
                    <div class="title">
                        <h1>Invoice #<span class="invoiceVal invoice_num">{{$emi_data->invoice_code}}</span></h1>
                        
                    </div>
                    <!--End Title-->
                </div>
                <!--End InvoiceTop-->

                
                <div id="invoice-mid">
                    <div id="message">
                        <h2>Hello {{ $customer_data->first_name }},</h2>
                        <p>An invoice with invoice number #<span id="invoice_num">{{$emi_data->invoice_code}}</span> is created and is waiting for payment. Please pay the amount before the due date.</p>
                    </div>
                    <div class="clearfix">
                        <div class="col-left">
                            <div class="clientlogo"><img src="https://cdn3.iconfinder.com/data/icons/daily-sales/512/Sale-card-address-512.png" alt="Sup" /></div>
                            <div class="clientinfo">
                                <h2 id="supplier">
                                    <strong>{{ $customer_data->first_name.' '.$customer_data->last_name }}</strong>
                                </h2>
                                <p id="address">{{ $customer_data->address }}</p>
                                <p id="city">{{ $customer_data->city }}</p>
                                <p id="country">IT - {{ $customer_data->pincode }}</p>
                                
                            </div>
                        </div>
                        <div class="col-right">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span>Invoice Date</span>
                                        </td>
                                        <td>
                                            <strong>{{date('d M, Y', strtotime($emi_data->invoice_date))}}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>Due Date</span>
                                        </td>
                                        <td>
                                            <strong>{{date('d M, Y', strtotime($emi_data->due_date))}}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>Invoice Total</span>
                                        </td>
                                        <td>
                                            <strong>INR {{ number_format($emi_data->emi_amount) }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!--End Invoice Mid-->
                <div id="invoice-bot">
                    <div id="table-invoice">
                        <table class="table-main">
                            <thead>
                                <tr class="tabletitle">
                                    <th>Sr</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Previous Balance</th>
                                    <th width="20%" align="right">Total</th>
                                </tr>
                            </thead>
                            <tr class="list-item">
                                <td data-label="Sr" class="tableitem">1.</td>
                                <td data-label="Description" class="tableitem">
                                    {{ $order_data->property->title.' ('.$order_data->property->size.')' }} <br>
                                    @if($emi_data->month == 0)
                                        <strong>Advance Payment</strong>
                                    @else
                                        <strong>EMI Month: {{$emi_data->month}}</strong>
                                    @endif
                                </td>
                                <td data-label="Taxable Amount" class="tableitem">INR {{ number_format($emi_data->emi_amount) }}</td>
                                <td data-label="Tax Code" class="tableitem">INR {{ number_format($order_data->current_balance) }}</td>
                                <td data-label="Total" class="tableitem">INR {{ number_format($emi_data->emi_amount + $emi_data->current_balance) }}</td>
                            </tr>
                            <tr class="list-item total-row">
                                <th colspan="4" class="tableitem">Grand Total</th>
                                <td data-label="Grand Total" class="tableitem">INR {{ number_format($emi_data->emi_amount + $order_data->current_balance) }}</td>
                            </tr>
                        </table>
                    </div>

                    <!--End Table-->
                    <div class="instruction">
                        <strong>Instructions:</strong>
                        <div class="instruction_content">
                            {!! $data['invoice_terms'] !!}
                        </div>
                    </div>
                </div>
                <!--End InvoiceBot-->
                <footer class="footer-invoice">
                    {!! $data['invoice_footer'] !!}
                </footer>
            </div>
            <!--End Invoice-->
        </div>
        <!-- End Invoice Holder-->
    </body>

</html>
