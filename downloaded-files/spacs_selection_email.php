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
$sql = "SELECT * FROM `TABLE 22` WHERE team != 'student member'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    include_once("class.phpmailer.php");
    include_once("class.smtp.php");

    while ($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $email = $row["email"];
        $team = $row["team"]; // Team they got selected in
        $mem_id = $row["mem_id"];

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
        $mail->Subject = 'Congratulations! Welcome to SPACS Family';

        $mail->Body = '
      <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SPACS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 150px; /* Adjust size as needed */
        }
        .header {
            background-color: #0056b3;
            color: white;
            padding: 20px;
            font-size: 22px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            text-align: left;
        }
        .highlight {
            font-size: 18px;
            font-weight: bold;
            color: #0056b3;
        }
        .details {
            background: #eef2f7;
            padding: 15px;
            border-left: 5px solid #0056b3;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            margin-top: 30px;
            padding: 20px;
            background: #333;
            color: white;
            text-align: center;
            border-radius: 0 0 8px 8px;
        }
        .btn {
            display: inline-block;
            background: #0056b3;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #003d80;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="https://spacscec.free.nf/spacslogo.png" alt="SPACS Logo">
        </div>
        <div class="header">🎉 Congratulations, Welcome to SPACS! 🎉</div>
        <div class="content">
            <p>Dear <strong>' . $name . '</strong>,</p>
            <p>We are delighted to inform you that you have been <span class="highlight">selected</span> to join our prestigious organization, <strong>SPACS</strong>. Your passion and dedication have set you apart, and we are excited to have you on board!</p>
            <div class="details">
                <p><strong>Team Assigned:</strong> ' . $team . '</p>
                <p><strong>Membership ID:</strong> ' . $mem_id . '</p>
                <p><strong>Start Date:</strong> 1st March 2025</p>
            </div>
            <p>As a member of SPACS, you will be part of a dynamic and forward-thinking community, working on innovative projects and expanding your skills.</p>
            <p>We look forward to meeting you at our upcoming onboarding session. Stay tuned for more details!</p>
           
        </div>
        <div class="footer">
            <p>Best Regards,</p>
            <p><strong>SPACS Info Team</strong></p>
            <p>COLLEGE OF ENGINEERING CHERTHALA</p>
            <p><a href="mailto:spacscectl@gmail.com" style="color: #17a2b8; text-decoration: none;">spacscectl@gmail.com</a> | <a href="tel:+918590594735" style="color: #17a2b8; text-decoration: none;">+918590594735</a></p>
        </div>
    </div>
</body>
</html>
';

        if ($mail->send()) {
            echo '<script>alert("Selection email has been sent successfully."); window.location.href = "applicants.php";</script>';
        } else {
            echo "Email could not be sent. Error: " . $mail->ErrorInfo;
        }

        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
    }
} else {
    echo "No applicants found.";
}

$conn->close();
?>
