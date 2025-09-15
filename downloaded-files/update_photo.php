<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {

    // Validate and sanitize the user ID
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        die("Error: Invalid user ID.");
    }

    // Database connection details
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

    // Validate the file upload
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
        $targetDirectory = "uploads/photos/";
        $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);

        // Check file size (optional)
        if ($_FILES["file"]["size"] > 5000000) { // 5 MB limit
            die("Error: File size is too large. Max allowed size is 5 MB.");
        }

        // Check file type (optional)
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($fileType, $allowedTypes)) {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Create target directory if it doesn't exist
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $photo_path = $targetFile;

            // Connect to the database using mysqli
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the database connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare the SQL statement to update the photo path
            $sql = "UPDATE users SET photo_path = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            // Bind parameters and execute the query
            $stmt->bind_param('si', $photo_path, $id);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Photo updated successfully.');
                        window.location.href = 'profile.php';
                      </script>";
            } else {
                echo "Error updating photo: " . $stmt->error;
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your photo.";
        }
    } else {
        echo "Error: Photo upload is required.";
    }
} else {
    echo "Form not submitted.";
}
?>
