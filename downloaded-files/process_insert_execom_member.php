<?php
// Database connection parameters
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
// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return htmlspecialchars($conn->real_escape_string(trim($data)));
}

// Check if form is submitted and memid is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['memid'], $_POST['name'], $_POST['email'], $_POST['position'])) {
    // Sanitize inputs
    $memid = sanitize($_POST['memid']);
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $position = sanitize($_POST['position']);

    // Insert query to execom_member table
    $insert_sql = "INSERT INTO execom_member (memid, name, email, position) VALUES ('$memid', '$name', '$email', '$position')";

    if ($conn->query($insert_sql) === TRUE) {
       echo '<script>';
echo 'alert("New member added successfully.");';
echo 'window.location.href = "display_execom.php";';
echo '</script>';
    } else {
        echo "Error inserting member: " . $conn->error;
    }
} else {
    echo "Please fill all required fields.";
}

// Close connection
$conn->close();
?>
