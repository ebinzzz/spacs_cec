<?php
if (isset($_POST['schedule_meeting'])) {
    $space_id = $_POST['space_id'];
    $meeting_title = $_POST['meeting_title'];
    $meeting_date = $_POST['meeting_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];

    // Database connection parameters
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

    // Fetch all execom members
    $sql1 = "SELECT name, email FROM execom_member";
    $result1 = $conn->query($sql1);
    $attendees = [];

    if ($result1->num_rows > 0) {
        while ($row1 = $result1->fetch_assoc()) {
            $attendees[] = ['name' => $row1['name'], 'email' => $row1['email']];
           $r= $row1['name'];
        }
    }

    // Schedule the meeting
    $sql = "INSERT INTO meetings (space_id, meeting_title, meeting_date, start_time, end_time, description, venue)
            VALUES ('$space_id', '$meeting_title', '$meeting_date', '$start_time', '$end_time', '$description', '$venue')";

    if ($conn->query($sql) === TRUE) {
        echo "New meeting scheduled successfully";

        // Send email notifications to all attendees
        include_once("class.phpmailer.php");
        include_once("class.smtp.php");

        foreach ($attendees as $attendee) {
            $recipientEmail = $attendee['email'];
            $recipientName = $attendee['name'];

            try {
                //Server settings
                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->Username = 'ebinbenny1709@gmail.com';
                $mail->Password = 'kouiproacwnesmpg';
                $mail->FromName = "SPACSCEC";
                $mail->AddAddress($recipientEmail);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Meeting Scheduled';

                // HTML content
                $mailContent = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: #f4f4f4;
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
                            background-color: #007bff;
                            color: #ffffff;
                            padding: 20px;
                            text-align: center;
                        }
                        .header h1 {
                            margin: 0;
                        }
                        .content {
                            padding: 20px;
                        }
                        .content h2 {
                            color: #007bff;
                        }
                        .content p {
                            font-size: 16px;
                            color: #333333;
                        }
                        .meeting-details {
                            margin-top: 20px;
                        }
                        .meeting-details table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        .meeting-details th, .meeting-details td {
                            border: 1px solid #dddddd;
                            padding: 8px;
                            text-align: left;
                        }
                        .meeting-details th {
                            background-color: #f2f2f2;
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
                            color: #007bff;
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
                            <h1>Meeting Scheduled</h1>
                        </div>
                        <div class="content">
                            <h2>Meeting Details</h2>
                            <p>Dear ' .$recipientName. ',</p>
                            <p>We are pleased to inform you that a meeting has been scheduled by SPACS CEC. Below are the details of the meeting:</p>
                            <div class="meeting-details">
                                <table>
                                    <tr>
                                        <th>Meeting Title</th>
                                        <td>' . $meeting_title . '</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>' . $meeting_date . '</td>
                                    </tr>
                                    <tr>
                                        <th>Start Time</th>
                                        <td>' . $start_time . '</td>
                                    </tr>
                                    <tr>
                                        <th>End Time</th>
                                        <td>' . $end_time . '</td>
                                    </tr>
                                    <tr>
                                        <th>Venue</th>
                                        <td>' . $venue . '</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>' . $description . '</td>
                                    </tr>
                                </table>
                            </div>
                            <p>Please make sure to attend the meeting on time and be prepared with any materials you may need to discuss.</p>
                        </div>
                        <div class="footer">
                            <p>If you have any questions or need further assistance, please contact us at:</p>
                            <p>Email: <a href="mailto:ebinbenny777@gmail.com">ebinbenny777@gmail.com</a></p>
                            <p>Phone: <a href="tel:+919846261894">+91 98462 61894</a></p>
                        </div>
                    </div>
                </body>
                </html>
                ';

                $mail->Body = $mailContent;
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        // Redirect to meetingdetail.php after 2 seconds
        echo '<script>';
        echo 'setTimeout(function(){';
        echo '  window.location.href = "meetingdetail.php";';
        echo '}, 2000);';  // Redirect after 2 seconds
        echo '</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
