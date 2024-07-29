
<div style="padding:1.4rem;background-color: #e8e8ef; font-size:large; font-family: Verdana, Geneva, Tahoma, sans-serif">
    <p style="padding:1px 2px; margin: 4px 1px;">Dear<b style="color:#105f8d;"> 
        {{$user->firstName}} {{$user->middleName}} {{$user->lastName}},
    </b>
    </p>
<p style="padding:4px 2px; margin: 4px 1px;">
    {{-- Email message --}}
    Thank you for registering for the Tanzania Annual ICT Conference 2024.
</p>
<p style="padding:4px 2px; margin:.6rem 1px;">
  To complete your registration, please verify your email address by clicking the link below:</p>

    <a href="{{$url}}" target="_blank" style="background-color:#0884cb;color:#ffffff;font-size:medium; border-radius:.8rem; padding:.5rem .6rem; border: 1px #156694 solid; text-decoration:none">
        Verify Account Now
    </a>
  
  <style>
  .button:hover {
    transform: scale(1.05);
    border-color: #fff9;
  }
  
  .button:hover .icon {
    transform: translate(4px);
  }
  
  .button:hover::before {
    animation: shine 1.5s ease-out infinite;
  }
  
  .button::before {
    content: "";
    position: absolute;
    width: 100px;
    height: 100%;
    background-image: linear-gradient(
      120deg,
      rgba(255, 255, 255, 0) 30%,
      rgba(255, 255, 255, 0.8),
      rgba(255, 255, 255, 0) 70%
    );
    top: 0;
    left: -100px;
    opacity: 0.6;
  }
  
  @keyframes shine {
    0% {
      left: -100px;
    }
  
    60% {
      left: 100%;
    }
  
    to {
      left: 100%;
    }
  }
  </style>
  

<p style="padding:4px 2px; margin: 4px 1px;">
    For any inquiries contact us at:
</p>
<p style="padding:1px 2px; margin: 4px 1px;">Hotline : <span style="color: #105f8d;font-weight:600;">+255 738 171 742</span></p>
<p style="padding:1px 2px; margin: 4px 1px;">Email : 
  <span style="color: #0884cb;font-weight:600">support@ictc.go.tz</span>
</p>
<p style="padding:4px 2px; margin: 4px 1px;">We look forward to your participation in the conference.</p>

<p style="padding:1px 2px; margin: 4px 1px;">Warm regards!</p>
<p style="padding:1px 2px; margin: 4px 1px;">--------------</p>
<p style="font-weight: 800;padding:1px 2px; margin: 4px 1px; font-size: larger">ICT Commission</p>
</div>