<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Participation Certificate</title>
    <style>
        body{
            background-image: public_path({{URL::asset('siteimg/background.jpg')}});
            background-repeat: no-repeat;
        }
        .main{
            background-color: #f7f9f9f3;
            height: 595px;
            margin: 1.4rem auto;
            padding: 1.4rem;
            border-radius: .6rem;
            box-shadow: #00000059 0px 5px 15px;
        }
        .content{
            margin: 1.2rem;
            padding: .8rem;

        }
        .row{
            display:flex;
        }
        .block{
            margin-top: 2rem;
            background-color: #6b6565;
            padding:.05rem;
            margin-left: .13rem;
            width: .1rem;
            height: 120px;
            position: absolute;
            top: 3.2rem;
            left: 350px;
        }
        .middle1 {
            position: absolute;
            top: 6.4rem;
            left: 200px;
        }
        .middle2{
            position: absolute;
            top: 6.4rem;
            left:360px;
        }
        .heading {
            font-family:Verdana, sans-serif;
            font-weight: 600;
            font-size: 20px;
            margin: 1px 1px;
            color: #4c4d4e;
        }
        .nembo img {
            position: absolute;
            width: 120px;
            height: 120px;
        }
        .taic-logo img {
            position: relative;
            width: 330px;
            height: 160px;
        }
        .logo img {
            position: absolute;
            top: 3rem;
            left: 800px;
            width: 180px;
            height: 180px;
        }
        .content-center {
            position: absolute;
            top:14rem;
        }
        .content-center h1 {
            color:#00A3DE;
            font-size: 36pt;
            font-family:Verdana, sans-serif;
        }
        .normal{
            color: #6D6E71;
            font-family: Tahoma, sans-serif;
            font-size: 12pt;
            margin: 2px 1px;
        }
        .greener{
            color: #39B34E; 
            font-family:Tahoma, sans-serif;
            font-size: 15pt;
            margin: 2px 1px;
            font-weight: 600;
        }        
        .attendeeName{
            color: black;
            font-family: Tahoma, sans-serif;
            font-size: 22pt;
            font-weight: 600;
            margin: 1px 1px;
            text-transform: uppercase;
        }
        .name{
            color: #00A3DE;
            font-family: Tahoma, sans-serif;
            font-size: 14pt;
            margin: 2px 1px;
        }
        .lower-row{
            position: absolute;
            top:16rem;
        }
        .signature{
            position: relative;
            top: 5.2rem;
            left: 600px;
        } 
        .sign img{
            width: 90px;
            height: 40px;
        }
        .taic-logo{
            position: relative;
            top: 16rem;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="content">
            <div class="row">
                <div class="col">
                    <div class="nembo">
                        <img src="{{public_path('images/nembo.png')}}" alt="nembo">
                    </div>
                </div>
                <div class="col">
                    <div class="middle1">
                        <p class="heading">UNITED</p>
                        <p class="heading">REPUBLIC OF</p>
                        <p class="heading">TANZANIA</p>
                    </div>
                </div>
                <div class="col">
                    <div class="block"></div>
                </div>
                <div class="col">
                    <div class="middle2">
                        <p class="heading">Ministry of Information,</p>
                        <p class="heading">Communication and Information</p>
                        <p class="heading">Technology</p>
                    </div>
                </div>
                <div class="col">
                    <div class="logo">
                        <img src="{{public_path('images/logo.jpeg')}}" alt="logo">
                    </div>
                </div>
            </div>
            <div class="content-center">
                <h1>CERTIFICATE OF ATTENDANCE</h1>
                <p class="normal">is awarded to </p>
                <p class="attendeeName">{{$participantName}}</p>
                <p class="normal">with 15 Professional Development Hours (PHD) for active participation to the</p>
                <p class="greener">{{$eventName}}</p>
                <p class="normal">held at the</p>
                <p class="greener">{{$venue}}</p>
                <p class="greener">{{$eventDate}}</p>
            </div>
            <div class="lower-row">
                <div class="col">
                    <div class="taic-logo">
                        <!-- {{-- <img src="{{public_path('images/taic-bg.png')}}" alt="taic-logo"> --}} -->
                    </div>
                </div>
                <div class="col">
                    <div class="signature">
                        <div class="sign">
                            <img src="{{public_path('images/dg-signature.png')}}" alt="signature">                            
                        </div>
                        <hr />
                        <p class="name">Dr. N.M Mwasaga</p>
                        <p class="normal">Director General</p>
                        <p class="normal">ICT Commission</p>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
      
</body>
</html>