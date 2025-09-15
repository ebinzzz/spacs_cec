<?php
session_start();

$message = '';
$step = 1; // 1=registration form, 2=upload payment proof

// Database config
$host = "localhost";
$dbname = "spacs";
$user = "root";
$pass = "";

// Connect once for the whole script
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// Step 1: Registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Validate registration inputs
    $full_name = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $branch = trim($_POST['branch'] ?? '');
    $spacs_member = trim($_POST['spacsMember'] ?? '');
    $membership_id = ($spacs_member === 'yes') ? trim($_POST['membershipId'] ?? '') : null;
    $event_id = isset($_GET['event']) ? intval($_GET['event']) : 0;

    if ($event_id <= 0) {
        die("Invalid event ID.");
    }

    if (!$full_name || !$email || !$phone || !$year || !$course || !$branch || !$spacs_member || ($spacs_member === 'yes' && !$membership_id)) {
        $message = "Please fill all required fields in registration.";
    } else {
        // Save registration data in session
        $_SESSION['registration'] = [
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'year' => $year,
            'course' => $course,
            'branch' => $branch,
            'spacs_member' => $spacs_member,
            'membership_id' => $membership_id,
            'event_id' => $event_id,
        ];
        $step = 2; // Show upload form next
    }
}

// Step 2: Payment proof upload submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_proof'])) {
    if (!isset($_SESSION['registration'])) {
        die("No registration data found. Please register first.");
    }

    $registration = $_SESSION['registration'];

    // Check file upload
    if (!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK) {
        $message = "Please upload your payment proof.";
        $step = 2;
    } else {
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        $file_tmp = $_FILES['payment_proof']['tmp_name'];
        $file_type = mime_content_type($file_tmp);

        if (!in_array($file_type, $allowed_types)) {
            $message = "Invalid file type. Only JPG, PNG, or PDF allowed.";
            $step = 2;
        } else {
            $upload_dir = __DIR__ . '/uploads/payment_proofs/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $extension = pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid('txn_', true) . '.' . $extension;
            $target_path = $upload_dir . $file_name;

            if (!move_uploaded_file($file_tmp, $target_path)) {
                $message = "Failed to upload payment proof. Please try again.";
                $step = 2;
            } else {
                // Insert into DB
                $stmt = $conn->prepare("INSERT INTO register (full_name, email, phone, event_id, year, course, branch, spacs_member, membership_id, registration_date, payment_proof) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
                $stmt->bind_param(
                    "ssssssssss",
                    $registration['full_name'],
                    $registration['email'],
                    $registration['phone'],
                    $registration['event_id'],
                    $registration['year'],
                    $registration['course'],
                    $registration['branch'],
                    $registration['spacs_member'],
                    $registration['membership_id'],
                    $file_name
                );

                if ($stmt->execute()) {
                    $message = "✅ Registration successful! Payment proof uploaded.";
                    unset($_SESSION['registration']); // clear session data
                    $step = 3; // finished
                } else {
                    $message = "❌ Database error: " . $stmt->error;
                    if (file_exists($target_path)) unlink($target_path);
                    $step = 2;
                }

                $stmt->close();
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Event Registration & Payment Proof</title>
   <style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

  :root {
    --green: #38b000;
    --blue: #00b4d8;
    --dark-blue: #0077b6;
    --text-dark: #1e293b;
    --input-border: #cbd5e1;
    --bg-gradient: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
  }

  body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    background:
      linear-gradient(90deg, rgba(0,180,216,0.07) 1px, transparent 1px),
      linear-gradient(0deg, rgba(56,176,0,0.07) 1px, transparent 1px),
      #001f3f;
    background-size: 40px 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
    color: var(--text-dark);
  }

  .container {
    background: white;
    max-width: 540px;
    width: 100%;
    border-radius: 20px;
    box-shadow:
      0 4px 15px rgba(0, 0, 0, 0.1),
      inset 0 0 50px rgba(0, 180, 216, 0.1);
    padding: 40px 48px;
    box-sizing: border-box;
  }

  h1 {
    text-align: center;
    margin-bottom: 12px;
    color: var(--blue);
    font-weight: 700;
    font-size: 2.4rem;
    letter-spacing: 0.04em;
  }

  .event-title {
    text-align: center;
    margin-bottom: 32px;
    font-weight: 600;
    font-size: 1.3rem;
    color: var(--green);
    letter-spacing: 0.03em;
  }

form {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 22px 30px; /* 30px horizontal gap */
  width: 100%;
}

input[type="text"],
input[type="email"],
input[type="tel"],
select {
  width: 100%;
  box-sizing: border-box; /* ensure padding/border stay inside width */
  padding: 12px 14px;
  border-radius: 10px;
  border: 1.8px solid var(--input-border);
  font-size: 1rem;
  color: var(--text-dark);
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

  input[type="text"]:focus,
  input[type="email"]:focus,
  input[type="tel"]:focus,
  select:focus {
    outline: none;
    border-color: var(--green);
    box-shadow: 0 0 6px var(--green);
  }

  .full-width {
    grid-column: 1 / -1;
  }

  .radio-group {
    display: flex;
    gap: 36px;
    margin-top: 8px;
  }

  .radio-group label {
    font-weight: 600;
    cursor: pointer;
  }

  .radio-group input[type="radio"] {
    margin-right: 10px;
    cursor: pointer;
  }

  .membership-id-container {
    display: none;
    grid-column: 1 / -1;
  }

  button {
    grid-column: 1 / -1;
    background: var(--bg-gradient);
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
    border: none;
    padding: 16px 0;
    border-radius: 14px;
    cursor: pointer;
    letter-spacing: 0.03em;
    transition: background 0.3s ease;
    box-shadow: 0 4px 14px rgba(0,180,216,0.4);
  }

  button:hover {
    background: linear-gradient(135deg, #00a1d6 0%, #279b39 100%);
  }

  /* Responsive */
  @media (max-width: 600px) {
    .container {
      padding: 30px 24px;
    }
    form {
      grid-template-columns: 1fr;
      gap: 18px 0;
    }
    .radio-group {
      gap: 20px;
    }
  }
</style>
<script>
function toggleMembershipId() {
    var spacsMember = document.getElementById('spacsMember').value;
    var membershipDiv = document.getElementById('membershipIdDiv');
    if (spacsMember === 'yes') {
        membershipDiv.style.display = 'block';
    } else {
        membershipDiv.style.display = 'none';
    }
}
window.onload = function() {
    toggleMembershipId();
};
</script>
</head>
<body>

<div class="container" role="main" aria-label="Event Registration and Payment Proof">

  <?php if($message): ?>
    <div class="message <?= strpos($message, 'successful') !== false ? 'success' : 'error' ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <?php if ($step === 1): ?>
    <h2>Event Registration</h2>
    <div class="container" role="main" aria-label="Event Registration Form">
  <h1>Register Now</h1>
  <div class="event-title" aria-live="polite" aria-atomic="true"><?php echo htmlspecialchars($event_name); ?></div>
  <!-- FORM action points to pay.php with event id -->
  <form id="registration-form" method="post" action="pay.php?event=<?php echo $event_id ?>" enctype="multipart/form-data" novalidate>
    <div>
      <label for="fullName">Full Name <span style="color:#d32f2f">*</span></label>
      <input type="text" id="fullName" name="fullName" required />
    </div>
    <div>
      <label for="email">Email <span style="color:#d32f2f">*</span></label>
      <input type="email" id="email" name="email" required />
    </div>
    <div>
      <label for="phone">Phone Number <span style="color:#d32f2f">*</span></label>
      <input type="tel" id="phone" name="phone" required />
    </div>
    <div>
      <label for="year">Year <span style="color:#d32f2f">*</span></label>
      <select id="year" name="year" required>
        <option value="" disabled selected>Select your year</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
      </select>
    </div>
    <div>
      <label for="course">Course <span style="color:#d32f2f">*</span></label>
      <select id="course" name="course" required>
        <option value="" disabled selected>Select your course</option>
        <option value="btech">B.Tech</option>
        <option value="mca">MCA</option>
        <option value="bsc">B.Sc</option>
      </select>
    </div>
    <div class="full-width">
      <label for="branch">Branch <span style="color:#d32f2f">*</span></label>
      <select id="branch" name="branch" required>
        <option value="" disabled selected>Select your branch</option>
        <option value="cse">CSE</option>
        <option value="ece">ECE</option>
        <option value="eee">EEE</option>
        <option value="ad">AD</option>
      </select>
    </div>
    <div class="full-width">
      <label>Are you a SPACS Student Member? <span style="color:#d32f2f">*</span></label>
      <div class="radio-group">
        <label><input type="radio" name="spacsMember" value="yes" required /> Yes</label>
        <label><input type="radio" name="spacsMember" value="no" /> No</label>
      </div>
    </div>
    <div class="membership-id-container full-width" id="membership-container">
      <label for="membershipId">Membership ID <span style="color:#d32f2f">*</span></label>
      <input type="text" id="membershipId" name="membershipId" />
    </div>
    <button type="submit">Proceed to Payment</button>
  </form>
</div>

  <?php elseif ($step === 2): ?>
    <h2>Complete Payment</h2>

    <div class="qr-code" aria-label="Payment QR Code">
      <img src="uploads/payment_qrcode/gpay.jpg" alt="Scan to Pay QR Code" />
      <p style="color: #555;">Scan this QR code to pay ₹50</p>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" aria-label="Upload payment transaction screenshot">
      <input type="hidden" name="upload_proof" value="1" />

      <label for="payment_proof">Upload Transaction Screenshot *</label>
      <input type="file" name="payment_proof" id="payment_proof" accept="image/*,application/pdf" required />

      <button class="submit-btn" type="submit">Submit Payment Proof</button>
    </form>

  <?php else: ?>
    <h2>Thank you!</h2>
    <p>Your registration and payment proof have been received.</p>
  <?php endif; ?>

</div>

</body>
</html>
