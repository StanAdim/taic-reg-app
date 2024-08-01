
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
    <a
    href="{{$url}}" target="_blank" 
    style="
      font-size: 17px;
      padding: 0.5em 2em;
      border: transparent;
      box-shadow: 2px 2px 4px rgba(0,0,0,0.4);
      background: dodgerblue;
      color: white;
      border-radius: 4px;
      transition: background 0.3s ease, transform 0.1s ease;
    "
    onmouseover="
      this.style.background='linear-gradient(90deg, rgba(30,144,255,1) 0%, rgba(0,212,255,1) 100%)';
    "
    onmouseout="
      this.style.background='dodgerblue';
    "
    onmousedown="
      this.style.transform='translate(0em, 0.2em)';
    "
    onmouseup="
      this.style.transform='translate(0em, 0em)';
    "
  >
  Verify Account
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