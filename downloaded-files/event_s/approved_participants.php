<?php
require 'config.php';

// Fetch all events for dropdown
$events = [];
$eventResult = $conn->query("SELECT id, event_name FROM events");
while ($row = $eventResult->fetch_assoc()) {
    $events[] = $row;
}

$participants = [];
$filters = ['event_id' => '', 'branch' => '', 'year' => '', 'course' => ''];
$eventTitle = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['event_id'])) {
    $filters = [
        'event_id' => $_GET['event_id'],
        'branch' => $_GET['branch'] ?? '',
        'year' => $_GET['year'] ?? '',
        'course' => $_GET['course'] ?? ''
    ];

    // Get Event Name
    $eventStmt = $conn->prepare("SELECT event_name FROM events WHERE id = ?");
    $eventStmt->bind_param("i", $filters['event_id']);
    $eventStmt->execute();
    $eventStmt->bind_result($eventTitle);
    $eventStmt->fetch();
    $eventStmt->close();

    $query = "SELECT full_name, email, branch, year, course FROM event_registrations WHERE event_id = ? AND status = 'approved'";
    $params = [$filters['event_id']];
    $types = "i";

    if (!empty($filters['branch'])) {
        $query .= " AND branch = ?";
        $params[] = $filters['branch'];
        $types .= "s";
    }
    if (!empty($filters['year'])) {
        $query .= " AND year = ?";
        $params[] = $filters['year'];
        $types .= "s";
    }
    if (!empty($filters['course'])) {
        $query .= " AND course = ?";
        $params[] = $filters['course'];
        $types .= "s";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approved Participants - SPACS</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #eaf4f8;
        padding: 20px;
        color: #333;
    }

    h2 {
        text-align: center;
        color: #006699;
        margin-bottom: 5px;
        font-size: 28px;
    }

    h3 {
        text-align: center;
        color: #009966;
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 22px;
    }

    form {
        margin-bottom: 25px;
        text-align: center;
        background: #ffffff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 102, 153, 0.1);
        display: inline-block;
        width: 100%;
        max-width: 900px;
        margin-left: 25%;
        margin-right: auto;
    }

    select, button {
        padding: 8px 12px;
        margin: 6px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        min-width: 120px;
    }

    button {
        background-color: #009966;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #007d52;
    }

    .print-btn {
        background-color: #006699;
    }

    .print-btn:hover {
        background-color: #005580;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        margin-top: 20px;
        box-shadow: 0 0 10px rgba(0, 102, 153, 0.1);
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
        font-size: 14px;
    }

    th {
        background-color: #006699;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f9fb;
    }

    tr:hover {
        background-color: #e6f7f1;
    }

    .signature-col {
        width: 150px;
    }

    .watermark {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: repeating-linear-gradient(
            45deg,
            rgba(0, 153, 102, 0.05) 0,
            rgba(0, 153, 102, 0.05) 1px,
            transparent 1px,
            transparent 40px
        );
        z-index: -1;
        pointer-events: none;
    }

    @media print {
        body {
            background: white;
        }

        form, .print-btn {
            display: none;
        }

        .watermark {
            display: block;
            background-image: repeating-linear-gradient(
                45deg,
                rgba(0, 153, 102, 0.08) 0,
                rgba(0, 153, 102, 0.08) 1px,
                transparent 1px,
                transparent 30px
            );
        }

        th {
            background-color: #000 !important;
            color: white !important;
        }
    }
</style>

</head>
<body>

<h2>SPACS Approved Participants</h2>

<?php if ($eventTitle): ?>
    <h3><?= htmlspecialchars($eventTitle) ?></h3>
<?php endif; ?>

<form method="GET">
    <select name="event_id" required>
        <option value="">-- Select Event --</option>
        <?php foreach ($events as $event): ?>
            <option value="<?= $event['id'] ?>" <?= $filters['event_id'] == $event['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($event['event_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="branch">
        <option value="">-- Branch --</option>
        <option value="CSE" <?= $filters['branch'] == 'CSE' ? 'selected' : '' ?>>CSE</option>
        <option value="ECE" <?= $filters['branch'] == 'ECE' ? 'selected' : '' ?>>ECE</option>
        <option value="EEE" <?= $filters['branch'] == 'EEE' ? 'selected' : '' ?>>EEE</option>
    </select>

    <select name="year">
        <option value="">-- Year --</option>
        <option value="1" <?= $filters['year'] == '1' ? 'selected' : '' ?>>1</option>
        <option value="2" <?= $filters['year'] == '2' ? 'selected' : '' ?>>2</option>
        <option value="3" <?= $filters['year'] == '3' ? 'selected' : '' ?>>3</option>
        <option value="4" <?= $filters['year'] == '4' ? 'selected' : '' ?>>4</option>
    </select>

    <select name="course">
        <option value="">-- Course --</option>
        <option value="BTech" <?= $filters['course'] == 'BTech' ? 'selected' : '' ?>>BTech</option>
        <option value="MTech" <?= $filters['course'] == 'MTech' ? 'selected' : '' ?>>MTech</option>
        <option value="MCA" <?= $filters['course'] == 'MCA' ? 'selected' : '' ?>>MCA</option>
    </select>

    <button type="submit">Filter</button>
    <button type="button" class="print-btn" onclick="window.print()">🖨 Print</button>
</form>

<div class="watermark">SPACS</div>

<?php if (!empty($participants)): ?>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Branch</th>
            <th>Year</th>
            <th>Course</th>
            <th class="signature-col">Signature</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($participants as $i => $p): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($p['full_name']) ?></td>
                <td><?= htmlspecialchars($p['email']) ?></td>
                <td><?= htmlspecialchars($p['branch']) ?></td>
                <td><?= htmlspecialchars($p['year']) ?></td>
                <td><?= htmlspecialchars($p['course']) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($filters['event_id']): ?>
    <p style="text-align:center;">No approved participants found for the selected filters.</p>
<?php endif; ?>

</body>
</html>
