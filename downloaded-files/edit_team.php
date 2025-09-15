<?php
// Database connection
$conn = new mysqli('sql202.infinityfree.com', 'if0_36740899', '5HHGuSYz6PDcO', 'if0_36740899_competition_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $team_id = $_GET['id'];

    // Fetch team data
    $team_result = $conn->query("SELECT * FROM teams WHERE id = $team_id");
    $team = $team_result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $team_name = $_POST['team_name'];
        $team_college = $_POST['team_college'];

        // Update team in database
        $stmt = $conn->prepare("UPDATE teams SET team_name = ?, college = ? WHERE id = ?");
        $stmt->bind_param("ssi", $team_name, $team_college, $team_id);
        if ($stmt->execute()) {
            header("Location: update_dash.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Team</title>
</head>
<body>
    <h2>Edit Team</h2>
    <form method="POST" action="">
        <label for="team_name">Team Name:</label>
        <input type="text" name="team_name" id="team_name" value="<?php echo $team['team_name']; ?>" required>
        <label for="team_college">College Name:</label>
        <input type="text" name="team_college" id="team_college" value="<?php echo $team['college']; ?>" required>
        <button type="submit">Update Team</button>
    </form>
</body>
</html>
