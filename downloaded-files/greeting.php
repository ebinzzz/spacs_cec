<?php
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

// Create a connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details with paymentstatus = 'yes' and status = 'active'
$sql = "SELECT first_name, last_name, email FROM users WHERE paymentstatus = 'yes' AND status = 'active' AND id >= 290 AND id <= 291";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    include_once("class.phpmailer.php");
    include_once("class.smtp.php");

    while ($row = $result->fetch_assoc()) {
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $email = $row["email"];

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'ebinbenny1709@gmail.com';
        $mail->Password = 'sdqyxbqokaboqtbi';
        $mail->From = 'spacscectl@gmail.com';
        $mail->FromName = "SPACSCEC";
        $mail->AddAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = '🌸 Happy Easter 2025!';
        $mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #fff9f5;
            margin: 0;
            padding: 0;
            color: #4a4a4a;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border: 1px solid #f0e0d6;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #f9dede;
            color: #7b2d26;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
        }
        .body {
            padding: 25px;
            text-align: center;
        }
        .body p {
            margin: 12px 0;
            font-size: 16px;
        }
        .body strong {
            color: #b85c38;
        }
        .footer {
            background-color: #fff3ec;
            color: #666;
            padding: 12px;
            text-align: center;
            font-size: 13px;
        }
        .footer a {
            color: #b85c38;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🌼 Happy Easter 2025! 🌼</h1>
        </div>
        <div class="body">
            <p>Dear ' . $first_name . ' ' . $last_name . ',</p>
            <p>May your Easter be filled with hope, peace, and joyful blessings. 🐣✨</p>
            <p>Wishing you and your family a wonderful spring and a heart full of happiness!</p>
            <p>With warm regards,</p>
            <p><strong>SPACS CEC Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; 2025 SPACS CEC. All rights reserved.</p>
            <p><a href="https://spacscec.free.nf">Visit our website</a> | <a href="mailto:spacscectl@gmail.com">Contact Support</a></p>
        </div>
    </div>
</body>
</html>
';
        if ($mail->send()) {
            echo "✅ Email sent to: $email<br>";
        } else {
            echo "❌ Failed to send email to: $email. Error: " . $mail->ErrorInfo . "<br>";
        }

        $mail->ClearAllRecipients();
    }
} else {
    echo "No users found with paymentstatus = 'yes' and status = 'active'.";
}

$conn->close();
?>
