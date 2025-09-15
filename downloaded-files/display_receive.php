<?php
// Database connection details
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

// Check if delete action is requested
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare and execute delete query
    $sql_delete = "DELETE FROM amount_received WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    // Redirect to the same page to refresh the table
    header("Location: display_receive.php");
    exit();
}

// Query to fetch data from the `amount_received` table
$sql = "SELECT * FROM amount_received";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Received Amounts</title>
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
            background-color: #4CAF50;
            color: white;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        .delete-link {
            color: #e74c3c;
            font-weight: bold;
            cursor: pointer;
        }

        .delete-link:hover {
            color: #c0392b;
        }

        .actions {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Received Amounts</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction ID</th>
                <th>Description</th>
                <th>Amount Received (₹)</th>
                <th>Payment Mode</th>
                <th>Event Name</th>
                <th>Proof Upload</th>
                <th>Bill No.</th>
                <th>Remarks</th>
                <th>Actions</th>
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
                            <td>" . $row['amount_received'] . "</td>
                            <td>" . $row['payment_mode'] . "</td>
                            <td>" . $row['event_name'] . "</td>
                            <td><a href='" . $row['proof_upload'] . "' target='_blank'>View Proof</a></td>
                            <td>" . $row['bill_no'] . "</td>
                            <td>" . $row['remarks'] . "</td>
                            <td class='actions'>
                                <a href='display_receive.php?delete_id=" . $row['id'] . "' class='delete-link'>Delete</a>
                            </td>
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
    <a href="accounts.php">Back to Home</a>
</body>
</html>
