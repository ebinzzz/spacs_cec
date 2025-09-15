<?php
// Database connection parameters
// Configuration
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';
// Start session


// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function sanitize_data($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to generate a unique 6-digit membership ID
function generate_membership_id() {
    global $conn;
    $unique = false;
    $membership_id = '';

    do {
        $membership_id = sprintf("%06d", mt_rand(1, 999999));
        $check_query = "SELECT * FROM users WHERE memid = '$membership_id'";
        $result = $conn->query($check_query);

        if ($result && $result->num_rows == 0) {
            $unique = true;
        }
    } while (!$unique);

    return $membership_id;
}

// Initialize variables to store form data
$email = $username = $password = $first_name = $last_name = $contact_no = $alt_contact_no = $photo_path = $signature_path = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_data($_POST["email"]);
    $username = sanitize_data($_POST["uname"]);
    $password = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    $first_name = sanitize_data($_POST["fname"]);
    $last_name = sanitize_data($_POST["lname"]);
    $contact_no = sanitize_data($_POST["phno"]);
    $alt_contact_no = sanitize_data($_POST["phno_2"]);

    // Check if the email already exists
    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $email_result = $conn->query($check_email_query);

    if ($email_result && $email_result->num_rows > 0) {
        die("Error: Email already registered.");
    }

    // Handle file upload for photo
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0) {
        $targetDirectory = "uploads/photos/";
        $targetFile1 = $targetDirectory . basename($_FILES["photo"]["name"]);

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile1)) {
            $photo_path = $targetFile1;
        } else {
            die("Sorry, there was an error uploading your photo.");
        }
    } else {
        die("Error: Photo upload is required.");
    }

    // Handle file upload for signature
    if(isset($_FILES["signature"]) && $_FILES["signature"]["error"] === 0) {
        $targetDirectory = "uploads/signatures/";
        $targetFile2 = $targetDirectory . basename($_FILES["signature"]["name"]);

        if (move_uploaded_file($_FILES["signature"]["tmp_name"], $targetFile2)) {
            $signature_path = $targetFile2;
        } else {
            die("Sorry, there was an error uploading your signature.");
        }
    } else {
        die("Error: Signature upload is required.");
    }

    // Generate a unique membership ID
    $membership_id = generate_membership_id();

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (memid, email, username, password, first_name, last_name, contact_no, alt_contact_no, photo_path, signature_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssssssssss", $membership_id, $email, $username, $password, $first_name, $last_name, $contact_no, $alt_contact_no, $photo_path, $signature_path);
        if ($stmt->execute()) {
            echo "<script> window.location.href='message.html';</script>";
            exit;
        } else {
            die("Error: " . $stmt->error);
        }

    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

// Close database connection
$conn->close();
?>
