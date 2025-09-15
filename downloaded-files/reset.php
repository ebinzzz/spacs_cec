<?php
// Database connection
$conn = new mysqli('sql202.infinityfree.com', 'if0_36740899', '5HHGuSYz6PDcO', 'if0_36740899_competition_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// List of tables to delete data from
$tables = ['team_scores', 'teams', 'questions', 'rounds', 'team_answers']; // Add more tables as needed

// Loop through each table and delete all rows
foreach ($tables as $table) {
    // DELETE query to remove all data from the table
    $sql = "DELETE FROM $table";
    if ($conn->query($sql) === TRUE) {
        echo "All data deleted successfully from $table.<br>";
    } else {
        echo "Error deleting data from $table: " . $conn->error . "<br>";
    }
}

// Close connection
$conn->close();
?>
