<?php
// Configuration
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
// Login functionality
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['pass']; // Raw password input

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password, paymentstatus, status FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email); // "s" for string type
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password, $paymentstatus, $status);
            $stmt->fetch();

            // Verify the password against the stored hash
            if (password_verify($password, $hashed_password)) {
                // Login successful, start session
                $_SESSION['user_id'] = $user_id;

                // Check payment status and membership status
                if ($paymentstatus == 'no') {
                    // Redirect to payment page
                    header("Location: payment.php?memid=" . $user_id);
                    exit;
                } elseif ($status == 'active') {
                    // Redirect to user page
                    header("Location: profile.php?memid=" . $user_id);
                    exit;
                }elseif ($status == 'rejected') {
                    // Redirect to user page
                    header("Location: reject.html");
                    exit;
                }  else {
                    // Membership not active or some other status
                    echo "<script>alert('Your account will be active once the admin approve the payment info. Please contact support.'); window.location.href='login.html';</script>";
                    exit;
                }
            } else {
                // Incorrect password
                echo "<script>alert('Invalid email or password'); window.location.href='login.html';</script>";
                exit;
            }
        } else {
            // Email not found
            echo "<script>alert('Invalid email or password'); window.location.href='login.html';</script>";
            exit;
        }

        $stmt->close();
    } else {
        $error = "Error preparing statement: " . $conn->error;
        echo "<script>alert('$error'); window.location.href='login.html';</script>";
    }
}

$conn->close();
?>
