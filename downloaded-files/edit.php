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
$positions = [
    'Member',
    'Chairman',
    'Vice Chair',
    'Secretary',
    'Joint Secretary',
    'Membership Development Officer',
    'Asst. Membership Development Officer',
    'Event Management Officer',
    'Asst. Event Management Officer',
    'Marketing Administrator',
    'Chief Information Officer',
    'Public Relations Officer',
    'Assistant Public Relations Officer',
    'Academic Affairs Coordinator',
    'Social Media Manager',
    'Design Team Lead',
    'Design Team Co-Lead',
    'Volunteer Coordinator'
];

    // Sanitize the ID to prevent SQL injection
    $id = $conn->real_escape_string($_GET['id']);

    // Fetch execom member details based on ID
    $sql = "SELECT * FROM execom_member WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $memid = htmlspecialchars($row['memid']);
        $name = htmlspecialchars($row['name']);
        $email = htmlspecialchars($row['email']);
        $position = htmlspecialchars($row['position']);

        // Display a form to edit execom member details
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<title>Edit Execom Member</title>';
        echo '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">';
        echo '<link rel="stylesheet" href="styles.css">';
        echo '</head>';
        echo '<body>';
        echo '<div class="container">';
        echo '<h1>Edit Execom Member</h1>';
        echo '<form action="updateexecom.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $id . '">';
        echo '<label for="memid">Membership ID:</label>';
        echo '<input type="text" id="memid" name="memid" value="' . $memid . '" readonly><br><br>';
        echo '<label for="name">Name:</label>';
        echo '<input type="text" id="name" name="name" value="' . $name . '" required><br><br>';
        echo '<label for="email">Email:</label>';
        echo '<input type="email" id="email" name="email" value="' . $email . '" required><br><br>';
        echo '<label for="position">Position:</label>';
     echo '<select id="position" name="position">';
foreach ($positions as $pos) {
    echo '<option value="' . htmlspecialchars($pos) . '" ' . ($position == $pos ? 'selected' : '') . '>' . htmlspecialchars($pos) . '</option>';
}
echo '</select>';'<br><br>';
        echo '<button type="submit">Update Execom Member</button>';
        echo '</form>';
        echo '</div>';
        echo '</body>';
        echo '</html>';
    } else {
        echo "Execom member not found.";
    }

    // Close connection
    $conn->close();
} else {
    echo "ID not provided.";
}
?>
<style>
/* styles.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0; /* Light gray background */
    color: #333; /* Dark gray text color */
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 20px auto;
    background-color: #fff; /* White background for the form container */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
}

h1 {
    font-size: 28px;
    text-align: center;
    margin-bottom: 20px;
    color: #333; /* Dark gray header */
}

form {
    max-width: 400px;
    margin: 0 auto;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #666; /* Medium gray label color */
}

input[type="text"],
input[type="email"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc; /* Light gray border */
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

select {
    appearance: none; /* Remove default select styling */
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); /* Custom arrow icon */
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 24px;
}

button[type="submit"] {
    background-color: #4CAF50; /* Green submit button */
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
}

button[type="submit"]:hover {
    background-color: #45a049; /* Darker green on hover */
}

</style>