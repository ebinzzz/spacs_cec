<?php
// log_buzzer.php

// Database connection details
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

// Get POST data
$team_id = $_POST['team_id'];
$question_id = $_POST['question_id'];
$buzzer_time = date('Y-m-d H:i:s'); // Current time when buzzer is pressed

// Insert buzzer press log into the database
$sql = "INSERT INTO game_log (team_id, question_id, buzzer_time) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $team_id, $question_id, $buzzer_time);

if ($stmt->execute()) {
    echo "Buzzer pressed successfully!";
} else {
    echo "Error logging buzzer press.";
}

$stmt->close();
$conn->close();
?>
