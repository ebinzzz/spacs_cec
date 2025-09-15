<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'] === 'approve' ? 'approved' : 'disapproved';
    $event_id = intval($_POST['event_id']);

    @include 'config.php';

    // If approved, fetch participant & event details and send ticket email
    if ($action === 'approved') {
        $stmt = $conn->prepare("SELECT r.full_name, r.email, r.id AS participant_id, e.event_name AS event_name 
                                FROM event_registrations r 
                                JOIN events e ON r.event_id = e.id 
                                WHERE r.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

if ($data) {
    $participantName = $data['full_name'];
    $participantEmail = $data['email'];
    $participantId = $data['participant_id'];
    $eventName = $data['event_name'];

    // Construct ticket URL directly with event_id and participant_id in the query string
    $ticketUrl = "https://spacscec.free.nf/event_s/ticket.php?event_id=" . urlencode($event_id) . "&participant_id=" . urlencode($participantId);

    // Then use $ticketUrl in your email body as needed



            // Email HTML content with button styled link
            $message = '<div style="font-family: Arial, sans-serif; line-height: 1.6;">
                <h2>🎉 Registration Approved!</h2>
                <p>Hi <b>' . htmlspecialchars($participantName) . '</b>,</p>
                <p>Your registration for <strong>' . htmlspecialchars($eventName) . '</strong> has been approved.</p>
                <p>Click the button below to access your ticket:</p>
                <p style="text-align:center;">
                    <a href="' . htmlspecialchars($ticketUrl) . '" 
                       style="background-color:#2196f3;color:#fff;padding:12px 20px;border-radius:6px;
                              text-decoration:none;display:inline-block;font-weight:bold;">
                       🎫 View Ticket
                    </a>
                </p>
                <p>Please bring your ticket for entry verification.</p>
                <br>
                <p>Regards,<br>SPACS Team</p>
            </div>';

            // Send email using PHPMailer
            require '../class.phpmailer.php';
            require '../class.smtp.php';

            try {
                $mail = new PHPMailer(true);
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->Username = 'ebinbenny1709@gmail.com'; // Your SMTP email
                $mail->Password = 'kouiproacwnesmpg';        // Your SMTP app password
                $mail->From = $mail->Username;
                $mail->FromName = "SPACSCEC";
                $mail->AddAddress($participantEmail);
                $mail->Subject = "🎫 Your Ticket for " . $eventName;
                $mail->isHTML(true);
                $mail->Body = $message;
                $mail->send();
            } catch (Exception $e) {
                error_log("Mailer Error: " . $mail->ErrorInfo);
            }
        }
    }

    // Update registration status regardless of approval or disapproval
    $stmt = $conn->prepare("UPDATE event_registrations SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: index.php?event_id=" . urlencode($event_id));
    exit;
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'] === 'approve' ? 'approved' : 'disapproved';
    $event_id = intval($_POST['event_id']);

    @include 'config.php';

    // If approved, fetch participant & event details and send ticket email
    if ($action === 'approved') {
        $stmt = $conn->prepare("SELECT r.full_name, r.email, r.id AS participant_id, e.event_name AS event_name 
                                FROM event_registrations r 
                                JOIN events e ON r.event_id = e.id 
                                WHERE r.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

if ($data) {
    $participantName = $data['full_name'];
    $participantEmail = $data['email'];
    $participantId = $data['participant_id'];
    $eventName = $data['event_name'];

    // Construct ticket URL directly with event_id and participant_id in the query string
    $ticketUrl = "http://localhost/event/ticket.php?event_id=" . urlencode($event_id) . "&participant_id=" . urlencode($participantId);

    // Then use $ticketUrl in your email body as needed



            // Email HTML content with button styled link
            $message = '<div style="font-family: Arial, sans-serif; line-height: 1.6;">
                <h2>🎉 Registration Approved!</h2>
                <p>Hi <b>' . htmlspecialchars($participantName) . '</b>,</p>
                <p>Your registration for <strong>' . htmlspecialchars($eventName) . '</strong> has been approved.</p>
                <p>Click the button below to access your ticket:</p>
                <p style="text-align:center;">
                    <a href="' . htmlspecialchars($ticketUrl) . '" 
                       style="background-color:#2196f3;color:#fff;padding:12px 20px;border-radius:6px;
                              text-decoration:none;display:inline-block;font-weight:bold;">
                       🎫 View Ticket
                    </a>
                </p>
                <p>Please bring your ticket for entry verification.</p>
                <br>
                <p>Regards,<br>SPACS Team</p>
            </div>';

            // Send email using PHPMailer
            require '../class.phpmailer.php';
            require '../class.smtp.php';

            try {
                $mail = new PHPMailer(true);
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->Username = 'ebinbenny1709@gmail.com'; // Your SMTP email
                $mail->Password = 'kouiproacwnesmpg';        // Your SMTP app password
                $mail->From = $mail->Username;
                $mail->FromName = "SPACSCEC";
                $mail->AddAddress($participantEmail);
                $mail->Subject = "🎫 Your Ticket for " . $eventName;
                $mail->isHTML(true);
                $mail->Body = $message;
                $mail->send();
            } catch (Exception $e) {
                error_log("Mailer Error: " . $mail->ErrorInfo);
            }
        }
    }

    // Update registration status regardless of approval or disapproval
    $stmt = $conn->prepare("UPDATE event_registrations SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: index.php?event_id=" . urlencode($event_id));
    exit;
}
?>
