<?php
$event_id = isset($_GET['event']) ? intval($_GET['event']) : 0;
if ($event_id <= 0) {
    die("Invalid or missing event ID.");
}

// DB connection
@include 'config.php';

// Fetch event name
$event_name = "Selected Event";
$stmt = $conn->prepare("SELECT event_name,registration_fee FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($event_name,$registration_fee);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register for <?php echo htmlspecialchars($event_name); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
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
</head>
<body>
<div class="container" role="main" aria-label="Event Registration Form">
  <h1>Register Now</h1>
  <div class="event-title" aria-live="polite" aria-atomic="true"><?php echo htmlspecialchars($event_name); ?></div>
  <!-- FORM action points to pay.php with event id -->
  <form id="registration-form" method="post" action="payment_form.php?event=<?php echo $event_id ?>" enctype="multipart/form-data" novalidate>
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

<script>
  const form = document.getElementById('registration-form');
  const radios = document.getElementsByName('spacsMember');
  const membershipContainer = document.getElementById('membership-container');
  const membershipInput = document.getElementById('membershipId');

  function toggleMembershipInput() {
    const selected = Array.from(radios).find(r => r.checked);
    if (selected && selected.value === 'yes') {
      membershipContainer.style.display = 'block';
      membershipInput.setAttribute('required', 'required');
    } else {
      membershipContainer.style.display = 'none';
      membershipInput.removeAttribute('required');
      membershipInput.value = '';
    }
  }

  radios.forEach(radio => radio.addEventListener('change', toggleMembershipInput));
  toggleMembershipInput(); // Run on page load

form.addEventListener('submit', function(event) {
  event.preventDefault(); // Stop form initially

  // Basic HTML5 validation
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  // Phone number check
  const phone = document.getElementById('phone').value.trim();
  if (!/^\d{10}$/.test(phone)) {
    alert("Please enter a valid 10-digit phone number.");
    return;
  }

  // Check email duplication for this event
  const email = document.getElementById('email').value.trim();
  const eventId = <?php echo $event_id; ?>;

  fetch('check_email.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `event_id=${encodeURIComponent(eventId)}&email=${encodeURIComponent(email)}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.exists) {
      alert("This email has already been used to register for this event.");
    } else {
      form.submit(); // Proceed to payment
    }
  })
  .catch(() => {
    alert("Error checking email. Please try again.");
  });
});




  // Add form submit validation
  form.addEventListener('submit', function(event) {
    // Ensure all fields are filled and valid
    if (!form.checkValidity()) {
      event.preventDefault(); // Stop form from submitting
      form.reportValidity(); // Show built-in browser validation messages
      return;
    }

    // Additional validation if needed (e.g., phone number pattern)
    const phone = document.getElementById('phone').value.trim();
    if (!/^\d{10}$/.test(phone)) {
      alert("Please enter a valid 10-digit phone number.");
      event.preventDefault();
      return;
    }
  });
</script>

</body>
</html>
