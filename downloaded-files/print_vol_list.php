<?php
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

// Fetch all users
$sql = "SELECT id, name, email, mem_id, team FROM `TABLE 22` ORDER BY name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPACS - Users List</title>
    <style>
        /* Import Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body { 
            background-color: #f4f4f4; 
            padding: 20px; 
            display: flex; 
            flex-direction: column; 
            align-items: center;
        }

        /* Header */
        .header {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        /* Table Container */
        .container {
            background: white;
            padding: 20px;
            max-width: 900px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2C3E50;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Print Button */
        .print-btn {
            background: #2C3E50;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 10px;
            transition: 0.3s;
        }

        .print-btn:hover {
            background: #1A252F;
        }

        /* Footer */
        .footer {
            color: #666;
            text-align: center;
            font-size: 14px;
            margin-top: 20px;
            letter-spacing: 0.5px;
        }

        .footer a {
            color: #2C3E50;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Print Styles */
        @media print {
            body {
                background: none;
                padding: 0;
            }

            .container {
                box-shadow: none;
                max-width: 100%;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        STUDENTS PROGRAMMING ASSOCIATION OF COMPUTER SCIENCE
    </div>

    <!-- User List Table -->
    <div class="container">
        <h2 style="text-align: center; color: #2C3E50;">User List</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                   
                    <th>Name</th>
                    <th>Email</th>
                    <th>Membership ID</th>
                    <th>Team</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                  
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['mem_id']) ?></td>
                        <td><?= htmlspecialchars($row['team']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p style="text-align: center;">No users found.</p>
        <?php endif; ?>
        
        <!-- Print Button -->
        <button class="print-btn" onclick="window.print()">Print List</button>
    </div>

    <!-- Footer -->
    <div class="footer">
        © 2025 SPACS | <a href="http://www.spacscec.free.nf" target="_blank">Visit Official Website</a>
    </div>

</body>
</html>

<?php $conn->close(); ?>
