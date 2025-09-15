<?php
   $db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

// Start session


// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all received records
$sql_all_received = "SELECT * FROM amount_received ORDER BY date";
$received_data = $conn->query($sql_all_received);

// Fetch all spent records
$sql_all_spent = "SELECT * FROM amount_spent ORDER BY date";
$spent_data = $conn->query($sql_all_spent);

// Fetch total received and spent
$sql_received_total = "SELECT SUM(amount_received) AS total_received FROM amount_received";
$total_received = ($conn->query($sql_received_total)->fetch_assoc())['total_received'];

$sql_spent_total = "SELECT SUM(amount_spent) AS total_spent FROM amount_spent";
$total_spent = ($conn->query($sql_spent_total)->fetch_assoc())['total_spent'];

// Calculate balance
$balance = $total_received - $total_spent;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tally of Received and Spent Amounts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .tally-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        .tally-column {
            width: 50%;
            border-right: 1px solid #ddd;
        }

        .tally-column:last-child {
            border-right: none;
        }

        .tally-column h3 {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            margin: 0;
        }

        .tally-column table {
            width: 100%;
            border-collapse: collapse;
        }

        .tally-column th, .tally-column td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tally-column th {
            background-color: #007bff;
            color: white;
        }

        .summary {
            text-align: center;
            margin-top: 20px;
            font-size: 20px;
            color: #333;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Tally of Received and Spent Amounts</h2>

    <div class="tally-table">
        <!-- Received Amounts Column -->
        <div class="tally-column">
            <h3>Amounts Received</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction ID</th>
                        <th>Description</th>
                        <th>Amount (₹)</th>
                        <th>Payment Mode</th>
                        <th>Bill No.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($received_data->num_rows > 0) {
                        while ($row = $received_data->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['date'] . "</td>
                                    <td>" . $row['transaction_id'] . "</td>
                                    <td>" . $row['description'] . "</td>
                                    <td>" . $row['amount_received'] . "</td>
                                    <td>" . $row['payment_mode'] . "</td>
                                    <td>" . $row['bill_no'] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Spent Amounts Column -->
        <div class="tally-column">
            <h3>Amounts Spent</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction ID</th>
                        <th>Description</th>
                        <th>Amount (₹)</th>
                        <th>Payment Mode</th>
                        <th>Bill No.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($spent_data->num_rows > 0) {
                        while ($row = $spent_data->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['date'] . "</td>
                                    <td>" . $row['transaction_id'] . "</td>
                                    <td>" . $row['description'] . "</td>
                                    <td>" . $row['amount_spent'] . "</td>
                                    <td>" . $row['payment_mode'] . "</td>
                                    <td>" . $row['bill_no'] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="summary">
        <p>Total Amount Received: ₹<?php echo number_format($total_received, 2); ?></p>
        <p>Total Amount Spent: ₹<?php echo number_format($total_spent, 2); ?></p>
        <p><strong>Remaining Balance: ₹<?php echo number_format($balance, 2); ?></strong></p>
    </div>

    <a href="accounts.php">Back to Home</a>
</body>
</html>
