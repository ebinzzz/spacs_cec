<?php


$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

// Start session
session_start();

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId']; // Ensure userId is passed in the form
    $paymentId = $_POST['paymentId'];
    $paymentDate = $_POST['paymentDate'];
    $bankName = $_POST['bankName'];
    $recipientName = $_POST['recipientName'];
    $phoneNumber = $_POST['phoneNumber'];
    $paymentProof = $_FILES['paymentProof']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["paymentProof"]["name"]);

    if (move_uploaded_file($_FILES["paymentProof"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("UPDATE users SET paymentId = ?, paymentDate = ?, bankName = ?, recipientName = ?, phoneNumber = ?, paymentProof = ?, paymentstatus = 'yes' WHERE id = ?");
        $stmt->bind_param("ssssssi", $paymentId, $paymentDate, $bankName, $recipientName, $phoneNumber, $paymentProof, $userId);
        
        if ($stmt->execute()) {
            echo "<script> window.location.href='success.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
