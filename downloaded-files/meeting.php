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
    <title>Schedule Meeting</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Schedule a Meeting</h1>
        <button class="btn" ><a href="meetingdetail.php">Meeting Detail</a></button>
        <br>
        <br>
        <form action="schedule_meeting.php" method="POST">
            <div class="form-group">
                <label for="space_id">Space ID:</label>
                <input type="number" id="space_id" name="space_id" required>
            </div>
            <div class="form-group">
                <label for="meeting_title">Meeting Title:</label>
                <input type="text" id="meeting_title" name="meeting_title" required>
            </div>
            <div class="form-group">
                <label for="meeting_date">Meeting Date:</label>
                <input type="date" id="meeting_date" name="meeting_date" required>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" name="start_time" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" name="end_time" required>
            </div>

              <div class="form-group">
                <label for="end_time">Venue</label>
                <input type="text" id="venue" name="venue" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <button type="submit" name="schedule_meeting">Schedule Meeting</button>
        </form>
    </div>
</body>
</html>
<style>
    .btn{
        width:50%;
        item-align:center;
        position:relative;
        jusitify-content:center;
    }
    .btn a{
        color:white;
        text-decoration:none;
    }
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 50%;
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

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="date"],
input[type="time"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    background: #007bff;
    border: none;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}

    </style>