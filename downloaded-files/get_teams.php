<?php
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_competition_db';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if (isset($_GET['round_id']) && isset($_GET['question_id'])) {
    $round_id = intval($_GET['round_id']);
    $question_id = intval($_GET['question_id']);
    
    $teams = $conn->query("SELECT * FROM teams");
    $result = ["teams" => []];
    while ($team = $teams->fetch_assoc()) {
        $result["teams"][] = $team;
    }
    echo json_encode($result);
}
?>
