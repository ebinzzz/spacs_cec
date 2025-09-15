<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['meeting_id']) && isset($_POST['attendance'])) {
    // Database connection parameters
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

    // Sanitize inputs to prevent SQL injection
    $meeting_id = $conn->real_escape_string($_POST['meeting_id']);
    $attendance = $_POST['attendance']; // Array of execom_member IDs

    // Check if attendance already exists for the meeting
    $sql_check = "SELECT * FROM attendance WHERE meeting_id = '$meeting_id'";
    $result_check = $conn->query($sql_check);

    // Use an array to store existing execom_member_ids for the meeting
    $existing_execom_members = [];
    if ($result_check->num_rows > 0) {
        while ($row = $result_check->fetch_assoc()) {
            $existing_execom_members[] = $row['execom_member_id'];
        }
    }

    // Insert new attendance records into the database
    foreach ($attendance as $execom_member_id) {
        // Check if the execom_member_id already exists for the meeting
        if (!in_array($execom_member_id, $existing_execom_members)) {
            $execom_member_id = $conn->real_escape_string($execom_member_id);
            $sql_insert = "INSERT INTO attendance (meeting_id, execom_member_id) VALUES ('$meeting_id', '$execom_member_id')";
            if ($conn->query($sql_insert) !== TRUE) {
                echo "Error: " . $sql_insert . "<br>" . $conn->error;
            }
        }
    }

    // Close connection
    $conn->close();

    // Redirect back to mark attendance page or any other page as needed
    header("Location: mark_attend.php?meeting_id=" . $meeting_id);
    exit();
} else {
    echo "Form submission error.";
}
?>
