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
    $date_spent = $_POST['date_spent'];
    $transaction_id_spent = $_POST['transaction_id_spent'];
    $description_spent = $_POST['description_spent'];
    $amount_spent = $_POST['amount_spent'];
    $payment_mode_spent = $_POST['payment_mode_spent'];
    $event_name_spent = $_POST['event_name_spent'];
    $bill_no_spent = $_POST['bill_no_spent'];
    $remarks_spent = $_POST['remarks_spent'];

    // Handle file upload
    $target_dir = "uploads/";
    $proof_upload_spent = $target_dir . basename($_FILES["proof_upload_spent"]["name"]);
    move_uploaded_file($_FILES["proof_upload_spent"]["tmp_name"], $proof_upload_spent);

    $sql = "INSERT INTO amount_spent (date, transaction_id, description, amount_spent, payment_mode, event_name, proof_upload, bill_no, remarks)
            VALUES ('$date_spent', '$transaction_id_spent', '$description_spent', '$amount_spent', '$payment_mode_spent', '$event_name_spent', '$proof_upload_spent', '$bill_no_spent', '$remarks_spent')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('data entred successfully');
        window.location.href='display_spend.php';
        </script>"
        ;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
