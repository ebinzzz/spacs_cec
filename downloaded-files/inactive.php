<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Inactive Users</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #e3ffe7, #d9e7ff);
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background: #1e88e5;
            color: #fff;
            font-size: 1.2em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .send-email-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .send-email-form button {
            background-color: #e53935;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .send-email-form button:hover {
            background-color: #d32f2f;
        }

        .back-button {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #1976D2;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel - Inactive Users</h1>
        
        <a href="user1.php" class="back-button">Back to Admin</a>
        
        <form class="send-email-form" method="POST" action="send_email.php">
            <table>
                <tr>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Registration Date</th>
                </tr>
                <?php
                // Database connection details
                $db_host = 'sql202.infinityfree.com';
                $db_username = 'if0_36740899';
                $db_password = '5HHGuSYz6PDcO';
                $db_name = 'if0_36740899_spacs';

                // Create a connection
                $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch users with inactive status
                $result = $conn->query("SELECT memid, first_name, last_name, status, registration_date FROM users WHERE paymentstatus = 'no'");
                while ($row = $result->fetch_assoc()) {
                    $full_name = $row['first_name'] . ' ' . $row['last_name'];
                    echo "<tr>";
                    echo "<td>" . $row['memid'] . "</td>";
                    echo "<td>" . $full_name . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['registration_date'] . "</td>";
                    echo "</tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </table>

            <button type="submit">Send Email to All Inactive Users</button>
        </form>
    </div>
</body>
</html>
