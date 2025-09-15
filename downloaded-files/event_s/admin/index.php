<?php
// DB Connection
@include 'config.php';

// Fetch events
$events = $conn->query("SELECT id, event_name FROM events");

// Selected event
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$registrations = [];
$stat='pending';
if ($event_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM event_registrations WHERE event_id = ? AND status= ?");
    $stmt->bind_param("is", $event_id,$stat);
    $stmt->execute();
    $registrations = $stmt->get_result();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Review Registrations</title>

   <style>
  :root {
    --primary-color: #00bcd4; /* Light blue */
    --secondary-color: #4caf50; /* Green */
    --danger-color: #f44336;
    --bg-color: #f0f8ff;
    --text-color: #333;
    --table-header: #00acc1;
  }

  * {
    box-sizing: border-box;
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    background-color: var(--bg-color);
    padding: 30px;
    color: var(--text-color);
  }

  h1 {
    color: var(--primary-color);
    border-bottom: 3px solid var(--primary-color);
    padding-bottom: 10px;
    margin-bottom: 30px;
  }

  form select {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    margin-top: 10px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 188, 212, 0.1);
  }

  th {
    background-color: var(--table-header);
    color: white;
    padding: 12px;
    text-align: left;
    font-weight: 600;
  }

  td {
    padding: 12px;
    border-bottom: 1px solid #eee;
  }

  td a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: bold;
  }

  .status {
    text-transform: capitalize;
    font-weight: 600;
  }

  .actions button {
    padding: 7px 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    font-size: 14px;
  }

  .approve {
    background-color: var(--secondary-color);
    color: white;
    margin-right: 5px;
  }

  .disapprove {
    background-color: var(--danger-color);
    color: white;
  }

  .actions form {
    display: inline;
  }

  @media (max-width: 768px) {
    table, th, td {
      font-size: 14px;
    }

    .actions button {
      padding: 5px 10px;
      font-size: 12px;
    }
  }
</style>

</head>
<body>

<h1>Admin Panel - Review Event Registrations</h1>

<form method="GET">
  <label>Select Event: </label>
  <select name="event_id" onchange="this.form.submit()">
    <option value="">-- Select --</option>
    <?php while ($row = $events->fetch_assoc()): ?>
      <option value="<?= $row['id'] ?>" <?= $event_id == $row['id'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($row['event_name']) ?>
      </option>
    <?php endwhile; ?>
  </select>
</form>

<?php if ($event_id > 0): ?>
  <h2>Registrations</h2>
  <table>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Year</th>
      <th>Course</th>
      <th>Branch</th>
      <th>SPACS Member</th>
      <th>Proof</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
    <?php while ($row = $registrations->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['year']) ?></td>
        <td><?= htmlspecialchars($row['course']) ?></td>
        <td><?= htmlspecialchars($row['branch']) ?></td>
        <td><?= htmlspecialchars($row['spacs_member']) ?></td>
        <td>
          <?php if ($row['payment_proof']): ?>
            <a href="../uploads/payment_proofs/<?= urlencode($row['payment_proof']) ?>" target="_blank">View</a>
          <?php else: ?>
            No file
          <?php endif; ?>
        </td>
        <td class="status"><?= htmlspecialchars($row['status']) ?></td>
        <td class="actions">
          <form method="POST" action="update_status.php" style="display:inline;">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <button name="action" value="approve" class="approve">Approve</button>
            <button name="action" value="disapprove" class="disapprove">Disapprove</button>
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
<?php endif; ?>

</body>
</html>
