<?php
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_competition_db';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if (isset($_GET['round_id'])) {
    $round_id = intval($_GET['round_id']);
    $result = $conn->query("SELECT id, question_no, question_text FROM questions WHERE round_id = $round_id");

    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    echo json_encode($questions);
}
?>
