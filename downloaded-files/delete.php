<?php
// Check if ID is provided in the URL
if (isset($_GET['id'])) {
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

    // Sanitize the ID to prevent SQL injection
    $id = $conn->real_escape_string($_GET['id']);

    // Delete query
    $sql = "DELETE FROM execom_member WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to display page after successful delete
        header("Location: display_execom.php");
        exit();
    } else {
        echo "Error deleting execom member: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "ID not provided.";
}
?>
