<?php
// Database connection
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

// Insert data into the database if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $roll_number = $_POST['roll_number'];
    $date = date('Y-m-d');

    $sql = "INSERT INTO membership_fees (id, name, course, roll_number, date) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issss', $id, $name, $course, $roll_number, $date);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch all records
$sql = "SELECT * FROM membership_fees ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPACS CEC Membership Fee</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 20px;
        }

        h2 {
            color: #4A90E2;
            font-weight: 600;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        input[type="text"], input[type="submit"], input[type="number"] {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #4A90E2;
            outline: none;
        }

        input[type="submit"] {
            background-color: #4A90E2;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #357ABD;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4A90E2;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        tr:hover td {
            background-color: #e9e9e9;
        }

        @media (max-width: 768px) {
            input[type="text"], input[type="submit"], input[type="number"] {
                max-width: 100%;
            }

            .table-container {
                max-height: 300px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<h2>SPACS CEC Membership Fee Form</h2>

<form action="" method="POST">
    <label for="id">ID:</label><br>
    <input type="number" id="id" name="id" required><br><br>
    
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>
    
    <label for="course">Course:</label><br>
    <input type="text" id="course" name="course" required><br><br>
    
    <label for="roll_number">Roll Number:</label><br>
    <input type="text" id="roll_number" name="roll_number" required><br><br>
    
    <input type="submit" value="Submit">
</form>

<h2>Membership Fee Records</h2>

<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Roll Number</th>
            <th>Date</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                echo "<td>" . htmlspecialchars($row['roll_number']) . "</td>";
                echo "<td>" . date("d/m/Y", strtotime($row['date'])) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        ?>
    </table>
</div>

<?php
$conn->close();
?>

</body>
</html>
