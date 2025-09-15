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
$sql = "SELECT * FROM `TABLE 22`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    include_once("class.phpmailer.php");
    include_once("class.smtp.php");

    while ($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $email = $row["email"];
        $position_applied = $row["position"];
        $membership_status = $row["status"];
        $mem_id = $row["mem_id"];

        $status_display = ($membership_status == 'Yes') ? 'Active' : 'Inactive';

        $recipientEmail = $email;

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'ebin.cec@gmail.com';
        $mail->Password = 'cavenxjvslskisdc';
        $mail->From = 'spacscectl@gmail.com';
        $mail->FromName = "SPACSCEC";
        $mail->AddAddress($recipientEmail);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Interview Scheduled with SPACS Interview Board (EXECOM_CALL-25)';
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    font-family: "Helvetica Neue", Arial, sans-serif;
                    background-color: #f8f9fa;
                    margin: 0;
                    padding: 0;
                    color: #333;
                }
                .container {
                    width: 100%;
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 12px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .header {
                    background-color: #343a40;
                    color: #ffffff;
                    padding: 20px;
                    text-align: center;
                    font-size: 24px;
                    font-weight: bold;
                    border-radius: 12px 12px 0 0;
                }
                .logo {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .logo img {
                    max-width: 250px;
                }
                .content {
                    padding: 20px;
                    text-align: center;
                }
                .content h2 {
                    color: #007bff;
                    font-size: 22px;
                }
                .details {
                    background-color: #e9ecef;
                    padding: 15px;
                    margin: 20px 0;
                    border-left: 5px solid #007bff;
                    text-align: left;
                }
                .footer {
                    margin-top: 20px;
                    padding: 20px;
                    background-color: #343a40;
                    color: white;
                    text-align: center;
                    border-radius: 0 0 12px 12px;
                }
                .footer a {
                    color: #17a2b8;
                    text-decoration: none;
                }
                .footer a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="logo">
                    <img src="http://www.spacscec.free.nf/sl.png" alt="SPACSCEC Logo" width="250" height="100">
                </div>
                <div class="header">
                    Interview Invitation
                </div>
                <div class="content">
                    <h2>Dear ' . $name . ',</h2>
                    <p>We are pleased to inform you that your interview for the position of ' . $position_applied . ' has been scheduled.</p>
                    <div class="details">
                    <p><strong>Position:</strong> ' . $position_applied . '</p>
                        <p><strong>Date:</strong> 21/02/2025</p>
                        <p><strong>Time:</strong> 1.00 PM</p>
                        <p><strong>Location:</strong> IEDC ROOM, CS BLOCK</p>
                        <p><strong>Membership Status:</strong> ' . $status_display . '</p>
                        <p><strong>Membership ID:</strong> ' . $mem_id . '</p>
                    </div>
                    <p>Please arrive 10 minutes early .</p>
                      <p>Note: Please reply to us if you acknowledge the email.</p>
                    <p>For queries, contact us:</p>
                    <p>Email: <a href="mailto:spacscectl@gmail.com">spacscectl@gmail.com</a></p>
                    <p>Phone: <a href="tel:+91 999-522-6831">+918590594735</a></p>
                </div>
                <div class="footer">
                    <p>Best regards,</p>
                    <p>SPACS Info Team</p>
                    <p>COLLEGE OF ENGINEERING CHERTHALA</p>
                </div>
            </div>
        </body>
        </html>';



        if ($mail->send()) {
            echo '<script>alert("Interview email has been sent successfully."); window.location.href = "applicants.php";</script>';
        } else {
            echo "Email could not be sent. Error: " . $mail->ErrorInfo;
        }

        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
    }
} else {
    echo "No applicants found with scheduled interviews.";
}

$conn->close();
?>
