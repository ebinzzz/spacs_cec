<?php
// DB Connection
@include 'config.php';


$event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if ($event_id <= 0 || empty($email)) {
    echo json_encode(['exists' => false]);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM event_registrations WHERE event_id = ? AND email = ?");
$stmt->bind_param("is", $event_id, $email);
$stmt->execute();
$stmt->store_result();

$response = ['exists' => $stmt->num_rows > 0];
echo json_encode($response);
$stmt->close();
$conn->close();
