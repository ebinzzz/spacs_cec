<?php
$msg = ""; // Initialize the $msg variable

$recipientEmail = "spacscectl@gmail.com"; // Recipient (SPACS email)
$senderEmail = "ebin.cec@gmail.com"; // Sender (can be used in email body)
$name = "Ebin Benny"; // Sender's name
$subject = "Event Registration Confirmation"; // Email subject
$eventName = "Tech Spark 2025"; // Replace with dynamic event name if needed

$messageContent = "Thank you for registering for <strong>$eventName</strong>. Your registration was successful. 
Our team will verify the details and you will receive your ticket shortly via email.";

// Construct the HTML message
$message = '<div style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>🎉 Registration Successful!</h2>
    <p>Hi <b>' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</b>,</p>
    <p>' . $messageContent . '</p>
    <p>If you have any questions, feel free to reach out to us.</p>
    <br>
    <p>Regards,<br>SPACS Team</p>
</div>';

// Include PHPMailer classes
require 'class.phpmailer.php';
require 'class.smtp.php';

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
    $mail->AddAddress($recipientEmail); // To SPACS team
    $mail->Subject = $subject;
    $mail->isHTML(true);
    $mail->Body = $message;

    if ($mail->send()) {
        $msg = "✅ Registration email sent to SPACS.";
    } else {
        $msg = "❌ Email sending failed. Error: " . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    $msg = "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
