<?php
    $host = "sql213.infinityfree.com"; // Host name
    $dbUsername = "if0_35905142"; // MySQL username
    $dbPassword = "ZNczfupEaKJV"; // MySQL password
    $dbName = "if0_35905142_sem"; // Database name

    // Create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Retrieve form data

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch data from the form
$eventTitle = $_POST["eventTitle"];
$eventPrice = $_POST["eventPrice"];
$typeId = $_POST["typeId"];
$staff = $_POST["staff"];
$student = $_POST["student"];
$date = $_POST["date"];
$from = $_POST["fromTime"];
$to = $_POST["toTime"];
$venue = $_POST["venue"];
$description = $_POST["description"];
$ca = $_POST["ca"];

// Check if the venue is already booked for the specified date
$sql_check_venue = "SELECT * FROM events WHERE venue = '$venue' AND date = '$date'";
$result_check_venue = $conn->query($sql_check_venue);

if ($result_check_venue->num_rows > 0) {
    // Venue is already booked, display available venues
    echo "The venue is already booked for the specified date. Here are the available venues:<br>";

    // Fetch available venues
    $sql_available_venues = "SELECT * FROM venues WHERE venue_name NOT IN 
                             (SELECT venue FROM events WHERE date = '$date')";

    $result_available_venues = $conn->query($sql_available_venues);

    if ($result_available_venues->num_rows > 0) {
        // Display available venues as a table
        echo "<form method='post' action='add_event.php?venue=$venue'>";
        echo "<table>";
        echo "<tr><th>Venue</th><th>Action</th></tr>";
        while ($row = $result_available_venues->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["venue_name"] . "</td>";
            echo "<td><button type='submit' name='venue' value='".$row["venue_name"]."'>Schedule</button></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";
    } else {
        echo "No available venues for the specified date.";
    }
} else {
    // Venue does not exist in the events table for the specified date, proceed with inserting the event
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        // Upload the image to the server
        $targetDirectory = "uploads/"; // Specify the directory where you want to store uploaded images
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
           // echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Prepare SQL statement for inserting the event
    // Prepare SQL statement for inserting the event
$sql_insert = "INSERT INTO events (event_title, event_price, image, type_id, staff, student, date, time, time1, venue, pre,capa) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

// Prepare and bind parameters
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("sssissssssss", $eventTitle, $eventPrice, $targetFile, $typeId, $staff, $student, $date, $from, $to, $venue, $description,$ca);

// Set parameter values
$eventTitle = $_POST["eventTitle"];
$eventPrice = $_POST["eventPrice"];
$typeId = $_POST["typeId"];
$staff = $_POST["staff"];
$student = $_POST["student"];
$date = $_POST["date"];
$from = $_POST["fromTime"];
$to = $_POST["toTime"];
$venue = $_POST["venue"];
$description = $_POST["description"];
$ca = $_POST["ca"];

// Execute SQL statement
if ($stmt->execute()) {
    echo "<script>alert('New record created successfully');</script>";
    // Redirect to shedule.php
    echo "<script>window.location = 'admin.php';</script>";
} else {
echo "Error: " . $stmt->error;
}

// Close statement
$stmt->close();
}
?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #f2f2f2;
    }
</style>
