<?php
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

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_name = $_POST['team_name'];
    $college_name = $_POST['college_name'];

    // Prepare and execute SQL query to insert team details
    $sql = "INSERT INTO teams (team_name, college_name) VALUES ('$team_name', '$college_name')";
    
    if ($conn->query($sql) === TRUE) {
        // Get the last inserted team_id
        $team_id = $conn->insert_id;
        
        // Redirect to the game page with the team_id as a URL parameter
        header("Location: game.php?team_id=" . $team_id);
        exit(); // Always call exit after header to prevent further script execution
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
