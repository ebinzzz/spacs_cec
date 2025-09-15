<?php
// Database connection
   $db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

// Start session


// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date_received = $_POST['date_received'];
    $transaction_id_received = $_POST['transaction_id_received'];
    $description_received = $_POST['description_received'];
    $amount_received = $_POST['amount_received'];
    $payment_mode_received = $_POST['payment_mode_received'];
    $event_name = $_POST['event_name'];
    $bill_no_received = $_POST['bill_no_received'];
    $remarks_received = $_POST['remarks_received'];

    // Handle file upload
    $target_dir = "uploads/";
    $proof_upload = $target_dir . basename($_FILES["proof_upload"]["name"]);
    move_uploaded_file($_FILES["proof_upload"]["tmp_name"], $proof_upload);

    $sql = "INSERT INTO amount_received (date, transaction_id, description, amount_received, payment_mode, event_name, proof_upload, bill_no, remarks)
            VALUES ('$date_received', '$transaction_id_received', '$description_received', '$amount_received', '$payment_mode_received', '$event_name', '$proof_upload', '$bill_no_received', '$remarks_received')";

    if ($conn->query($sql) === TRUE) {
       echo "<script>
    alert('Data entry success');
    window.location.href = 'display_receive.php';
</script>";

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
