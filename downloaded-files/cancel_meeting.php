<?php
// Check if a meeting ID is passed through GET or POST method
if (isset($_GET['meeting_id'])) {
    // Database connection
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
    // Escape the meeting ID to prevent SQL injection
    $meeting_id = $conn->real_escape_string($_GET['meeting_id']);

    // Update query to cancel the meeting (assuming you have a 'meetings' table)
    $sql = "UPDATE meetings SET status = 'Cancelled' WHERE id = '$meeting_id'";

    if ($conn->query($sql) === TRUE) {
      echo '<script>';
    echo 'alert("Meeting cancelled successfully.");';
    echo 'window.location.href = "meetingdetail.php";';
    echo '</script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Meeting ID not provided.";
}
?>
