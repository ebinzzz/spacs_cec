<?php
// Database connection
@require 'config.php';
header('Content-Type: application/json');

if (isset($_POST['code'])) {
    $code = $_POST['code'];
    $lines = explode("\n", $code);

    if (count($lines) >= 2) {
        $event_id = intval(trim($lines[0]));
        $participant_id = intval(trim($lines[1]));

        $query = "SELECT full_name, email, t_status FROM event_registrations WHERE event_id = ? AND id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $event_id, $participant_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($name, $email, $t_status);
            $stmt->fetch();

            if ($t_status === 'verified') {
                echo json_encode([
                    'status' => 'already_verified',
                    'name' => $name,
                    'email' => $email
                ]);
            } else {
                $update = $conn->prepare("UPDATE event_registrations SET t_status = 'verified' WHERE event_id = ? AND id = ?");
                $update->bind_param("ii", $event_id, $participant_id);
                $update->execute();
                echo json_encode([
                    'status' => 'success',
                    'name' => $name,
                    'email' => $email
                ]);
            }
        } else {
            echo json_encode(['status' => 'not_found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'invalid_format']);
    }
}
?>
