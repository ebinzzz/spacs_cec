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

$sql = "SELECT id, bill_number, customer_name, date, file_path FROM bills";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
        }
        .item-table th, .item-table td {
            padding: 10px;
            text-align: left;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }
        .total-row {
            font-weight: bold;
            background-color: #e0e0e0;
        }
        .total-amount {
            text-align: right;
            padding-right: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bill List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Bill Number</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Proof</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"]. "</td>
                            <td>" . $row["bill_number"]. "</td>
                            <td>" . $row["customer_name"]. "</td>
                            <td>" . $row["date"]. "</td>
                            <td><a href='" . $row["file_path"] . "' target='_blank'>View Proof</a></td>
                        </tr>";

                    // Fetch bill items for this bill
                    $bill_id = $row['id'];
                    $sql_items = "SELECT amount, description FROM bill_items WHERE bill_id = $bill_id";
                    $result_items = $conn->query($sql_items);

                    $total_amount = 0;
                    if ($result_items->num_rows > 0) {
                        echo "<tr><td colspan='5'>
                                <table class='item-table'>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>";
                        while($item = $result_items->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $item['description'] . "</td>
                                    <td>" . $item['amount'] . "</td>
                                  </tr>";
                            $total_amount += $item['amount']; // Calculate total amount
                        }
                        echo "<tr class='total-row'>
                                <td class='total-amount'>Total Amount</td>
                                <td>" . $total_amount . "</td>
                              </tr>";
                        echo "</table></td></tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
