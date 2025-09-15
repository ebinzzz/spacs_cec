<?php
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

// Start session
session_start();

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM amount_spent WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
}

// Query to fetch data from the `amount_spent` table
$sql = "SELECT * FROM amount_spent";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spent Amounts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #dc3545;
            color: white;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        .btn-delete {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-delete:hover {
            color: #c82333;
        }
    </style>
</head>
<body>
    <h2>Spent Amounts</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction ID</th>
                <th>Description</th>
                <th>Amount Spent (₹)</th>
                <th>Payment Mode</th>
                <th>Event Name</th>
                <th>Proof Upload</th>
                <th>Bill No.</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if any records were found
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['transaction_id'] . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>" . $row['amount_spent'] . "</td>
                            <td>" . $row['payment_mode'] . "</td>
                            <td>" . $row['event_name'] . "</td>
                            <td><a href='" . $row['proof_upload'] . "' target='_blank'>View Proof</a></td>
                            <td>" . $row['bill_no'] . "</td>
                            <td>" . $row['remarks'] . "</td>
                            <td><a href='?delete_id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No data found</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="index.php">Back to Home</a>
</body>
</html>
