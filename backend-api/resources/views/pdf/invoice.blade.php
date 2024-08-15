<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICT Commission Bill</title>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .receipt {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0073e6;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .header h2 {
            color: #0073e6;
            margin: 0;
        }

        .header h3 {
            color: #333;
            margin: 0;
        }

        .header h4 {
            color: #333;
            margin: 5px 0;
        }

        .receipt-info p {
            margin: 5px 0;
            color: #333;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .item-table th, .item-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .item-table th {
            background-color: #0073e6;
            color: #fff;
        }

        .total {
            margin-top: 20px;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            margin-top: 20px;
        }

        .footer p {
            margin: 5px 0;
            color: #333;
        }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            color: #333;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h2>United Republic of Tanzania</h2>
            <h3>Information And Communication Technologies Commission</h3>
            <img
            src="{{ public_path('images/logo.jpeg') }}"
            style="width: 100%; max-width: 30%; max-height: 30%"/>
                    <h4>Invoice For {{$bill_data->name}} </h4>
            {{-- <h4>Stakabadhi ya Malipo ya Serikali</h4> --}}
        </div>
        <div class="receipt-info">
            <p><strong>Receipt No :</strong>{{$bill_data->ReqId}}</p>
            <p><strong>Received from :</strong> {{$bill_data->customer_name}}</p>
            <p><strong>Amount :</strong> {{$bill_data->amount}} (TZS)</p>
            <p><strong>Amount in Words :</strong> {{numberToWords($bill_data->amount)}}.</p>
            <p><strong>Outstanding Balance :</strong> {{$bill_data->amount}} (TZS)</p>
            <p><strong>In respect of :</strong></p>
            <table class="item-table">
                <tr>
                    <th>Item Description(s)</th>
                    <th>Item Amount</th>
                </tr>
                <tr>
                    <td>{{$bill_data->name}}</td>
                    <td> {{$bill_data->amount}}</td>
                </tr>
            </table>
        </div>
        <div class="total">
            <p>Total Billed Amount: {{$bill_data->amount}} (TZS)</p>
        </div>
        <div class="footer">

            <p><strong>Bill Reference :</strong>{{$bill_data->ack_id}}</p>
            <p><strong>Bill Control Number :</strong> {{$bill_data->cust_cntr_num}}</p>
            <p><strong>Bill Date :</strong>            
            <p><strong>Date Issued :</strong>{{ \Carbon\Carbon::parse($bill_data->created_at)->format('d M Y') }}</p>
        </p>
            <p><strong>Issued by :</strong> {{$bill_data->billGeneratedBy}}<p><strong>Date Issued :</strong>{{ \Carbon\Carbon::parse($bill_data->created_at)->format('d M Y') }}</p>
        </p>
            <p><strong>Date Issued :</strong> {{ \Carbon\Carbon::parse($bill_data->created_at)->format('d M Y') }}</p>
            <p><strong>Signature :</strong> ______________________</p>
        </div>
        <div class="footer-note">
            <p>ICT Commission @ {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
