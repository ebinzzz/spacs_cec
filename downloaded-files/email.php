<?php
$msg = ""; // Initialize the $msg variable

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['mssg'])) {
    $recipientEmail = "spacscectl@gmail.com"; // Set the recipient email address
    $senderEmail = $_POST['email']; // Define $senderEmail
    $name = $_POST['name']; // Define $name (assuming this is the name field)
    $subject = $_POST['subject']; // Define $subject
    $messageContent = $_POST['mssg']; // Define $messageContent

    // Construct the HTML message
    $message = '<div>
        <p>From: ' . htmlspecialchars($senderEmail, ENT_QUOTES, 'UTF-8') . '</p>
        <p><b>Hello!</b></p>
        <p>' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</p>
        <p>' . htmlspecialchars($messageContent, ENT_QUOTES, 'UTF-8') . '</p>
        <br>
    </div>';

    // Include PHPMailer classes
    require 'class.phpmailer.php';
    require 'class.smtp.php';

    try {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // Server settings
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'ebinbenny1709@gmail.com';
        $mail->Password = 'kouiproacwnesmpg';
        $mail->FromName = "SPACSCEC"; // Sender's name
        $mail->AddAddress($recipientEmail);
        $mail->Subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'); // Sanitize subject
        $mail->isHTML(true);
        $mail->Body = $message;

        // Attempt to send email
        if ($mail->send()) {
            $msg = "We will contact you soon";
        } else {
            $msg = "Email sending failed. Error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
