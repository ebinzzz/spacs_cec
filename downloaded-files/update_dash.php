<?php
// Database connection
$conn = new mysqli('sql202.infinityfree.com', 'if0_36740899', '5HHGuSYz6PDcO', 'if0_36740899_competition_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            color: #333;
            text-align: center;
        }
        h1 {
            color: #444;
            margin-bottom: 30px;
            font-size: 28px;
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin: 20px 0 10px;
        }
        h3 {
            color: #666;
            font-size: 20px;
            margin: 10px 0;
        }
        p {
            color: #666;
            margin: 5px 0 15px;
        }

        /* Form Styles */
        .form-container {
            display: inline-block;
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        input[type="text"], select, button {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"]:focus, select:focus {
            outline: none;
            border-color: #4d90fe;
            box-shadow: 0 0 5px rgba(77, 144, 254, 0.4);
        }
        button {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }

        /* Table Styles */
        table {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4d90fe;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1faff;
        }

        /* Link and Action Styles */
        a {
            color: #4d90fe;
            text-decoration: none;
            font-weight: bold;
            margin: 0 5px;
        }
        a:hover {
            text-decoration: underline;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        /* Button for Navigation */
        .nav-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }
        .nav-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Section for Rounds Management -->


    <h3>Existing Rounds</h3>
    <?php
    $rounds = $conn->query("SELECT * FROM rounds");
    if ($rounds->num_rows > 0) {
        echo "<table><tr><th>Round Name</th><th>Action</th></tr>";
        while ($round = $rounds->fetch_assoc()) {
            echo "<tr>
                    <td>{$round['name']}</td>
                    <td class='actions'>
                        <a href='edit_round.php?id={$round['id']}'>Edit</a> | 
                        <a href='delete_round.php?id={$round['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No rounds available.</p>";
    }
    ?>

    <!-- Section for Teams Management -->
   

    <h3>Existing Teams</h3>
    <?php
    $teams = $conn->query("SELECT * FROM teams");
    if ($teams->num_rows > 0) {
        echo "<table><tr><th>Team Name</th><th>College</th><th>Action</th></tr>";
        while ($team = $teams->fetch_assoc()) {
            echo "<tr>
                    <td>{$team['team_name']}</td>
                    <td>{$team['college']}</td>
                    <td class='actions'>
                        <a href='edit_team.php?id={$team['id']}'>Edit</a> | 
                        <a href='delete_team.php?id={$team['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No teams available.</p>";
    }
    ?>

    <!-- Section for Questions Management -->


    <h3>Existing Questions</h3>
    <?php
    $questions = $conn->query("SELECT * FROM questions");
    if ($questions->num_rows > 0) {
        echo "<table><tr><th>Question Text</th><th>Round</th><th>Action</th></tr>";
        while ($question = $questions->fetch_assoc()) {
            $round_name = $conn->query("SELECT name FROM rounds WHERE id = {$question['round_id']}")->fetch_assoc()['name'];
            echo "<tr>
                    <td>{$question['question_text']}</td>
                    <td>{$round_name}</td>
                    <td class='actions'>
                        <a href='edit_question.php?id={$question['id']}'>Edit</a> | 
                        <a href='delete_question.php?id={$question['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No questions available.</p>";
    }
    ?>

    <!-- Section for Score Management -->
    <h2>Manage Scores</h2>
    <p>Update or delete scores for each team's answers in specific rounds and questions.</p>
    <a href="update_scores.php">Update Scores</a> | 
    <a href="delete_scores.php">Delete Scores</a>

    <button class="nav-button" onclick="location.href='admin_dash.php'">Back to Home</button>
</body>
</html>
