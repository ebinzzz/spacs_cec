<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
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

    // Sanitize inputs to prevent SQL injection
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $position = $conn->real_escape_string($_POST['position']);

    // Update query
    $sql = "UPDATE execom_member SET name = '$name', email = '$email', position = '$position' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to display page after successful update
        header("Location: display_execom.php");
        exit();
    } else {
        echo "Error updating execom member: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Form submission error.";
}
?>
