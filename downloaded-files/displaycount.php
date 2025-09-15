<!-- display_counts.php -->
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

// Fetch counts of active students for each semester and course
$sql = "
    SELECT semester, course, COUNT(*) as count 
    FROM users 
    WHERE status = 'active' 
    GROUP BY semester, course 
    ORDER BY semester, course
";
$result = $conn->query($sql);

$counts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $counts[$row['semester']][$row['course']] = $row['count'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Students Count</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #0073e6;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #0073e6;
            color: #ffffff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-button {
            display: block;
            width: 150px;
            margin: 0 auto;
            padding: 10px 20px;
            text-align: center;
            color: #ffffff;
            background-color: #0073e6;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Active Students Count by Semester and Course</h2>
        <table>
            <thead>
                <tr>
                    <th>Semester</th>
                    <th>Computer Science and Engineering (CSE)</th>
                    <th>Electronics and Communication Engineering (ECE)</th>
                    <th>Electrical and Electronics Engineering (EEE)</th>
                    <th>Artificial Intelligence (AI)</th>
                    <th>Others (OT)</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($semester = 1; $semester <= 8; $semester++): ?>
                    <tr>
                        <td>Semester <?php echo $semester; ?></td>
                        <td><?php echo isset($counts[$semester]['cse']) ? $counts[$semester]['cse'] : 0; ?></td>
                        <td><?php echo isset($counts[$semester]['ece']) ? $counts[$semester]['ece'] : 0; ?></td>
                        <td><?php echo isset($counts[$semester]['eee']) ? $counts[$semester]['eee'] : 0; ?></td>
                        <td><?php echo isset($counts[$semester]['ai']) ? $counts[$semester]['ai'] : 0; ?></td>
                        <td><?php echo isset($counts[$semester]['ot']) ? $counts[$semester]['ot'] : 0; ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        <a href="user1.php" class="back-button">Back</a>
    </div>
</body>
</html>
