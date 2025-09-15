<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ticket Verification</title>
  <script src="https://unpkg.com/html5-qrcode"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background: #f0f4f8;
    }

    #reader {
      width: 300px;
      margin: auto;
      border: 2px solid #2196f3;
      padding: 8px;
      border-radius: 12px;
      position: relative;
    }

    .scan-line {
      position: absolute;
      width: 100%;
      height: 2px;
      background: red;
      animation: scan 1.5s linear infinite;
    }

    @keyframes scan {
      0% { top: 0; }
      100% { top: 100%; }
    }

    .result {
      margin-top: 20px;
      padding: 15px;
      border-radius: 10px;
      font-weight: bold;
      display: inline-block;
    }

    .valid { background: #d4edda; color: #155724; border: 1px solid #28a745; }
    .already { background: #fff3cd; color: #856404; border: 1px solid #ffc107; }
    .invalid { background: #f8d7da; color: #721c24; border: 1px solid #dc3545; }
  </style>
</head>
<body>

<h2>Scan Ticket QR Code</h2>
<div id="reader">
  <div class="scan-line"></div>
</div>
<div id="output" class="result" style="display:none;"></div>

<script>
function showResult(type, message) {
  const output = document.getElementById('output');
  output.className = 'result ' + type;
  output.innerHTML = message;
  output.style.display = 'block';
}

function onScanSuccess(decodedText, decodedResult) {
  html5QrCode.stop().then(() => {
    fetch("verify.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "code=" + encodeURIComponent(decodedText)
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        showResult('valid', `✅ Verified: ${data.name}<br>${data.email}`);
      } else if (data.status === 'already_verified') {
        showResult('already', `⚠️ Already Verified: ${data.name}<br>${data.email}`);
      } else if (data.status === 'not_found') {
        showResult('invalid', "❌ Ticket not found or not approved.");
      } else {
        showResult('invalid', "❌ Invalid QR Code Format");
      }
    })
    .catch(() => showResult('invalid', "❌ Verification failed."))
    .finally(() => setTimeout(() => location.reload(), 1000));
  });
}

const html5QrCode = new Html5Qrcode("reader");
html5QrCode.start(
  { facingMode: "environment" },
  { fps: 10, qrbox: 250 },
  onScanSuccess
);
</script>

</body>
</html>
