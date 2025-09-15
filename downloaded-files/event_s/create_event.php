<?php
// Database config
@include 'config.php';

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $event_name = trim($_POST['event_name']);
    $event_date = $_POST['event_date'];
    $location = trim($_POST['location']);
    $registration_last_date = $_POST['registration_last_date'];
    $registration_limit = (int)$_POST['registration_limit'];
    $registration_fee = isset($_POST['registration_fee']) ? (float)$_POST['registration_fee'] : 0;
    $prize_pool = isset($_POST['prize_pool']) && $_POST['prize_pool'] !== '' ? (float)$_POST['prize_pool'] : null;
    $description = trim($_POST['description']);

    // Handle poster image upload
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['poster']['tmp_name'];
        $fileName = $_FILES['poster']['name'];
        $fileSize = $_FILES['poster']['size'];
        $fileType = $_FILES['poster']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed extensions
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Create a unique name for the file to avoid overwriting
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Directory where posters will be stored
            $uploadFileDir = './uploads/posters/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Insert event data into DB
                $stmt = $pdo->prepare("INSERT INTO events 
                    (event_name, poster, event_date, location, registration_last_date, registration_limit, registration_fee, prize_pool, description)
                    VALUES (:event_name, :poster, :event_date, :location, :registration_last_date, :registration_limit, :registration_fee, :prize_pool, :description)");

                $stmt->execute([
                    ':event_name' => $event_name,
                    ':poster' => $newFileName,
                    ':event_date' => $event_date,
                    ':location' => $location,
                    ':registration_last_date' => $registration_last_date,
                    ':registration_limit' => $registration_limit,
                    ':registration_fee' => $registration_fee,
                    ':prize_pool' => $prize_pool,
                    ':description' => $description
                ]);

                echo "Event created successfully.";
            } else {
                echo "There was an error moving the uploaded file.";
            }
        } else {
            echo "Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions);
        }
    } else {
        echo "Error uploading poster image.";
    }
} else {
    echo "Invalid request method.";
}
?>
