<?php
// upload_certificate.php

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = intval($_POST['request_id']);
    $target_dir = "certi/";
    $target_file = $target_dir . basename($_FILES["certificate_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a real image or fake image
    if (move_uploaded_file($_FILES["certificate_file"]["tmp_name"], $target_file)) {
        $db_host = 'sql202.infinityfree.com';
        $db_username = 'if0_36740899';
        $db_password = '5HHGuSYz6PDcO';
        $db_name = 'if0_36740899_spacs';

        // Create connection
        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Update admin_requests table
        $stmt = $conn->prepare("UPDATE admin_requests SET status='completed', certificate_path=? WHERE request_id=?");
        $stmt->bind_param('si', $target_file, $request_id);

        if ($stmt->execute()) {
            // Retrieve memid from request
            $stmt2 = $conn->prepare("SELECT memid FROM admin_requests WHERE request_id=?");
            $stmt2->bind_param('i', $request_id);
            $stmt2->execute();
            $stmt2->bind_result($memid);
            $stmt2->fetch();
            $stmt2->close();

            // Update users table
            $stmt3 = $conn->prepare("UPDATE users SET certi='yes', certificate_path=? WHERE id=?");
            $stmt3->bind_param('si', $target_file, $memid);
            $stmt3->execute();
            $stmt3->close();

            echo "<script>
                alert('The certificate has been uploaded and the user record updated.');
                window.location.href = 'admincerti.php';
              </script>";

            // Send email notification
            include_once("class.phpmailer.php");
            include_once("class.smtp.php");

            $sql = "SELECT email FROM users WHERE id=?";
            $stmt4 = $conn->prepare($sql);
            $stmt4->bind_param('i', $memid);
            $stmt4->execute();
            $stmt4->bind_result($email);
            $stmt4->fetch();
            $stmt4->close();

            if ($email) {
                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->Username = 'spacscectl@gmail.com';
                $mail->Password = 'bhclboafxufedyol';
                $mail->From = 'spacscectl@gmail.com';
                $mail->FromName = "SPACSCEC";
                $mail->isHTML(true);
                $mail->Subject = 'Your SPACS Membership Certificate is Now Available for Download';
   $mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: white;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            position: relative;
            height: 150px;
        }
        .header img {
            margin-top: 10%;
            max-width: 300px;
            height: 250px;
            display: block;
            margin: 0 auto 10px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #28a745;
            font-size: 20px;
        }
        .content p {
            font-size: 16px;
            color: #333333;
            line-height: 1.6;
        }
        .footer {
            margin-top: 20px;
            padding: 20px;
            background-color: #f2f2f2;
            text-align: center;
        }
        .footer p {
            margin: 0;
            color: #333333;
            font-size: 14px;
        }
        .footer a {
            color: #28a745;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://www.spacscec.free.nf/spacslogo.png" alt="SPACSCEC Logo">
        </div>
        <div class="content">
            <h2>Dear Member,</h2>
            <p>We are pleased to inform you that, as per your request, your SPACS membership certificate has been issued.</p>
            <p>Please download your certificate using the button below:</p>
            <p>
                <a href="https://www.spacscec.free.nf/'.$target_file.'" style="text-decoration:none;">
                    <button style="
                        background-color: #28a745;
                        color: white;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 16px;">
                        Download Certificate
                    </button>
                </a>
            </p>
            <p>If you have any questions or require assistance, please do not hesitate to contact us at:</p>
            <p>Email: <a href="mailto:spacscectl@gmail.com">spacscectl@gmail.com</a></p>
            <p>Phone: <a href="tel:+91 9995226831">+91 9995226831</a></p>
        </div>
        <div class="footer">
            <p>Thank you for your prompt attention to this matter.</p>
            <p>Best regards,</p>
            <p>SPACSCEC Team</p>
        </div>
    </div>
</body>
</html>';

                $mail->AddAddress($email);

                if ($mail->send()) {
                    echo "Email has been sent successfully to $email.<br>";
                } else {
                    echo "Error sending email: " . $mail->ErrorInfo;
                }

                $mail->ClearAllRecipients();
            } else {
                echo "No email found for the user.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $conn->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
