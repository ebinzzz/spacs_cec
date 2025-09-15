<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $date = $_POST['date'];

    // Generate unique bill number
    $bill_number = uniqid('BILL_');

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $upload_ok = 1;

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }

    if ($upload_ok == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert main bill data into bills table
            $sql = "INSERT INTO bills (bill_number, customer_name, date, file_path)
                    VALUES ('$bill_number', '$customer_name', '$date', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                $bill_id = $conn->insert_id; // Get the inserted bill ID

                // Insert each amount and description into bill_items table
                $amounts = $_POST['amount'];
                $descriptions = $_POST['description'];

                for ($i = 0; $i < count($amounts); $i++) {
                    $amount = $amounts[$i];
                    $description = $descriptions[$i];

                    $sql = "INSERT INTO bill_items (bill_id, amount, description)
                            VALUES ('$bill_id', '$amount', '$description')";

                    if (!$conn->query($sql)) {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                echo "New bill recorded successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $conn->close();
}
?>
