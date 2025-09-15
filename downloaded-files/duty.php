<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: spacs.html");
    exit();
}


// Check if meeting_id is provided in the query string
if (!isset($_GET['meeting_id'])) {
    die("Meeting ID is missing.");
}

// Database connection parameters
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize meeting ID from query string
$meeting_id = $conn->real_escape_string($_GET['meeting_id']);

// Fetch meeting details
$sql_meeting = "SELECT * FROM meetings WHERE id = '$meeting_id'";
$result_meeting = $conn->query($sql_meeting);
if ($result_meeting->num_rows > 0) {
    $meeting_row = $result_meeting->fetch_assoc();
    $meeting_title = $meeting_row['meeting_title'];
    $space_id = $meeting_row['space_id'];
    $meeting_date = $meeting_row['meeting_date'];
    $start_time = $meeting_row['start_time'];
    $end_time = $meeting_row['end_time'];
} else {
    die("Meeting not found.");
}

// Fetch attendance details
$sql_attendance = "SELECT execom_member_id FROM attendance WHERE meeting_id = '$meeting_id'";
$result_attendance = $conn->query($sql_attendance);
$execom_ids = [];
if ($result_attendance->num_rows > 0) {
    while ($row_attendance = $result_attendance->fetch_assoc()) {
        $execom_ids[] = $row_attendance['execom_member_id'];
    }
} else {
    die("No attendance records found.");
}

// Fetch execom members' names
$execom_names = [];
foreach ($execom_ids as $execom_id) {
    $sql_execom = "SELECT name FROM execom_member WHERE id = '$execom_id'";
    $result_execom = $conn->query($sql_execom);
    if ($result_execom->num_rows > 0) {
        $execom_row = $result_execom->fetch_assoc();
        $execom_names[] = $execom_row['name'];
    }
}

// Close connection
$conn->close();

// Generate the formatted letter content
$current_date = date('d/m/Y');
$chairman_name = "Ebin Benny";
$spacs_coordinator = "SPACS Chairperson";
$college_name = "College of Engineering Cherthala";

$letter_content = "\nFrom,\n";
$letter_content .= "$chairman_name\n$spacs_coordinator\n$college_name\n";

$letter_content .= "\nDate: $current_date\n";

$letter_content .= "\nTo,\n";
$letter_content .= "The Principal\n$college_name\n\n";

$letter_content .= "Sub: Request for duty leave\n";
$letter_content .= "Dear Madam\n\n";
$letter_content .= "\t I am writing to request duty leave for myself and the coordinators on $meeting_date from \n $start_time to $end_time to conduct a $meeting_title. This meeting is integral to our team's professional development\n and will contribute significantly to our skill enhancement.\n";

$letter_content .= "The coordinators attending are:\n";
foreach ($execom_names as $index => $name) {
    $letter_content .= ($index + 1) . ". $name\n";
}

$letter_content .= "Your cooperation in granting them leave for the mentioned purpose would be highly appreciated.\n";
$letter_content .= "Thank you for considering my request.\n\n";
$letter_content .= "Yours sincerely,\n";
$letter_content .= "$chairman_name\n\n";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Letter</title>
    <style>
        .letter {
            font-size: 14pt;
            font-family: 'Times New Roman', Times, serif;
            text-align: left;
            margin-left: 20px;
            margin-top: 20px;
            width: 80%;
            position: relative; /* Ensure positioning context for absolute positioning */
        }
        
        .print-button {
            text-align: center;
            margin-top: 20px;
        }
        
        .print-button button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            margin-left: 50%;

        }
        
        .print-button button:hover {
            background-color: #45a049;
        }
        
        /* Media Query for Print */
        @media print {
            body {
                background-color: #fff;
                font-size: 12pt;
                margin: 0;
                padding: 0;
            }
        
            .print-button {
                display: none;
            }
        }
        
        /* Style for SPACS seal image */
        .spacs-seal {
            position: absolute;
            bottom: -30%; /* Adjust as needed */
            left: 50%; /* Center horizontally */
            transform: translateX(-30%); /* Center horizontally */
        }
    </style>
</head>
<body>
    <div class="letter">
        <pre>
            <?php echo nl2br(htmlspecialchars($letter_content)); ?>
        </pre>
        <div class="print-button">
            <button onclick="window.print()">Print this letter</button>
        </div>
      
    </div>
</body>
</html>
