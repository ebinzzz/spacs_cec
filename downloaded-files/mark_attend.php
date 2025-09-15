<?
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: spacs.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        button[type="submit"] {
            background-color: #337ab7;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        button[type="submit"]:hover {
            background-color: #286090;
        }
        a {
            display: inline-block;
            margin-bottom: 20px;
            color: #337ab7;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="meetingdetail.php">&laquo; Back to Admin Page</a>
        <h1>Mark Attendance</h1>
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

        // Query to fetch execom members for attendance marking
        $sql = "SELECT id, memid, name, email, position FROM execom_member";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<form action="pro_attend.php" method="post">';
            echo '<input type="hidden" name="meeting_id" value="' . htmlspecialchars($_GET['meeting_id']) . '">'; // Use htmlspecialchars to prevent XSS
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Membership ID</th>';
            echo '<th>Name</th>';
            echo '<th>Email</th>';
            echo '<th>Position</th>';
            echo '<th>Attendance</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['memid']) . '</td>'; // Display Membership ID
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['position']) . '</td>'; // Display Position
                echo '<td>';
                echo '<label>';
                echo '<input type="checkbox" name="attendance[]" value="' . htmlspecialchars($row['id']) . '"> Mark Present';
                echo '</label>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '<br>';
            echo '<button type="submit">Submit Attendance</button>';
            echo '</form>';
        } else {
            echo "No execom members found.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
