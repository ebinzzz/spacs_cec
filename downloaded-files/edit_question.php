<?php
// Database connection
$conn = new mysqli('sql202.infinityfree.com', 'if0_36740899', '5HHGuSYz6PDcO', 'if0_36740899_competition_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the question ID is passed and fetch the question data
if (isset($_GET['id'])) {
    $question_id = intval($_GET['id']);
    // Fetch the question data
    $query = "SELECT * FROM questions WHERE id = $question_id";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $question = $result->fetch_assoc();
    } else {
        echo "Question not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Fetch available rounds for the dropdown
$rounds_result = $conn->query("SELECT * FROM rounds");

// Handle form submission to update the question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_text'], $_POST['round_id'])) {
    $question_text = $_POST['question_text'];
    $round_id = intval($_POST['round_id']);

    // Prepare and execute the update query
    $update_query = "UPDATE questions SET question_text = ?, round_id = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sii", $question_text, $round_id, $question_id);
    
    if ($stmt->execute()) {
        echo "Question updated successfully!";
        header("Location: update_dash.php"); // Redirect to admin dashboard
        exit();
    } else {
        echo "Error updating question: " . $stmt->error;
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        input, select, button {
            padding: 10px;
            margin: 10px;
            width: 250px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit Question</h1>
    <form method="POST" action="edit_question.php?id=<?php echo $question_id; ?>">
        <label for="question_text">Question Text:</label>
        <input type="text" name="question_text" id="question_text" value="<?php echo htmlspecialchars($question['question_text']); ?>" required>
        
        <label for="round_id">Select Round:</label>
        <select name="round_id" id="round_id" required>
            <?php
            // Display round options in the dropdown
            while ($round = $rounds_result->fetch_assoc()) {
                $selected = ($round['id'] == $question['round_id']) ? 'selected' : '';
                echo "<option value='{$round['id']}' {$selected}>{$round['name']}</option>";
            }
            ?>
        </select>
        
        <button type="submit">Update Question</button>
    </form>
</body>
</html>
