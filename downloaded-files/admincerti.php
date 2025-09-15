<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Upload Certificate</title>
    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ffecd2, #fcb69f);
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Page title */
        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        /* Styling the table */
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
            background: #f57c00;
            color: #fff;
            font-size: 1.2em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Upload form within the table */
        .upload-form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .upload-form input[type="file"] {
            margin-bottom: 10px;
        }

        .upload-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .upload-form button:hover {
            background-color: #45a049;
        }

        /* Back to Admin button */
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

        /* Container styling for layout */
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
        <h1>Admin Panel - Upload Certificates</h1>
        
        <a href="admin.php" class="back-button">Back to Admin</a>
        
        <table>
            <tr>
                <th>Request ID</th>
                <th>Name</th>
                <th>Member ID</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Upload Certificate</th>
            </tr>
            <?php
            // Database connection
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

            // Fetch pending certificate requests
            $result = $conn->query("SELECT * FROM admin_requests WHERE status = 'pending'");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['request_id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['memid'] . "</td>";
                echo "<td>" . $row['request_date'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo '<td>
                        <form class="upload-form" method="POST" action="upload_certificate.php" enctype="multipart/form-data">
                            <input type="hidden" name="request_id" value="' . $row['request_id'] . '">
                            <input type="file" name="certificate_file" required>
                            <button type="submit">Upload</button>
                        </form>
                      </td>';
                echo "</tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
