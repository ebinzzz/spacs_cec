<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['id'];
    $status = $_POST['status'];

    // Update the payment status
    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $userId);

    if ($stmt->execute()) {
       // If the payment status update is successful
echo "<script type='text/javascript'>
alert('Payment status updated successfully.');
window.location.href = 'admin.php';
</script>";
        echo "Error: " . $stmt->error;
    }
if($status==='active')
{
    $sql = "SELECT * FROM users where id='$userId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $first_name=$row["first_name"];
        $memid=$row["memid"];
        $registration_date=$row["registration_date"];
        $last_name=$row["last_name"];
        $email=$row["email"];
        $amount=$row["amount"];
        $paymentId=$row["paymentId"];
        $paymentDate=$row["paymentDate"];
        $bankName=$row["bankName"];
        $recipientName=$row["recipientName"];
        $phoneNumber=$row["phoneNumber"];
        $paymentProof=$row["paymentProof"];
    }
}
    include_once("class.phpmailer.php");
include_once("class.smtp.php");


$recipientEmail = "$email";

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

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Payment Confirmation';
    
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
                background-color: #28a745;
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
                color: #28a745;
            }
            .content p {
                font-size: 16px;
                color: #333333;
            }
            .invoice-details {
                margin-top: 20px;
            }
            .invoice-details table {
                width: 100%;
                border-collapse: collapse;
            }
            .invoice-details th, .invoice-details td {
                border: 1px solid #dddddd;
                padding: 8px;
                text-align: left;
            }
            .invoice-details th {
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
                <h1>Invoice</h1>
            </div>
            <div class="content">
                <h2>Payment Details</h2>
                <p>Dear ' . $recipientName . ',</p>
                <p>Thank you for your payment. Below are the details of your transaction:</p>
                <div class="invoice-details">
                    <table>
                        <tr>
                            <th>Payment ID</th>
                            <td>' . $paymentId . '</td>
                        </tr>
                        <tr>
                            <th>Date of Payment</th>
                            <td>' . $paymentDate . '</td>
                        </tr>
                        <tr>
                            <th>Bank Name</th>
                            <td>' . $bankName . '</td>
                        </tr>
                        <tr>
                            <th>Recipient Name</th>
                            <td>' . $recipientName . '</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>' . $phoneNumber . '</td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>' . $amount . '</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <p>If you have any questions or need further assistance, please contact us at:</p>
                <p>Email: <a href="mailto:spacscectl@gmail.com">spacscectl@gmail.com</a></p>
                <p>Phone: <a href="tel:+919846261894">9846261894</a></p>
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

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Membership Confirmation';
    
    // HTML content
    $mailContent = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Membership Confirmation</title>
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
                background-color: #004085;
                color: #ffffff;
                padding: 20px;
                text-align: center;
            }
            .header img {
                max-width: 100px;
                margin: 0 20px;
            }
            .header h1 {
                margin: 0;
            }
            .content {
                padding: 20px;
            }
            .content h2 {
                color: #004085;
            }
            .content p {
                font-size: 16px;
                color: #333333;
            }
            .membership-details {
                margin-top: 20px;
            }
            .membership-details table {
                width: 100%;
                border-collapse: collapse;
            }
            .membership-details th, .membership-details td {
                border: 1px solid #dddddd;
                padding: 8px;
                text-align: left;
            }
            .membership-details th {
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
                color: #004085;
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
                <img src="cec.png" alt="College Logo">
                <img src="logo.png" alt="SPACS Logo">
                <h1>Membership Confirmation</h1>
            </div>
            <div class="content">
                <h2>Dear ' . $first_name . ' ,</h2>
                <p>We are pleased to confirm your membership with our organization. Below are your membership details:</p>
                <div class="membership-details">
                    <table>
                        <tr>
                            <th>Membership ID</th>
                            <td>' . $memid . '</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>' . $first_name . ' ' . $last_name . '</td>
                        </tr>
                        <tr>
                            <th>Membership Date</th>
                            <td>' . $registration_date . '</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <p>If you have any questions or need further assistance, please contact us at:</p>
                <p>Email: <a href="mailto:spacscectl@gmail.com">spacscectl@gmail.com</a></p>
                <p>Phone: <a href="tel:+919846261894">+91 984 626 1894</a></p>
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
}
    $stmt->close();


$conn->close();
?>
