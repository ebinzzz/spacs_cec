<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Execom Member</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            color: #555;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: left;
            width: 100%;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Insert Execom Member Details</h2>
        <?php
        // Database connection parameters
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

        // Function to sanitize input data
        function sanitize($data) {
            global $conn;
            return htmlspecialchars($conn->real_escape_string(trim($data)));
        }

        // Check if memid is submitted via POST
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['memid'])) {
            // Sanitize memid from form input
            $memid = sanitize($_POST['memid']);

            // Query to fetch user details from users table based on memid
            $sql = "SELECT * FROM users WHERE memid = '$memid'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Fetch user details
                $row = $result->fetch_assoc();
                $name1 = htmlspecialchars($row['first_name']);
                  $name2 = htmlspecialchars($row['last_name']);
                $email = htmlspecialchars($row['email']);

                // Display fetched details in a form for inserting into execom_member
                echo '<form action="process_insert_execom_member.php" method="post">';
                echo '<input type="hidden" name="memid" value="' . $memid . '">';
                echo '<label for="name">Name:</label>';
                echo '<input type="text" id="name" name="name" value="' . $name1 .' '. $name2 . '" readonly>';
                echo '<label for="email">Email:</label>';
                echo '<input type="email" id="email" name="email" value="' . $email . '" readonly>';
                echo '<label for="position">Position:</label>';
echo '<select id="position" name="position">';
echo '<option value="Member">Member</option>'; // Default option

// Additional options from the new list
echo '<option value="Program Officer">Program Officer</option>';
echo '<option value="Chairman">Chairman</option>';
echo '<option value="Vice Chair">Vice Chair</option>';
echo '<option value="Secretary">Secretary</option>';
echo '<option value="Joint Secretary">Joint Secretary</option>';
echo '<option value="Membership Development Officer">Membership Development Officer</option>';
echo '<option value="Asst. Membership Development Officer">Asst. Membership Development Officer</option>';
echo '<option value="Event Management Officer">Event Management Officer</option>';
echo '<option value="Asst. Event Management Officer">Asst. Event Management Officer</option>';
echo '<option value="Marketing Administrator">Marketing Administrator</option>';
echo '<option value="Chief Information Officer">Chief Information Officer</option>';
echo '<option value="Public Relations Officer">Public Relations Officer</option>';
echo '<option value="Assistant Public Relations Officer">Assistant Public Relations Officer</option>';
echo '<option value="Academic Affairs Coordinator">Academic Affairs Coordinator</option>';
echo '<option value="Social Media Manager">Social Media Manager</option>';
echo '<option value="Design Team Lead">Design Team Lead</option>';
echo '<option value="Design Team Co-Lead">Design Team Co-Lead</option>';
echo '<option value="Volunteer Coordinator">Volunteer Coordinator</option>';

echo '</select>';


                echo '<button type="submit">Insert Execom Member</button>';
                echo '</form>';
            } else {
                echo "No user found with Membership ID: " . $memid;
            }
        } else {
            echo "Please provide a Membership ID.";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
