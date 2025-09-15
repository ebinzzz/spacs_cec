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

// Include PHPMailer files
include_once("class.phpmailer.php");
include_once("class.smtp.php");

$sql = "SELECT * FROM users ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $memid = $row["memid"];
        $email = $row["email"];
        $memberName = $row["first_name"]; // Assuming there's a name field in your table

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'spacsinformation@gmail.com';
        $mail->Password = 'bzmosvtuxbufqomo';
        $mail->From = 'spacsinformation@gmail.com'; // Sender email address
        $mail->FromName = "SPACSCEC"; // Sender name
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Stay Connected with SPACSCEC!';
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
                .social-icons {
                    margin-top: 20px;
                    text-align: center;
                }
                .social-icons a {
                    margin: 0 10px;
                    text-decoration: none;
                    color: #333333;
                }
                .social-icons img {
                    width: 32px;
                    height: 32px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <img src="https://www.spacscec.free.nf/spacslogo.png" alt="SPACSCEC Logo">
                </div>
                <div class="content">
                    <h2>Dear ' . htmlspecialchars($memberName) . ',</h2>
                    <p>We are excited to share our social media links with you! Stay connected with SPACSCEC through the following platforms:</p>
                    <div class="social-icons">
                        <a href="https://chat.whatsapp.com/Imw6SAyPqWO59YuD7Txqnu" target="_blank">
                            <img src="https://img.icons8.com/color/48/whatsapp--v1.png" alt="WhatsApp Group">
                        </a>
                        <a href="https://www.instagram.com/spacscec?igsh=MTAyd3J3ZnJkdjdpMw==" target="_blank">
                            <img src="https://img.icons8.com/plasticine/100/instagram-new--v2.png" alt="Instagram">
                        </a>
                        <a href="https://www.linkedin.com/company/spacscec/" target="_blank">
                            <img src="https://img.icons8.com/color/48/linkedin.png" alt="LinkedIn">
                        </a>
                    </div>
                    <p>If you have any questions or require assistance, please do not hesitate to contact us at:</p>
                    <p>Email: <a href="mailto:spacscectl@gmail.com">spacscectl@gmail.com</a></p>
                    <p>Phone: <a href="tel:+91 9995226831">+91 9995226831</a></p>
                </div>
                <div class="footer">
                    <p>Thank you for staying connected!</p>
                    <p>Best regards,</p>
                    <p>SPACSCEC Team</p>
                </div>
            </div>
        </body>
        </html>
        ';

        $mail->AddAddress($email);

        if ($mail->send()) {
            echo "Email has been sent successfully to $email.<br>";
        } else {
            echo "Failed to send email to $email.<br>";
        }

        $mail->ClearAllRecipients(); // Clear recipients for the next iteration
    }
} else {
    echo "No users found with status 'active' and send 'no'.";
}

$conn->close();
?>
