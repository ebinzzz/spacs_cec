
<?php
require 'config.php'; // DB connection file

// Get event_id and participant_id from GET parameters
$eventId = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$participantId = isset($_GET['participant_id']) ? intval($_GET['participant_id']) : 0;

// Validate input
if ($eventId <= 0 || $participantId <= 0) {
    die("Invalid Event ID or Participant ID.");
}
$stat='approved';
// Fetch participant details
$stmt = $conn->prepare("SELECT full_name, email FROM event_registrations WHERE event_id = ? AND id = ? AND status=?");
$stmt->bind_param("iis", $eventId, $participantId,$stat);
$stmt->execute();
$stmt->bind_result($participantName, $participantEmail);
if (!$stmt->fetch()) {
    die("Participant not found.");
}
$stmt->close();

// Fetch event details
$stmt = $conn->prepare("SELECT event_name, location AS venue, event_date FROM events WHERE id = ?");
$stmt->bind_param("i", $eventId);
$stmt->execute();
$stmt->bind_result($eventName, $venue, $date);
if (!$stmt->fetch()) {
    die("Event not found.");
}
$stmt->close();

// Generate QR code data
$qrData = "$eventId\n$participantId\nEvent: $eventName\nName: $participantName\nEmail: $participantEmail\nDate: $date";
$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Ticket - <?= htmlspecialchars($eventName) ?></title>
  <style>
  body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
  padding: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  color: #333;
}

.ticket {
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-radius: 16px;
  border: 1px solid #cbd2d9;
  max-width: 600px;
  width: 100%;
  padding: 30px 40px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  transition: transform 0.2s ease;
  color: #2f3e46;
}

.ticket:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.ticket h1 {
  font-size: 2.4rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 25px;
  color: #334e68;
  letter-spacing: 1px;
}

.details {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px 30px;
  font-size: 1rem;
  margin-bottom: 30px;
  color: #486581;
}

.details p {
  margin: 0;
  padding-left: 12px;
  position: relative;
}

.details p::before {
  content: "•";
  position: absolute;
  left: 0;
  color: #627d98;
  font-size: 1.2rem;
  top: 0;
  line-height: 1;
}

.details strong {
  color: #334e68;
  font-weight: 600;
}

.qr {
  text-align: center;
  margin-top: 25px;
}

.qr img {
  border-radius: 12px;
  padding: 10px;
  background: #f0f4f8;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  max-width: 200px;
  width: 100%;
  transition: transform 0.2s ease;
}

.qr img:hover {
  transform: scale(1.05);
}

.qr p {
  margin-top: 12px;
  font-size: 0.9rem;
  color: #768ba1;
  font-style: italic;
}

.footer {
  margin-top: 35px;
  text-align: center;
  font-size: 0.85rem;
  color: #94a3b8;
  border-top: 1px dashed #cbd2d9;
  padding-top: 14px;
  letter-spacing: 0.5px;
}

  </style>
</head>
<body>

<div class="ticket">
  <h1><?= htmlspecialchars($eventName) ?></h1>
  <div class="details">
    <p><strong>Event ID:</strong> <?= htmlspecialchars($eventId) ?></p>
    <p><strong>Participant ID:</strong> <?= htmlspecialchars($participantId) ?></p>
    <p><strong>Venue:</strong> <?= htmlspecialchars($venue) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
    <p><strong>Participant:</strong> <?= htmlspecialchars($participantName) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($participantEmail) ?></p>
  </div>

  <div class="qr">
    <img src="<?= $qrCodeUrl ?>" alt="QR Code">
    <p>Scan for entry verification</p>
  </div>

  <div class="footer">
    © <?= date("Y") ?> SPACS, College of Engineering Cherthala
  </div>
</div>

</body>
</html>
