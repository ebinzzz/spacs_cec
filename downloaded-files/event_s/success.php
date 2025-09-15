<?php
// success.php

// Get event_id from query string and validate
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
if ($event_id <= 0) {
    die("Invalid event ID.");
}

// DB connection
@include 'config.php';


// Prepare and execute query to get event name
$stmt = $conn->prepare("SELECT event_name FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($event_name);
$stmt->fetch();
$stmt->close();
$conn->close();

if (!$event_name) {
    $event_name = "Unknown Event";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Registration Successful</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap');

  body {
    margin: 0;
    height: 100vh;
    background: #e0f7fa;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Inter', sans-serif;
  }

  .success-container {
    background: white;
    padding: 40px 60px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 150, 136, 0.3);
    text-align: center;
    max-width: 450px;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeSlideIn 1s forwards ease-out;
  }

  @keyframes fadeSlideIn {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .checkmark {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    display: inline-block;
    background: #26a69a;
    position: relative;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(38, 166, 154, 0.6);
  }
  .checkmark::after {
    content: '';
    position: absolute;
    left: 26px;
    top: 20px;
    width: 12px;
    height: 24px;
    border-right: 4px solid white;
    border-bottom: 4px solid white;
    transform: rotate(45deg);
    animation: checkmarkDraw 0.5s ease forwards;
    animation-delay: 0.7s;
  }
  @keyframes checkmarkDraw {
    from {
      width: 0;
      height: 0;
      opacity: 0;
    }
    to {
      width: 12px;
      height: 24px;
      opacity: 1;
    }
  }

  h1 {
    color: #00796b;
    margin-bottom: 10px;
    font-size: 1.9rem;
  }

  p {
    color: #004d40;
    font-size: 1.15rem;
    line-height: 1.4;
  }
</style>
</head>
<body>

<div class="success-container" role="alert" aria-live="polite" aria-atomic="true">
  <div class="checkmark" aria-hidden="true"></div>
  <h1>Registration Successful!</h1>
  <p>Thank you for registering for <strong><?= htmlspecialchars($event_name) ?></strong>.</p>
  <p>We look forward to seeing you at the event.</p>
</div>
  <script>
    setTimeout(() => {
      window.location.href = "https://www.google.com";
    }, 5000);
  </script>
</body>
</html>
