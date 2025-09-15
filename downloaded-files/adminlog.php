<?php
// Start session
session_start();

// Database connection settings
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
    
    // Validate inputs
    if (empty($email) || empty($password)) {
        echo "Email and Password are required.";
        exit;
    }
    
    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    
    // Execute query
    $stmt->execute();
    $stmt->store_result();
    
    // Check if user exists
    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($id, $username, $stored_password);
        $stmt->fetch();
        
        // Verify password (since it's plain text, directly compare)
        if ($password === $stored_password) {
            // Password is correct, start a session and set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            
            echo "Login successful! Welcome, " . $username;
            // Redirect to a protected page
            header("Location: admin.php");
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }
    
    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
