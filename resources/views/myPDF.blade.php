<!DOCTYPE html>
<html>
    <head>
        <title>Quote</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <!-- <link rel="stylesheet" href="{{ asset('backend_assets/custom/css/invoice_1.css') }}"> -->

        <style>
            
            * {
                margin: 0;
                box-sizing: border-box;
                -webkit-print-color-adjust: exact;
            }

            body {
                background: #FFF;
                /* font-family: 'Roboto', sans-serif; */
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

            .col-right {
                float: right;
            }

            h1 {
                font-size: 1.5em;
                color: #444;
            }

            h2 {
                font-size: .9em;
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
                margin-bottom: 60px;
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
                margin-bottom: 5px;
                color: #444;
            }

            .col-right td {
                color: #666;
                padding: 5px 8px;
                border: 0;
                font-size: 0.85em;
                border-bottom: 1px solid #eeeeee;
            }

            .col-right td label {
                margin-left: 5px;
                font-weight: 600;
                color: #444;
            }

            .table-invoice {
                width: 100%;
                border-collapse: collapse;
            }

            .table-main td {
                padding: 10px;
                border-bottom: 1px solid #cccaca;
                font-size: 0.8em;
                text-align: left;
            }

            .tabletitle th {
                border-bottom: 2px solid #ddd;
                text-align: right;
            }

            .tabletitle th:nth-child(2) {
                text-align: left;
            }

            .table-main th {
                font-size: 0.8em;
                text-align: left;
                padding: 5px 10px;
            }

            .item {
                width: 50%;
            }

            .list-item td {
                text-align: right;
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
                                <h2 id="supplier">{{ $customer_data->first_name.' '.$customer_data->last_name }}</h2>
                                <p><span id="address">{{ $customer_data->address }}</span><br><span id="city">{{ $customer_data->city }}</span><br><span id="country">IT</span> - <span id="zip">{{ $customer_data->pincode }}</span><br></p>
                            </div>
                        </div>
                        <div class="col-right">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><span>Invoice Date</span><label>{{date('d M, Y', strtotime($emi_data->invoice_date))}}</label></td>
                                    </tr>
                                    <tr>
                                        <td><span>Due Date</span><label>{{date('d M, Y', strtotime($emi_data->due_date))}}</label></td>
                                    </tr>
                                    <tr>
                                        <td><span>Invoice Total</span><label>INR {{ number_format($emi_data->emi_amount) }}</label></td>
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
                                    <th>Quantity</th>
                                    <th>Emi Month</th>
                                    <th>EMI Amount</th>
                                    <th>Late Charges</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tr class="list-item">
                                <td data-label="Sr" class="tableitem">1.</td>
                                <td data-label="Description" class="tableitem">{{ $order_data->property->title.' ('.$order_data->property->size.')' }}</td>
                                <td data-label="Quantity" class="tableitem">1</td>
                                <td data-label="Unit Price" class="tableitem">{{ $emi_data->month }}</td>
                                <td data-label="Taxable Amount" class="tableitem">INR {{ number_format($emi_data->emi_amount) }}</td>
                                <td data-label="Tax Code" class="tableitem">INR {{ number_format($emi_data->late_charges) }}</td>
                                <td data-label="Total" class="tableitem">INR {{ number_format($emi_data->emi_amount + $emi_data->late_charges) }}</td>
                            </tr>
                            <tr class="list-item total-row">
                                <th colspan="6" class="tableitem">Grand Total</th>
                                <td data-label="Grand Total" class="tableitem">INR {{ number_format($emi_data->emi_amount + $emi_data->late_charges) }}</td>
                            </tr>
                        </table>
                    </div>
                    <!--End Table-->
                    <div class="instruction">
                        <strong>Instructions:</strong>
                        <ul>
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                            <li>4</li>
                        </ul>
                    </div>
                </div>
                <!--End InvoiceBot-->
                <footer class="footer-invoice">
                    Our mailing address is
                </footer>
            </div>
            <!--End Invoice-->
        </div>
        <!-- End Invoice Holder-->
    </body>

</html>
