<?php
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_competition_db';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_POST) {
    $round_no = $_POST['round_no'];
    $round_name = $_POST['round_name'];
    $conn->query("INSERT INTO rounds (round_no, name) VALUES ('$round_no', '$round_name')");
    echo "<p class='success-message'>Round Added Successfully!</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Round</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and Main Container */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f7fa;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #555;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        label {
            font-size: 1rem;
            color: #444;
            text-align: left;
        }

        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        input[type="number"]:focus,
        input[type="text"]:focus {
            border-color: #007bff;
        }

        /* Success Message */
        .success-message {
            color: #28a745;
            margin-top: 20px;
            font-size: 1.1rem;
        }

        /* Button Styling */
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Back to Dashboard Button */
        .back-button {
            background-color: #6c757d;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Round</h1>
        <form method="post">
            <label for="round_no">Round No:</label>
            <input type="number" id="round_no" name="round_no" required>
            
            <label for="round_name">Round Name:</label>
            <input type="text" id="round_name" name="round_name" required>
            
            <button type="submit">Add Round</button>
        </form>
        <button class="back-button" onclick="location.href='admin_dash.php'">Back to Dashboard</button>
    </div>
</body>
</html>
