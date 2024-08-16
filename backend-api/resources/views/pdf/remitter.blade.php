<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }  .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header img {
            width: 50px;
            height: ;: 50px;
            margin-bottom: 10px;
        }
        .header h1, .header h2, .header h3 {
            margin: 0;
        }
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }
        .header h2 {
            font-size: 16px;
            color: #666;
        }
        .header h3 {
            font-size: 16px;
            color: #000;
            margin-top: 5px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section p {
            margin: 5px 0;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
        }
        .qr-code {
            position: absolute;
            right: 0;
            top: 340px;
            text-align: center;
        }
        .qr-code img {
            width: 100px;
            height: 100px;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid black;
            text-align: center;
            margin-top: 40px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
    <title>Payment Slip</title>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{public_path('images/nembo.png')}}" alt="Coat of Arms" class="coat-of-arms">
        <h1>United Republic of Tanzania</h1>
        <h2>PMO - Labour, Youth, Employment and Persons With Disability</h2>
        <h3>Order Form for Electronic Funds Transfer to {{$bank_details['name']}}</h3>
    </div>    
    <div class="section">
        <h3>(a) Remitter / Tax Payer Details:</h3>
        <p><strong>Name of Account Holder(s):</strong> ..........................................................</p>
        <p><strong>Name of Commercial Bank:</strong> ..........................................................</p>
        <p><strong>Bank Account Number:</strong> ..........................................................</p>
        <div class="signatures">
            <div class="signature-line">Signature of the Transfer One</div>
            <div class="signature-line">Signature of the Transfer Two</div>
        </div>
    </div>
    
    <div class="section">
        <h3>(b) Beneficiary Details:</h3>
        <p><strong>Beneficiary Name:</strong> {{$bank_details['beneficiary']}}</p>
        <p><strong>Bank Name:</strong> {{$bank_details['name']}}</p>
        <p><strong>Account Number:</strong> {{$bank_details['account']}}</p>
        <p><strong>SWIFT Code:</strong> {{$bank_details['swft_code']}}</p>
        <p><strong>Control Number:</strong> {{$bill_data->cust_cntr_num}}</p>
        <p><strong>Beneficiary Account:</strong> {{$bank_details['account']}}</p>
        <p><strong>Payment Reference:</strong> ROC/{{$bill_data->cust_cntr_num}}</p>
        <p><strong>Transfer Amount:</strong> {{$bill_data->amount}} ({{$bill_data->ccy}})</p>
        <p><strong>Amount in Words:</strong> {{numberToWords($bill_data->amount)}}</p>
        <p><strong>Being payment for:</strong>  {{$bill_data->name}}</p>
        
        <div class="qr-code">
            <p>SCAN & PAY by MPESA or TIGO PESA APPs</p>
            <img alt="QR Code" src="data:image/png;base64, {!! base64_encode($qrCode) !!}">
        </div>
    </div>

    <div class="section">
        <table class="table">
            <thead>
                <tr>
                    <th>Billed Item (1)</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> {{$bill_data->name}}</td>
                    <td>{{$bill_data->amount}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <p><strong>Expires on:</strong> {{ \Carbon\Carbon::parse($bill_data->paid_date)->format('d M Y') }}</p>
        <p><strong>Prepared By:</strong> {{$bill_data->customer_name}}</p>
        <p><strong>Collection Centre:</strong>HEAD QUARTER - Dar es salaam</p>
        <p><strong>Printed By:</strong> {{$bill_data->customer_name}}</p>
        <p><strong>Printed on:</strong> {{ date('l, F j, Y') }}</p>
        <p><strong>Signature:</strong> ..........................................................</p>
    </div>

    <div class="note">
        <p><strong>Note to Commercial Bank:</strong></p>
        <p>1. Please capture the above information correctly. Do not change or add any text, symbols or digits on the information provided.</p>
        <p>2. Field 59 of MT103 is an <strong>"Account Number"</strong> with value: <strong>/{{$bank_details['account']}}</strong>. Must be captured correctly.</p>
        <p>3. Field 70 of MT103 is a <strong>"Control Number"</strong> with value: <strong>/ROC/{{$bill_data->cust_cntr_num}}</strong>. Must be captured correctly.</p>
    </div>
    <p>Government e Payment Gateway © {{ date('Y') }} All Rights Reserved (GePG)</p>

</div>

</body>
</html>
