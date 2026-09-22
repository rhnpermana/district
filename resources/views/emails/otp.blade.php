<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kode Verifikasi OTP</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #0b0b0b;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      color: #c6c6c6;
    }
    .email-container {
      max-width: 550px;
      margin: 40px auto;
      background-color: #121212;
      border: 1px solid rgba(220, 165, 62, 0.2);
      border-radius: 8px;
      overflow: hidden;
    }
    .header {
      background-color: #181818;
      padding: 30px;
      text-align: center;
      border-bottom: 2px solid #dca53e;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
      letter-spacing: 2px;
      color: #ffffff;
      text-transform: uppercase;
    }
    .header h1 span {
      color: #dca53e;
    }
    .content {
      padding: 35px 30px;
      text-align: center;
    }
    .content h2 {
      color: #ffffff;
      font-size: 20px;
      margin-top: 0;
      margin-bottom: 15px;
    }
    .content p {
      font-size: 14px;
      line-height: 1.6;
      color: #a0a0a0;
      margin-bottom: 25px;
    }
    .otp-box {
      background-color: #1a1a1a;
      border: 2px dashed #dca53e;
      border-radius: 8px;
      padding: 20px;
      display: inline-block;
      margin-bottom: 25px;
    }
    .otp-code {
      font-size: 36px;
      font-weight: bold;
      letter-spacing: 10px;
      color: #dca53e;
      margin: 0;
      font-family: monospace;
    }
    .expiry-note {
      font-size: 12px;
      color: #888888;
      margin-bottom: 0;
    }
    .footer {
      background-color: #0b0b0b;
      padding: 20px;
      text-align: center;
      font-size: 12px;
      color: #555555;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>DISTRICT<span>STUDIO.</span></h1>
    </div>
    <div class="content">
      <h2>Verifikasi Email Anda</h2>
      <p>Halo <strong>{{ $user->name }}</strong>,<br>Terima kasih telah mendaftar di District Studio. Gunakan kode OTP berikut untuk menyelesaikan proses verifikasi pendaftaran akun Anda:</p>
      
      <div class="otp-box">
        <div class="otp-code">{{ $otpCode }}</div>
      </div>
      
      <p class="expiry-note">Kode ini berlaku selama <strong>10 menit</strong>. Jangan bagikan kode OTP ini kepada siapapun demi keamanan akun Anda.</p>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} District Studio. All rights reserved.<br>
      Jika Anda tidak merasa mendaftar di layanan kami, abaikan email ini.
    </div>
  </div>
</body>
</html>
