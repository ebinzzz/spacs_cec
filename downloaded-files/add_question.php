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
    $round_id = $_POST['round_id'];
    $question_no = $_POST['question_no'];
    $question_text = $_POST['question_text'];
    $conn->query("INSERT INTO questions (round_id, question_no, question_text) VALUES ('$round_id', '$question_no', '$question_text')");
    echo "<p class='success-message'>Question Added Successfully!</p>";
}
$result = $conn->query("SELECT * FROM rounds");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and Container */
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
            color: #555;
            margin-bottom: 20px;
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

        select, input[type="number"], input[type="text"] {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        select:focus,
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

        /* Back Button */
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
        <h1>Add Question</h1>
        <form method="post">
            <label for="round_id">Select Round:</label>
            <select name="round_id" id="round_id" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php } ?>
            </select>

            <label for="question_no">Question No:</label>
            <input type="number" id="question_no" name="question_no" required>

            <label for="question_text">Question Text:</label>
            <input type="text" id="question_text" name="question_text">

            <button type="submit">Add Question</button>
        </form>
        <button class="back-button" onclick="location.href='admin_dash.php'">Back to Dashboard</button>
    </div>
</body>
</html>
