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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mem_id = trim($_POST['mem_id']);
    $team = "student member"; // Default team

    // Validate input
    if (empty($name) || empty($email) || empty($mem_id)) {
        echo "<script>alert('All fields are required!');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');</script>";
    } else {
        // Check if email already exists
        $checkSQL = "SELECT id FROM `TABLE 22` WHERE email = ?";
        $stmt = $conn->prepare($checkSQL);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('User with this email already exists!');</script>";
        } else {
            // Insert new user
            $insertSQL = "INSERT INTO `TABLE 22` (name, email, mem_id, team) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSQL);
            $stmt->bind_param("ssss", $name, $email, $mem_id, $team);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successfully!'); window.location.href = 'http://www.spacscec.free.nf';</script>";
            } else {
                echo "<script>alert('Error adding user!');</script>";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPACS - Add New User</title>
    <style>
        /* Import Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body { 
            background-color: #f4f4f4;
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            padding: 20px;
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

        /* Form Container */
        .container {
            background: white;
            padding: 30px;
            max-width: 400px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-weight: 600;
            color: #444;
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background: #f9f9f9;
            color: #333;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #555;
            background: #fff;
        }

        /* Button */
        .submit-btn {
            background: #2C3E50;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s ease-in-out;
            width: 100%;
        }

        .submit-btn:hover {
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

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        STUDENTS PROGRAMMING ASSOCIATION OF COMPUTER SCIENCE
    </div>

    <!-- Form Container -->
    <div class="container">
        <h2 style="text-align: center; color: #2C3E50;">Volunteer Regsitration</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Enter email address" required>
            </div>

            <div class="form-group">
                <label for="mem_id">Membership ID:</label>
                <input type="text" name="mem_id" id="mem_id" placeholder="Enter membership ID" required>
            </div>

            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer">
        © 2025 SPACS | <a href="http://www.spacscec.free.nf" target="_blank">Visit Official Website</a>
    </div>

</body>
</html>
