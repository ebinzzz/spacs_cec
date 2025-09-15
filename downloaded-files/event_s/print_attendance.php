<?php
require 'config.php';

$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$filter = $_GET['filter'] ?? 'both'; // 'forenoon', 'afternoon', or 'both'
$branch = $_GET['branch'] ?? '';
$year = $_GET['year'] ?? '';
$course = $_GET['course'] ?? '';

if (!$event_id) {
    die("Invalid event ID.");
}

// Fetch event info
$stmt = $conn->prepare("SELECT event_name, event_date FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($event_name, $event_date);
if (!$stmt->fetch()) {
    die("Event not found.");
}
$stmt->close();

// Build attendance filter SQL
$whereClauses = ["er.event_id = ?", "er.status = 'approved'"];
$paramTypes = "i";
$params = [$event_id];

// Attendance filter
if ($filter === 'forenoon') {
    $whereClauses[] = "a.forenoon = 1";
} elseif ($filter === 'afternoon') {
    $whereClauses[] = "a.afternoon = 1";
} elseif ($filter === 'both') {
    // both forenoon AND afternoon true
    $whereClauses[] = "a.forenoon = 1 AND a.afternoon = 1";
}

// Branch filter
if (!empty($branch)) {
    $whereClauses[] = "er.branch = ?";
    $paramTypes .= "s";
    $params[] = $branch;
}

// Year filter
if (!empty($year)) {
    $whereClauses[] = "er.year = ?";
    $paramTypes .= "s";
    $params[] = $year;
}

// Course filter
if (!empty($course)) {
    $whereClauses[] = "er.course = ?";
    $paramTypes .= "s";
    $params[] = $course;
}

$whereSql = implode(" AND ", $whereClauses);

$query = "
    SELECT er.full_name, er.branch, er.year, er.course, 
           COALESCE(a.forenoon, 0) AS forenoon, COALESCE(a.afternoon, 0) AS afternoon
    FROM event_registrations er
    LEFT JOIN attendance a ON er.id = a.registration_id AND a.event_date = ?
    WHERE $whereSql
    ORDER BY er.full_name ASC
";

$stmt = $conn->prepare($query);

// Bind params dynamically including event_date at first
// So param order: event_date (string), then event_id (int), then others

// Build bind_param args:
$bindParams = [];
$bindTypes = "s" . $paramTypes; // event_date is string (s) + other types
$bindParams[] = &$bindTypes;
$bindParams[] = &$event_date;  // event_date first param for LEFT JOIN condition

foreach ($params as $k => &$param) {
    $bindParams[] = &$param;
}

// Call bind_param with dynamic params
call_user_func_array([$stmt, 'bind_param'], $bindParams);

$stmt->execute();
$result = $stmt->get_result();

$participants = [];
while ($row = $result->fetch_assoc()) {
    $participants[] = $row;
}
$stmt->close();

// Fetch distinct branch, year, course for filters dropdowns
$branches = [];
$years = [];
$courses = [];

$resBranches = $conn->query("SELECT DISTINCT branch FROM event_registrations WHERE event_id = $event_id");
while ($r = $resBranches->fetch_assoc()) {
    $branches[] = $r['branch'];
}

$resYears = $conn->query("SELECT DISTINCT year FROM event_registrations WHERE event_id = $event_id");
while ($r = $resYears->fetch_assoc()) {
    $years[] = $r['year'];
}

$resCourses = $conn->query("SELECT DISTINCT course FROM event_registrations WHERE event_id = $event_id");
while ($r = $resCourses->fetch_assoc()) {
    $courses[] = $r['course'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Print Attendance - <?= htmlspecialchars($event_name) ?></title>
<style>
  @media print {
    body {
      margin: 10mm;
      font-family: Arial, sans-serif;
      font-size: 12pt;
      color: #000;
      background: #fff;
    }
    .no-print {
      display: none;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #333;
      padding: 6px 8px;
      text-align: left;
    }
    th {
      background-color: #004a99;
      color: white;
    }
  }

  body {
    font-family: Arial, sans-serif;
    padding: 20px;
    background: #f9f9f9;
    color: #222;
  }
  h1, h2 {
    text-align: center;
    margin-bottom: 0;
  }
  h2 {
    margin-top: 5px;
    color: #0066cc;
  }
  .filter-form {
    margin: 20px auto;
    text-align: center;
  }
  .filter-form select {
    font-size: 1em;
    padding: 6px 10px;
    margin-left: 10px;
  }
  .filter-form button {
    font-size: 1em;
    padding: 7px 14px;
    margin-left: 12px;
    cursor: pointer;
    background-color: #0066cc;
    border: none;
    color: white;
    border-radius: 4px;
    transition: background-color 0.3s ease;
  }
  .filter-form button:hover {
    background-color: #004a80;
  }
  table {
    margin-top: 25px;
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
  }
  th, td {
    border: 1px solid #aaa;
    padding: 10px 12px;
    text-align: center;
  }
  th {
    background-color: #007acc;
    color: white;
  }
</style>
</head>
<body>

<h1>SPACS Attendance List</h1>
<h2><?= htmlspecialchars($event_name) ?> (<?= htmlspecialchars($event_date) ?>)</h2>

<form method="GET" class="filter-form no-print" action="">
  <input type="hidden" name="event_id" value="<?= $event_id ?>">

  <label for="filter">Show Attendance: </label>
  <select name="filter" id="filter">
    <option value="both" <?= $filter === 'both' ? 'selected' : '' ?>>Forenoon AND Afternoon (Full Day)</option>
    <option value="forenoon" <?= $filter === 'forenoon' ? 'selected' : '' ?>>Forenoon Only</option>
    <option value="afternoon" <?= $filter === 'afternoon' ? 'selected' : '' ?>>Afternoon Only</option>
  </select>

  <label for="branch">Branch: </label>
  <select name="branch" id="branch">
    <option value="">-- All Branches --</option>
    <?php foreach ($branches as $b): ?>
      <option value="<?= htmlspecialchars($b) ?>" <?= $branch === $b ? 'selected' : '' ?>><?= htmlspecialchars($b) ?></option>
    <?php endforeach; ?>
  </select>

  <label for="year">Year: </label>
  <select name="year" id="year">
    <option value="">-- All Years --</option>
    <?php foreach ($years as $y): ?>
      <option value="<?= htmlspecialchars($y) ?>" <?= $year === $y ? 'selected' : '' ?>><?= htmlspecialchars($y) ?></option>
    <?php endforeach; ?>
  </select>

  <label for="course">Course: </label>
  <select name="course" id="course">
    <option value="">-- All Courses --</option>
    <?php foreach ($courses as $c): ?>
      <option value="<?= htmlspecialchars($c) ?>" <?= $course === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
    <?php endforeach; ?>
  </select>

  <button type="submit">Filter</button>
  <button type="button" onclick="window.print()">Print</button>
</form>

<?php if (count($participants) > 0): ?>
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
      <td><?= $p['forenoon'] ? "✓" : "" ?></td>
      <td><?= $p['afternoon'] ? "✓" : "" ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
  <p style="text-align:center; font-style: italic; color: #666;">No attendance records found for the selected criteria.</p>
<?php endif; ?>

</body>
</html>
