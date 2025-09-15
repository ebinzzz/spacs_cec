<?php
// buzzer_press.php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team_name = $_POST['team_name'];
    
    // Database connection details
    $db_host = 'sql202.infinityfree.com';
    $db_username = 'if0_36740899';
    $db_password = '5HHGuSYz6PDcO';
    $db_name = 'if0_36740899_spacs';
    
    // Create connection
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Record the buzzer press time for the team
    $sql = "INSERT INTO game_log (team_name) VALUES ('$team_name')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Buzzer pressed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error recording buzzer press']);
    }
    
    $conn->close();
}
?>
