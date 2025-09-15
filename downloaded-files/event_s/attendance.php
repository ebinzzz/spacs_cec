<?php
require 'config.php'; // DB connection

// Fetch all events with their dates
$events = [];
$sql = "SELECT id, event_name, event_date FROM events ORDER BY event_date DESC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Get selected event_id and event_date
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$event_date = isset($_GET['event_date']) ? $_GET['event_date'] : date('Y-m-d');

$participants = [];
$event_name = '';

if ($event_id) {
    // Event name for heading
    $stmt = $conn->prepare("SELECT event_name FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->bind_result($event_name);
    $stmt->fetch();
    $stmt->close();

    // Get approved participants and attendance
    $query = "
        SELECT er.id AS reg_id, er.full_name, er.email, er.branch, er.year, er.course,
               COALESCE(a.forenoon, 0) AS forenoon, COALESCE(a.afternoon, 0) AS afternoon
        FROM event_registrations er
        LEFT JOIN attendance a 
          ON er.id = a.registration_id AND a.event_id = ? AND a.event_date = ?
        WHERE er.event_id = ? AND er.status = 'approved'
        ORDER BY er.full_name ASC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isi", $event_id, $event_date, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }
    $stmt->close();
}

// Save attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_event_id = intval($_POST['event_id']);
    $post_event_date = $_POST['event_date'];

    foreach ($_POST['attendance'] as $reg_id => $att) {
        $forenoon = isset($att['forenoon']) ? 1 : 0;
        $afternoon = isset($att['afternoon']) ? 1 : 0;

        $checkStmt = $conn->prepare("SELECT id FROM attendance WHERE registration_id = ? AND event_id = ? AND event_date = ?");
        $checkStmt->bind_param("iis", $reg_id, $post_event_id, $post_event_date);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $updateStmt = $conn->prepare("UPDATE attendance SET forenoon = ?, afternoon = ? WHERE registration_id = ? AND event_id = ? AND event_date = ?");
            $updateStmt->bind_param("iiiis", $forenoon, $afternoon, $reg_id, $post_event_id, $post_event_date);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            $insertStmt = $conn->prepare("INSERT INTO attendance (registration_id, event_id, event_date, forenoon, afternoon) VALUES (?, ?, ?, ?, ?)");
            $insertStmt->bind_param("iisis", $reg_id, $post_event_id, $post_event_date, $forenoon, $afternoon);
            $insertStmt->execute();
            $insertStmt->close();
        }
        $checkStmt->close();
    }

    header("Location: attendance.php?event_id=$post_event_id&event_date=$post_event_date&success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - <?= htmlspecialchars($event_name ?: 'Select Event') ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5faff; padding: 20px; }
        h2, h3 { text-align: center; }
        form { margin: 20px auto; max-width: 700px; text-align: center; }
        label { margin: 0 15px 10px; display: inline-block; font-weight: bold; }
        select, input[type="date"] { padding: 6px 10px; font-size: 1em; border-radius: 4px; border: 1px solid #ccc; min-width: 200px; }
        button { padding: 10px 25px; font-size: 1.1em; border: none; border-radius: 6px; background-color: #009966; color: white; cursor: pointer; margin-top: 15px; }
        button:hover { background-color: #007a4d; }
        table { margin: 20px auto; width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 10px rgb(0 0 0 / 0.1); }
        th, td { border: 1px solid #aaa; padding: 10px; text-align: center; font-size: 0.9em; }
        th { background-color: #0066cc; color: white; }
        input[type="checkbox"] { transform: scale(1.3); cursor: pointer; }
        .success-msg { text-align: center; color: green; font-weight: bold; margin-bottom: 15px; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const eventDateMap = {
                <?php foreach ($events as $ev) echo json_encode($ev['id']) . ': ' . json_encode($ev['event_date']) . ",\n"; ?>
            };
            const eventSelect = document.getElementById('event_id');
            const dateInput = document.getElementById('event_date');
            eventSelect.addEventListener('change', function () {
                const selectedId = this.value;
                dateInput.value = eventDateMap[selectedId] || '';
            });
            if (eventSelect.value) {
                eventSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</head>
<body>

<h2>SPACS Attendance Management</h2>

<form method="GET" action="attendance.php">
    <label for="event_id">Select Event:</label>
    <select name="event_id" id="event_id" required>
        <option value="">-- Choose Event --</option>
        <?php foreach ($events as $ev): ?>
            <option value="<?= $ev['id'] ?>" <?= ($ev['id'] == $event_id) ? 'selected' : '' ?>><?= htmlspecialchars($ev['event_name']) ?></option>
        <?php endforeach; ?>
    </select>
    <label for="event_date">Event Date:</label>
    <input type="date" id="event_date" name="event_date" value="<?= htmlspecialchars($event_date) ?>" readonly />
    <button type="submit">Load Participants</button>
</form>

<?php if (isset($_GET['success'])): ?>
    <p class="success-msg">Attendance saved successfully!</p>
<?php endif; ?>

<?php if ($event_name && $participants): ?>
<form method="POST" action="attendance.php">
    <input type="hidden" name="event_id" value="<?= $event_id ?>">
    <input type="hidden" name="event_date" value="<?= htmlspecialchars($event_date) ?>">

    <h3><?= htmlspecialchars($event_name) ?> - <?= htmlspecialchars($event_date) ?></h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Branch</th>
                <th>Year</th>
                <th>Course</th>
                <th>Forenoon</th>
                <th>Afternoon</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($p['full_name']) ?></td>
                    <td><?= htmlspecialchars($p['branch']) ?></td>
                    <td><?= htmlspecialchars($p['year']) ?></td>
                    <td><?= htmlspecialchars($p['course']) ?></td>
                    <td><input type="checkbox" name="attendance[<?= $p['reg_id'] ?>][forenoon]" <?= $p['forenoon'] ? 'checked' : '' ?>></td>
                    <td><input type="checkbox" name="attendance[<?= $p['reg_id'] ?>][afternoon]" <?= $p['afternoon'] ? 'checked' : '' ?>></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit">Save Attendance</button>
</form>
<?php elseif ($event_id): ?>
    <p style="text-align:center; margin-top: 20px;">No approved participants found for this event and date.</p>
<?php endif; ?>
</body>
</html>