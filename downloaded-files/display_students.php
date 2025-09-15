<!-- display_students.php -->
<?php
// Database connection parameters
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the semester and course from the form submission
$semester = $conn->real_escape_string($_GET['semester']);
$course = $conn->real_escape_string($_GET['course']);

// Fetch students based on semester, course, and active status
$sql = "SELECT memid, first_name, last_name, contact_no, email FROM users WHERE semester = '$semester' AND course = '$course' AND status = 'active'";
$result = $conn->query($sql);

// Fetch the count of active students
$count_sql = "SELECT COUNT(*) as count FROM users WHERE semester = '$semester' AND course = '$course' AND status = 'active'";
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$active_count = $count_row['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Active Students in Semester <?php echo htmlspecialchars($semester); ?> - <?php echo htmlspecialchars($course); ?></h2>
        <p>Total Active Students: <?php echo $active_count; ?></p>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['memid']); ?></td>
                            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No active students found for the selected semester and course.</p>
        <?php endif; ?>
    </div>
</body>
</html>
