<?php
// Database connection
$conn = new mysqli('sql202.infinityfree.com', 'if0_36740899', '5HHGuSYz6PDcO', 'if0_36740899_competition_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $round_id = $_GET['id'];

    // Fetch round data
    $round_result = $conn->query("SELECT * FROM rounds WHERE id = $round_id");
    $round = $round_result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $round_name = $_POST['round_name'];

        // Update round in database
        $stmt = $conn->prepare("UPDATE rounds SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $round_name, $round_id);
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
    <title>Edit Round</title>
</head>
<body>
    <h2>Edit Round</h2>
    <form method="POST" action="">
        <label for="round_name">Round Name:</label>
        <input type="text" name="round_name" id="round_name" value="<?php echo $round['name']; ?>" required>
        <button type="submit">Update Round</button>
    </form>
</body>
</html>
