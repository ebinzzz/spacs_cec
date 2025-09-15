<?php
// Database connection
$conn = new mysqli('sql202.infinityfree.com', 'if0_36740899', '5HHGuSYz6PDcO', 'if0_36740899_competition_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $team_id = $_GET['id'];

    // Delete team from database
    $stmt = $conn->prepare("DELETE FROM teams WHERE id = ?");
    $stmt->bind_param("i", $team_id);
    if ($stmt->execute()) {
        header("Location: update_dash.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
