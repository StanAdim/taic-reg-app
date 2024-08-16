<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .receipt-container {
            background-color: white;
            width: 800px;
            padding: 20px;
            margin: 0 auto;
            border: 1px solid #ccc;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .coat-of-arms {
            height: 80px;
            margin-bottom: 10px;
        }

        header h2 {
            color: #1f4584;
            margin: 5px 0;
        }

        header h3 {
            color: #006bb3;
            margin: 5px 0;
        }

        header p {
            margin: 2px 0;
            font-size: 14px;
        }

        .dotted-line {
            border: 0;
            border-top: 1px dashed #000;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .receipt-details p {
            font-size: 14px;
            margin: 8px 0;
        }

        .highlight {
            font-weight: bold;
        }

        .item-description {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .total-amount {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
        }

        .billing-info p {
            font-size: 14px;
            margin: 8px 0;
        }

        footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="receipt-container">
        <header>
            <img src="{{public_path('images/nembo.png')}}" alt="Coat of Arms" class="coat-of-arms">
            <h2>Jamhuri ya Muungano wa Tanzania</h2>
            <h3>United Republic of Tanzania</h3>
            <p>PMO - Labour, Youth, Employment and Persons With Disability</p>
            <p><strong>Exchequer Receipts</strong></p>
            <p><strong>Stakabadhi ya Malipo ya Serikali</strong></p>
            <hr class="dotted-line">
        </header>
        <section class="receipt-details">
            <p><strong>Receipt No:</strong> {{$bill_data->trx_id}}</p>
            <p><strong>Received from:</strong> <strong class="highlight">{{$bill_data->customer_name}}</strong></p>
            <p><strong>Amount:</strong> {{$bill_data->paid_amt}} (TZS)</p>
            <p><strong>Amount in Words:</strong> {{numberToWords($bill_data->paid_amt)}}.</p>
            <p><strong>Outstanding Balance:</strong> 0.00 (TZS)</p>
        </section>
        <section class="item-description">
            <table>
                <tr>
                    <th>Item Description(s)</th>
                    <th>Item Amount</th>
                </tr>
                <tr>
                    <td>140368 - {{$bill_data->name}}</td>
                    <td>{{$bill_data->paid_amt}}</td>
                </tr>
            </table>
            <p class="total-amount"><strong>Total Billed Amount:</strong> {{$bill_data->paid_amt}} (TZS)</p>
        </section>
        <section class="billing-info">
            <p><strong>Bill Reference:</strong> 1</p>
            <p><strong>Payment Control Number:</strong> <strong class="highlight"> {{$bill_data->cust_cntr_num}}</strong></p>
            <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($bill_data->paid_date)->format('d M Y') }}</p>
            <p><strong>Issued by:</strong> {{$bill_data->billApproveBy}}</p>
            <p><strong>Date Issued:</strong> {{ date('l, F j, Y') }}</p>
            <p><strong>Signature:</strong> _________________________</p>
        </section>
        <footer>
            <p>Government e Payment Gateway © 2019 All Rights Reserved (GePG)</p>
        </footer>
    </div>
</body>
</html>
