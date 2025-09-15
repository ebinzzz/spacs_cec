<?
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: spacs.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meeting Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Additional CSS styles for buttons */
        .btn-dutyleave, .btn-report, .btn-cancel, .btn-attendance {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            background-color: #337ab7; /* Bootstrap primary color */
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
<p><a href="admin.php">&laquo; Back to Admin Page</a></p>
    <div class="container">
        <h1>Meeting Details</h1>
        <table class="table user-list">
            <thead>
                <tr>
                    <th>Meeting Title</th>
                    <th>Space ID</th>
                    <th>Meeting Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                       <th>Venue</th>
                    <th class="text-center">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
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

                // Query to fetch meetings
                $sql = "SELECT * FROM meetings";
                $result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['meeting_title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['space_id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['meeting_date']) . '</td>';
        echo '<td>' . htmlspecialchars($row['start_time']) . '</td>';
        echo '<td>' . htmlspecialchars($row['end_time']) . '</td>';
           echo '<td>' . htmlspecialchars($row['venue']) . '</td>';
        echo '<td class="text-center">' . htmlspecialchars($row['status']) . '</td>'; // Replace with actual logic for status
        if ($row['status'] != 'Cancelled') {
            echo '<td>';
           echo '<button class="btn-attendance" data-meeting-id="' . $row['id'] . '" onclick="duty(' . $row['id'] . ')">Duty Leave</button>';
            echo '<button class="btn-report" data-meeting-id="' . $row['id'] . '">Report</button>';
            echo '<button class="btn-cancel" onclick="cancelMeeting(' . $row['id'] . ')">Cancel</button>';
             echo '<button class="btn-attendance" data-meeting-id="' . $row['id'] . '" onclick="markAttendance(' . $row['id'] . ')">Attendance</button>';
            echo '</td>';
        }
        echo '</tr>';
    }
}
 else {
                    echo '<tr><td colspan="7">No meetings found.</td></tr>';
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
     function duty(meetingId) {
        window.location.href = 'duty.php?meeting_id=' + meetingId;
    }
       
     function markAttendance(meetingId) {
        window.location.href = 'mark_attend.php?meeting_id=' + meetingId;
    }
        function cancelMeeting(meetingId) {
            var confirmCancel = confirm("Are you sure you want to cancel this meeting?");
            if (confirmCancel) {
                var url = "cancel_meeting.php?meeting_id=" + meetingId;
                window.location.href = url;
            } else {
                // Do nothing or provide feedback to the user
            }
        }
    </script>
</body>
</html>


<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
    border-radius: 8px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th, .table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

.table th {
    background-color: #f2f2f2;
}

.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table tbody tr:hover {
    background-color: #e6f7ff;
}

.btn-dutyleave, .btn-report, .btn-cancel, .btn-attendance {
    background-color: #007bff;
    border: none;
    color: #fff;
    padding: 8px 12px;
    margin-right: 5px;
    cursor: pointer;
    border-radius: 4px;
}

.btn-dutyleave:hover, .btn-report:hover, .btn-cancel:hover, .btn-attendance:hover {
    background-color: #0056b3;
}

</style>