<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Badge</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: block;
            position: relative;
        }
        .container {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .badge {
            width: 300px;
            border: 2px solid #16a6ea;
            padding: 10px;
            text-align: center;
            border-radius: 20px;
        }
        .logo {
            width: 100px;
            border-radius: 10px;
        }
        .logo-section{
            padding:1.2rem .3rem;
        }
        .name {
            font-size: 24px;
            font-weight: bold;
            color: rgb(38, 145, 8);
            padding:.4rem .2rem;
        }
        .company {
            font-size: 18px;
        }
        .Qrcode {
            width: 150px;
            height:150px;
            margin: 20px auto;
        }
        .footer {
            border-radius: 20px;
            background-color: #0f9eeb;
            color: white;
            padding: 10px 0;
        }
        .event-name {
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="centered">
            <div class="badge">
                <div class="logo-section">
                    <img src="data:image/png;base64, {!! base64_encode(file_get_contents(base_path('public/images/'.'logo.jpeg'))) !!}" class="logo" alt="Logo">

                </div>
                <div class="name">{{ $firstName }} {{ $middle }} {{ $lastName }}</div>
                <div class="company">{{ $company }}</div>
                <img src="data:image/png;base64, {!! base64_encode($qrCode) !!}" class="Qrcode" alt="QRcode">
                <div class="footer">
                    <div class="event-name">{{$conference_name}}</div>
                    <div class="moto"> &#169; {{$currentYear}}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
