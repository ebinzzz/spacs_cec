<?php
// get_question.php

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

// Get the current question number from the query string
$question_number = isset($_GET['question_number']) ? (int)$_GET['question_number'] : 1;

// Fetch the question from the database
$sql = "SELECT question_text, round FROM questions WHERE round = $question_number LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $question = $result->fetch_assoc();
    echo json_encode([
        'question_number' => $question_number,
        'question_text' => $question['question_text'],
    ]);
} else {
    echo json_encode(null);
}

$conn->close();
?>
