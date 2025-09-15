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

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE paymentstatus = 'no'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    include_once("class.phpmailer.php");
    include_once("class.smtp.php");

    while ($row = $result->fetch_assoc()) {
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $email = $row["email"];

        $recipientEmail = $email; // Recipient email from database

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'ebin.cec@gmail.com';
        $mail->Password = 'cavenxjvslskisdc';
        $mail->From = 'spacscectl@gmail.com'; // Sender email address
        $mail->FromName = "SPACSCEC"; // Sender name
        $mail->AddAddress($recipientEmail); // Add recipient email

    // Email content
      $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Complete Your Membership Payment';
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
                background-color: ofwhite;
                color: #ffffff;
                padding: 20px;
                text-align: center;
                position: relative;
                 height: 250px;
            }
            .header img {
            margin-top:10%;
                max-width: 300px;
                height: 250px;
                display: block;
                margin: 0 auto 10px;
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
                margin-bottom:20px;
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
            .instructions {
                background-color: #f2f2f2;
                padding: 15px;
                margin: 20px 0;
                border-left: 5px solid #28a745;
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
                <h2>Dear ' . $first_name . ' ' . $last_name . ',</h2>
                <p>Thank you for your interest in becoming a member of SPACSCEC.</p>
                <p>To complete your membership, please finalize your payment and upload the payment details.</p>
                <div class="instructions">
                    <h3>Payment Instructions:</h3>
                    <p>Please follow the steps below to complete your payment:</p>
                    <ol>
                        <li>Make your payment through your preferred bank or payment method.</li>
                        <li>Ensure you keep a copy of the payment proof (such as a screenshot or receipt).</li>
                        <li>Upload the payment details, including the payment proof, on our <a href="https://www.spacscec.free.nf/login.html">Payment Upload Page</a>.</li>
                    </ol>
                </div>
                <p>If you have any questions or require assistance, please do not hesitate to contact us at:</p>
                <p>Email: <a href="mailto:spacscectl@gmail.com">spacscectl@gmail.com</a></p>
                <p>Phone: <a href="tel:+91 999-522-6831">+919995226831</a></p>
            </div>
            <div class="footer">
                <p>Thank you for your prompt attention to this matter.</p>
                <p>Best regards,</p>
                <p>SPACSCEC Team</p>
            </div>
        </div>
    </body>
    </html>
';

   if ($mail->send()) {
            echo '<script>';
            echo 'alert("Email has been sent successfully.");';
            echo 'window.location.href = "inactive.php";';
            echo '</script>';
        } else {
            echo "Email could not be sent. Error: " . $mail->ErrorInfo;
        }

        // Clear all addresses and attachments for the next iteration
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
    }
} else {
    echo "No users found with payment status 'no'.";
}

$conn->close();
?>