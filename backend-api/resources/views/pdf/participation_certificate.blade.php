<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Appreciation</title>
    <style>
.certificate-container {
    font-family: Arial, Helvetica, sans-serif;
    height: 700px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
    text-align: center;
    color: #333;
}
.header {
    background: #00a6ff;
    position: relative;
    height: 240px; /* Adjust based on your content */
    text-align: center;
}
.logo {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100px; /* Adjust based on your logo size */
}
.logo img {
    max-width: 100%;
    height: auto;
}
.logo:first-child {
    left: 10px;
}
.logo:last-child {
    right: 10px;
}
.header h1 {
    font-size: 36px;
    color: white;
}

.header h2 {
    font-size: 28px;
    margin-top: 10px;
    color: white;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-weight: 500;
}
.header h3 {
    font-size: 24px;
    margin-top: 10px;
    color: white;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-weight: 500;
}

.content {
    padding: 8px 30px;
    margin-top: 10px;
}

.subtitle {
    font-size: 18px;
    color: #333;
}

.name {
    font-size: 28px;
    margin: 20px 0;
    font-family: 'Cursive', sans-serif;
}

.headline {
    font-size: 20px;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #888;
}

.description {
    font-size: 16px;
    color: #666;
    padding: 0 10px;
}

.footer {
    padding: 6px  40px;
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    align-items: center;
}

.signature {
    text-align: center;
}

.signature p {
    font-size: 16px;
    margin: 5px 0;
}

.seal img {
    width: 80px;
    height: 80px;
}

    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="header">
            <div class="logo">
                <img src="{{public_path('/images/logo.jpeg')}}" alt="logo">
            </div> 
            <div class="">
            <h1>INFORMATION AND COMMUNICATION TECHNOLOGIES COMMISSION</h1>
            <h3>CERTIFICATE OF APPRECIATION</h3>
            <H2>8TH TANZANIA ANNUAL ICT CONFERRENCE</H2>
           </div>
            <div class="logo">
                <img src="{{public_path('/images/nembo.png')}}" alt="logo">
            </div>        
        </div>
        <div class="content">
            <p class="subtitle">The certificate is presented to:</p>
            <h3 class="name">{{"STANLEY JUSTINE MAHENGE"}}</h3>
            <p class="headline">For Exceptional Participation in the Annual ICT Conference</p>
            <p class="description">
                Your participation has been instrumental in shaping the success of this event, 
                and we recognize your commitment to fostering growth within the ICT sector
            </p>
        </div>
        <hr style="background: #00a6ff!important" />
        <div class="footer">
            <div class="signature">
                <p class="">Dr. N.M Mwasaga</p>
                <p class="">Director General</p>
                <p class="">ICT Commission</p>
            </div>
            <div class="seal">
                <img src="{{public_path('images/dg-signature.png')}}" alt="signature">                            
            </div>
        </div>
    </div>
</body>
</html>
