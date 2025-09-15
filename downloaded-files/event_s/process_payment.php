<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get event_id from GET parameter
    $event_id = isset($_GET['event']) ? intval($_GET['event']) : 0;
    if ($event_id <= 0) {
        die("Invalid event ID.");
    }

    // Collect registration data from POST
    $full_name = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $branch = trim($_POST['branch'] ?? '');
    $spacs_member = trim($_POST['spacsMember'] ?? '');
    $membership_id = ($spacs_member === 'yes') ? trim($_POST['membershipId'] ?? '') : null;

    if (!$full_name || !$email || !$phone || !$year || !$course || !$branch || !$spacs_member || ($spacs_member === 'yes' && !$membership_id)) {
        die("Please fill all required fields.");
    }

    if (!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK) {
        die("Please upload your payment proof.");
    }

    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
    $file_tmp = $_FILES['payment_proof']['tmp_name'];
    $file_type = mime_content_type($file_tmp);
    if (!in_array($file_type, $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, or PDF allowed.");
    }

    $upload_dir = __DIR__ . '/uploads/payment_proofs/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $extension = pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION);
    $file_name = uniqid('txn_', true) . '.' . $extension;
    $target_path = $upload_dir . $file_name;

    if (!move_uploaded_file($file_tmp, $target_path)) {
        die("Failed to upload payment proof. Please try again.");
    }

    // DB connection
    @include 'config.php';


    $registration_date = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("INSERT INTO event_registrations(full_name, email, phone, event_id, year, course, branch, spacs_member, membership_id, registration_date, payment_proof) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $full_name, $email, $phone, $event_id, $year, $course, $branch, $spacs_member, $membership_id, $registration_date, $file_name);

    if ($stmt->execute()) {
        $stmt->close();

        $stmt2 = $conn->prepare("SELECT event_name FROM events WHERE id = ?");
        $stmt2->bind_param("i", $event_id);
        $stmt2->execute();
        $stmt2->bind_result($event_name);
        $stmt2->fetch();
        $stmt2->close();

        sendemail($full_name, $email, $event_name);

        header("Location: success.php?event_id=" . urlencode($event_id));
        exit;
    } else {
        $message = "❌ Database error: " . $stmt->error;
        if (file_exists($target_path)) unlink($target_path);
        $stmt->close();
    }

    $conn->close();
}

// Send email function
function sendemail($f_name, $email, $event_name) {
    require 'class.phpmailer.php';
    require 'class.smtp.php';

    $subject = "Event Registration Confirmation";
    $messageContent = "Thank you for registering for <strong>$event_name</strong>. Your registration was successful. Our team will verify the details and you will receive your ticket shortly via email.";

    $htmlMessage = '<div style="font-family: Arial, sans-serif; line-height: 1.6;">
        <h2>🎉 Registration Successful!</h2>
        <p>Hi <b>' . htmlspecialchars($f_name, ENT_QUOTES, 'UTF-8') . '</b>,</p>
        <p>' . $messageContent . '</p>
        <p>If you have any questions, feel free to reach out to us.</p>
        <br>
        <p>Regards,<br>SPACS Team</p>
    </div>';

    try {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'ebinbenny1709@gmail.com';
        $mail->Password = 'kouiproacwnesmpg';
        $mail->From = $mail->Username;
        $mail->FromName = "SPACSCEC";
        $mail->AddAddress($email);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $htmlMessage;

        $mail->send();
    } catch (Exception $e) {
        // Optionally log error
    }
}
?>
