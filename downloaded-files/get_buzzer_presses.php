<?php
// get_buzzer_presses.php

// Connect to the database
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the question_id from the request
$question_id = isset($_GET['question_id']) ? $_GET['question_id'] : null;

if ($question_id) {
    // Fetch buzzer press logs for the selected question
    $sql = "SELECT gl.team_id, t.team_name, gl.buzzer_time, gl.question_id
            FROM game_log gl
            JOIN teams t ON gl.team_id = t.id
            WHERE gl.question_id = ?
            ORDER BY gl.buzzer_time ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<h2>Buzzer Presses for Question ' . htmlspecialchars($question_id) . '</h2>';
        echo '<table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Team Name</th>
                        <th>Buzzer Press Time</th>
                    </tr>
                </thead>
                <tbody>';

        $rank = 1;
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $rank++ . '</td>
                    <td>' . htmlspecialchars($row['team_name']) . '</td>
                    <td>' . htmlspecialchars($row['buzzer_time']) . '</td>
                </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p>No buzzer presses yet for this question.</p>';
    }
} else {
    echo '<p>Invalid question selected.</p>';
}

$conn->close();
?>
