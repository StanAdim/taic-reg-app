<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            box-sizing: border-box;
        }
        .coat-of-arms {
            height: 80px;
            margin-bottom: 10px;
        }
        .bill-container {
            width: 595px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
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
        .content {
            width: 100%;
            position: relative;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .content .left {
            width: 70%;
        }
        .content .right {
            width: 25%;
            text-align: right;
        }
        .content .right img {
            width: 100%;
        }
        .content .right p {
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .total {
            font-weight: bold;
        }
        .footer {
            display: flex;
            justify-content: space-between;
        }
        .footer div {
            width: 48%;
            font-size: 12px;
            line-height: 1.6;
        }
        .footer .left {
            text-align: left;
        }
        .footer .right {
            text-align: right;
        }
        .signature {
            height: 40px;
            border-bottom: 1px dotted #000;
            width: 200px;
            margin: 20px 0;
        }
        .qr-code {
            position: absolute;
            right: 10px; /* Adjust as needed */
            top: 20px; /* Adjust as needed to align with your content */
            width: 80px; /* Adjusted for better fit */
            max-width: 80px; /* Ensures the QR code stays within the page */
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="header">
            <img src="{{public_path('images/nembo.png')}}" alt="Coat of Arms" class="coat-of-arms">
            <h1>United Republic of Tanzania</h1>
            <h2>PMO - Labour, Youth, Employment and Persons With Disability</h2>
            <h3>Government Bill</h3>
        </div>
        <div class="content">
            <div class="left">
                <p><strong>Control Number:</strong> {{$bill_data->cust_cntr_num}}</p>
                <p><strong>Payment Ref:</strong> {{$bill_data->name}}</p>
                <p><strong>Service Provider Code:</strong> {{$bill_data->sp_code}}</p>
                <p><strong>Payer Name:</strong> {{$bill_data->customer_name}}</p>
                <p><strong>Payer Phone:</strong> {{$bill_data->phone_number}}</p>
                <p><strong>Bill Description:</strong> {{$bill_data->remarks}}</p>
            </div>
                <div class="qr-code">
                    <img alt="QR Code" src="data:image/png;base64, {!! base64_encode($qrCode) !!}">
                    <p>SCAN & PAY by Mpesa | Tigo Apps</p>
                </div>
        </div>
        <table>
            <tr>
                <td>Billed Item (1)</td>
                <td>{{$bill_data->name}}</td>
                <td>{{$bill_data->amount}}</td>
            </tr>
            <tr class="total">
                <td colspan="2">Total Billed Amount</td>
                <td>{{$bill_data->amount}} (TZS)</td>
            </tr>
            <tr>
                <td>Amount in Words</td>
                <td colspan="2">{{numberToWords($bill_data->amount)}}</td>
            </tr>
            <tr>
                <td>Expires on</td>
                <td colspan="2">{{ \Carbon\Carbon::parse($bill_data->paid_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td>Prepared By</td>
                <td colspan="2">{{$bill_data->billApproveBy}}</td>
            </tr>
            <tr>
                <td>Collection Centre</td>
                <td colspan="2"> HEAD QUARTER - Dar es salaam</td>
            </tr>
            <tr>
                <td>Printed By</td>
                <td colspan="2">{{$bill_data->customer_name}}</td>
            </tr>
            <tr>
                <td>Printed on</td>
                <td colspan="2">{{ date('l, F j, Y') }}</td>
            </tr>
            <tr>
                <td>Signature</td>
                <td colspan="2">
                    <div class="signature"></div>
                </td>
            </tr>
        </table>
        <div class="footer">
            <div class="left">
                <p><strong>Jinsi ya Kulipa</strong></p>
                <p>1. Kupitia Benki: Fika tawi lolote au wakala wa benki ya CRDB, NMB, BOT. Namba ya kumbukumbu: {{$bill_data->cust_cntr_num}}.</p>
                <p>2. Kupitia Mitandao ya Simu: Ingia kwenye menyu ya mtandao husika</p>
                <p>- Chagua 4 (Lipa Bili)</p>
                <p>- Chagua 5 (Malipo ya Serikali)</p>
                <p>- Ingiza {{$bill_data->cust_cntr_num}} kama namba ya kumbukumbu</p>
            </div>
            <div class="right">
                <p><strong>How to Pay</strong></p>
                <p>1. Via Bank: Visit any branch or bank agent of CRDB, NMB, BOT. Reference Number: {{$bill_data->cust_cntr_num}}.</p>
                <p>2. Via Mobile Network Operators (MNO): Enter to the respective USSD Menu of MNO</p>
                <p>- Select 4 (Make Payments)</p>
                <p>- Select 5 (Government Payments)</p>
                <p>- Enter {{$bill_data->cust_cntr_num}} as reference number</p>
            </div>
        </div>
        <p>Government e Payment Gateway © {{ date('Y') }} All Rights Reserved (GePG)</p>

    </div>
</body>
</html>
