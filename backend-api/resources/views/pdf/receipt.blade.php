<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="styles.css">
    <style>
            body {
                    font-family: Arial, sans-serif;
                    background-color: #f5f5f5;
                    margin: 0;
                    padding: 0;
                }

                .receipt {
                    width: 600px;
                    margin: 20px auto;
                    background-color: white;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }

                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .header .logo img {
                    max-width: 80px;
                }

                .header .title h1,
                .header .title h2 {
                    margin: 0;
                    font-size: 14px;
                    color: #003366;
                }

                .header .title p {
                    margin: 5px 0;
                    font-size: 12px;
                    color: #666;
                }

                .header .title h3,
                .header .title h4 {
                    margin: 0;
                    font-size: 16px;
                    color: #003366;
                }

                .details, .footer, .note {
                    margin-bottom: 20px;
                }

                .details p, .footer p {
                    margin: 5px 0;
                    font-size: 14px;
                    color: #333;
                }

                .details table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }

                .details table, .details th, .details td {
                    border: 1px solid #ccc;
                }

                .details th, .details td {
                    padding: 8px;
                    text-align: left;
                    font-size: 14px;
                    color: #333;
                }

                .footer p {
                    font-size: 14px;
                    color: #333;
                }

                .note p {
                    text-align: center;
                    font-size: 12px;
                    color: #666;
                }

    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">

            <div class="title">
                <h1>United Republic of Tanzania</h1>
                <h2>Information And Communication Technologies Commission</h2>
                <div class="logo">
                    <img src="{{ public_path('images/logo.jpeg') }}" style="width: 100%; max-width: 30%; max-height: 30%"/>
                </div>
                <h3>Exchequer Receipts</h3>
                <h4>Stakabadhi ya Malipo ya Serikali</h4>
            </div>
        </div>

        <div class="details">
            <p><strong>Receipt No :</strong> {{$bill_data->ReqId}}</p>
            <p><strong>Received from :</strong> {{$bill_data->customer_name}}</p>
            <p><strong>Amount :</strong> {{$bill_data->paid_amt}} ({{$bill_data->ccy || "TZS"}})</p>
            <p><strong>Amount in Words :</strong> {{numberToWords($bill_data->paid_amt)}}.</p>
            <p><strong>Outstanding Balance :</strong> 0.00 (TZS)</p>
            <p><strong>In respect of :</strong></p>
            <table>
                <tr>
                    <th>Item Description(s)</th>
                    <th>Item Amount</th>
                </tr>
                <tr>
                    <td>{{$bill_data->name}}</td>
                    <td>{{$bill_data->paid_amt}}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p><strong>Bill Reference :</strong> {{$bill_data->ack_id}}</p>
            <p><strong>Payment Control Number :</strong> {{$bill_data->cust_cntr_num}}</p>
            <p><strong>Payment Date :</strong> {{ \Carbon\Carbon::parse($bill_data->trx_dt_tm)->format('d M Y') }}</p>
            <p><strong>Issued by :</strong>{{$bill_data->billApproveBy}}</p>
            <p><strong>Date Issued :</strong>{{ \Carbon\Carbon::parse($bill_data->created_at)->format('d M Y') }}</p>
            <p><strong>Signature :</strong> ...................................</p>
        </div>

        <div class="note">
            <p>ICT Commission @ {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
