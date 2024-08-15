<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT commission Remitter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .footer-note {
            text-align: center;
            margin-top: 20px;
            color: #333;
            font-size: 12px;
        }
        .receipt-container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* To use absolute positioning for child elements */
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .header p {
            margin: 0;
            font-size: 16px;
            color: #666;
        }
        .section-title {
            font-weight: bold;
            margin: 20px 0 10px;
            color: #333;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            padding: 8px;
            text-align: left;
        }
        .details-table th {
            background-color: #f2f2f2;
        }
        .details-table td {
            border-bottom: 1px solid #ccc;
        }
        .qr-code {
            position: absolute;
            right: 20px; /* Adjust as needed */
            top: 210px; /* Adjust as needed to align with your content */
            width: 100px; /* Adjust as needed */
            max-width: 100px; /* Ensures the QR code doesn't exceed this size */
        }
        .signature {
            margin-top: 40px;
            text-align: left;
        }
        .note {
            margin-top: 40px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div style="position: relative;">
            <div class="qr-code">
                <img alt="QR Code" src="data:image/png;base64, {!! base64_encode($qrCode) !!} ">
                <p>SCAN & PAY</p>
            </div>
        </div>
        <div class="header">
            <h2>United Republic of Tanzania</h2>
            <h3>Information And Communication Technologies Commission</h3>
            <img
            src="{{ public_path('images/logo.jpeg') }}"
            style="width: 100%; max-width: 20%; max-height: 20%"/>
                    <h4>Order Form for Electronic Funds Transfer to {{$bank_details["name"]}}</h4>
        </div>

        <div>
            <p class="section-title">a). Remitter / Tax Payer Details :-</p>

            <table class="details-table">
                <tr>
                    <td>Name of Account Holder(s)</td>
                    <td>.......................................................</td>
                </tr>
                <tr>
                    <td>Name of Commercial Bank</td>
                    <td>.......................................................</td>
                </tr>
                <tr>
                    <td>Bank Account Number</td>
                    <td>.......................................................</td>
                </tr>
                <tr>
                    <td>Signatories</td>
                    <td>....................................................... | .......................................................</td>
                </tr>
            </table>
        </div>

        <div>
            <p class="section-title">b). Beneficiary Details :-</p>
            <div style="position: relative;">
                <table class="details-table">
                    <tr>
                        <td>Beneficiary</td>
                        <td>{{$bank_details["beneficiary"]}}</td>
                    </tr>
                    <tr>
                        <td>Bank</td>
                        <td>{{$bank_details["name"]}}</td>
                    </tr>
                    <tr>
                        <td>Account Number</td>
                        <td>{{$bank_details["account"]}}</td>
                    </tr>

                    <tr>
                        <td>SWIFT Code</td>
                        <td>{{$bank_details["swft_code"]}}</td>
                    </tr>
                    <tr>
                        <td>Control Number</td>
                        <td>{{$bill_data->cust_cntr_num}}</td>
                    </tr>
                    <tr>
                        <td>Transfer Amount</td>
                        <td>{{$bill_data->amount}} ({{$bill_data->ccy}})</td>
                    </tr>
                    <tr>
                        <td>Amount in Words</td>
                        <td>{{numberToWords($bill_data->amount)}}</td>
                    </tr>
                    <tr>
                        <td>Being payment for</td>
                        <td>{{$bill_data->name}}</td>
                    </tr>
                    <tr>
                        <td>Billed Item</td>
                        <td>{{$bill_data->name}}</td>
                    </tr>
                    <tr>
                        <td>Expires on</td>
                        <td>{{ \Carbon\Carbon::parse($bill_data->bill_exp)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td>Prepared By</td>
                        <td>{{$bill_data->payee}}</td>
                    </tr>
                    <tr>
                        <td>Collection Centre</td>
                        <td>HEAD QUARTER</td>
                    </tr>
                    <tr>
                        <td>Printed By</td>
                        <td>{{$bill_data->customer_name}}</td>
                    </tr>
                    <tr>
                        <td>Printed on</td>
                        <td>{{ date('l, F j, Y') }}</td>
                    </tr>
                    <tr>
                        <td>Signature</td>
                        <td>.......................................................</td>
                    </tr>
                </table>
   
            </div>
        </div>

        <div class="footer-note">
            <p>ICT Commission @ {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
