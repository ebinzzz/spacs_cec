<?php
@include 'config.php';

// Include the processing script or redirect here as needed, or just display message if set
$event_id = isset($_GET['event']) ? intval($_GET['event']) : 0;
$stmt = $conn->prepare("SELECT event_name,registration_fee FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($event_name,$registration_fee);
$stmt->fetch();
$stmt->close();
// For example, if form is submitted and processed in the same file, 
// make sure $message is defined before including this HTML part.
// Otherwise, you can pass $message via session or GET param.
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Payment Confirmation</title>
<style>
  :root {
    --blue: #0077b6;
    --green: #38b000;
    --light-gray: #f1f5f9;
  }
  body {
    font-family: 'Inter', sans-serif;
    background-color: #f0f8ff;
    margin: 0;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
  }
  .payment-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    padding: 40px 30px;
    max-width: 500px;
    width: 100%;
    text-align: center;
  }
  .payment-container h2 {
    color: var(--blue);
    margin-bottom: 16px;
    font-size: 1.8rem;
  }
  .qr-code {
    margin-bottom: 24px;
  }
  .qr-code img {
    max-width: 220px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  .upload-section {
    margin-top: 24px;
    text-align: left;
  }
  .upload-section label {
    display: block;
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--green);
  }
  .upload-section input[type="file"] {
    padding: 10px;
    width: 100%;
    border: 2px dashed var(--blue);
    border-radius: 10px;
    background-color: var(--light-gray);
    cursor: pointer;
  }
  .submit-btn {
    margin-top: 28px;
    padding: 14px 0;
    background: var(--blue);
    color: white;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 12px;
    width: 100%;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  .submit-btn:hover {
    background: #005f8f;
  }
  .message {
    margin-bottom: 20px;
    font-weight: 600;
  }
  .success {
    color: var(--green);
  }
  .error {
    color: #d32f2f;
  }
  @media (max-width: 480px) {
    .payment-container {
      padding: 28px 20px;
    }
    .qr-code img {
      max-width: 160px;
    }
  }
</style>
</head>
<body>

<div class="payment-container" role="main" aria-label="Payment Confirmation">
  <h2>Complete Payment</h2>

  <?php if(!empty($message)): ?>
    <div class="message <?= strpos($message, 'successful') !== false ? 'success' : 'error' ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <div class="qr-code">
    <img src="uploads/payment_qrcode/gpay.jpg" alt="Scan to Pay QR Code" />
    <p style="margin-top: 10px; color: #555;">Scan this QR code to pay Rs. <?php echo $registration_fee?></p>
  </div>

  <form action="process_payment.php?event=<?= isset($_GET['event']) ? intval($_GET['event']) : 0 ?>" method="POST" enctype="multipart/form-data" aria-label="Upload payment transaction screenshot">
    <!-- You must send all registration fields as hidden inputs -->
    <input type="hidden" name="fullName" value="<?= htmlspecialchars($_POST['fullName'] ?? '', ENT_QUOTES) ?>" />
    <input type="hidden" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>" />
    <input type="hidden" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES) ?>" />
    <input type="hidden" name="year" value="<?= htmlspecialchars($_POST['year'] ?? '', ENT_QUOTES) ?>" />
    <input type="hidden" name="course" value="<?= htmlspecialchars($_POST['course'] ?? '', ENT_QUOTES) ?>" />
    <input type="hidden" name="branch" value="<?= htmlspecialchars($_POST['branch'] ?? '', ENT_QUOTES) ?>" />
    <input type="hidden" name="spacsMember" value="<?= htmlspecialchars($_POST['spacsMember'] ?? '', ENT_QUOTES) ?>" />
    <input type="hidden" name="membershipId" value="<?= htmlspecialchars($_POST['membershipId'] ?? '', ENT_QUOTES) ?>" />

    <div class="upload-section">
      <label for="payment_proof">Upload Transaction Screenshot:</label>
      <input type="file" name="payment_proof" id="payment_proof" accept="image/*,application/pdf" required />
    </div>

    <button class="submit-btn" type="submit">Submit Payment Proof</button>
  </form>
</div>

</body>
</html>
