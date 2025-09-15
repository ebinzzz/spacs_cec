<?php
// attendance_dashboard.php
require 'config.php';

// Fetch events for printing attendance lists (optional)
$events = [];
$sql = "SELECT id, event_name, event_date FROM events ORDER BY event_date DESC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>SPACS Attendance Management</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f8ff;
    margin: 0; padding: 0;
  }
  header {
    background: #0066cc;
    color: white;
    padding: 15px 30px;
    text-align: center;
    font-size: 1.6em;
    font-weight: bold;
  }
  main {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 20px;
  }
  .nav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
    gap: 25px;
  }
  .card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 3px 12px rgb(0 0 0 / 0.1);
    padding: 30px 25px;
    text-align: center;
    transition: box-shadow 0.3s ease;
  }
  .card:hover {
    box-shadow: 0 5px 18px rgb(0 0 0 / 0.2);
  }
  .card h2 {
    margin-bottom: 18px;
    color: #004a99;
  }
  .card p {
    margin-bottom: 25px;
    color: #333;
    font-size: 1.05em;
  }
  .card a {
    display: inline-block;
    background-color: #009966;
    color: white;
    padding: 12px 30px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1em;
    transition: background-color 0.3s ease;
  }
  .card a:hover {
    background-color: #007a4d;
  }
  /* Event print list styles */
  .event-list {
    margin-top: 40px;
  }
  .event-list h3 {
    color: #0066cc;
  }
  .event-list ul {
    list-style-type: none;
    padding-left: 0;
  }
  .event-list li {
    background: #e6f0ff;
    margin: 6px 0;
    padding: 12px 18px;
    border-radius: 6px;
  }
  .event-list a {
    text-decoration: none;
    color: #004a99;
    font-weight: 600;
  }
  .event-list a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<header>
  SPACS Attendance Management Dashboard
</header>

<main>
  <div class="nav-grid">
    <div class="card">
      <h2>Manual Attendance</h2>
      <p>Mark attendance manually by selecting the event and participants.</p>
      <a href="attendance.php">Go to Manual Marking</a>
    </div>

    <div class="card">
      <h2>QR Code Attendance</h2>
      <p>Scan QR codes to mark participant attendance quickly and easily.</p>
      <a href="qr_attendance.php">Go to QR Scanner</a>
    </div>

    <div class="card">
      <h2>Print Attendance List</h2>
      <p>View and print the list of attendees for each event separately.</p>
      <a href="#print-list-section">Go to Print Lists</a>
    </div>
  </div>

  <section class="event-list" id="print-list-section">
    <h3>Print Attendance Lists by Event</h3>
    <?php if (count($events) > 0): ?>
      <ul>
        <?php foreach ($events as $ev): ?>
          <li>
            <a href="print_attendance.php?event_id=<?= $ev['id'] ?>" target="_blank">
              <?= htmlspecialchars($ev['event_name']) ?> (<?= htmlspecialchars($ev['event_date']) ?>)
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No events found.</p>
    <?php endif; ?>
  </section>
</main>

</body>
</html>
