

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

 $sql8 = "SELECT type_id, type_title FROM event_type";
$result8 = $conn->query($sql8);

?>

<!DOCTYPE html>
<!---Coding By CodingLab | www.codinglabweb.com--->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!--<title>Registration Form in HTML CSS</title>-->
    <!---Custom CSS File--->
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <section class="container">
      <header>Registration Form</header>
      <form action="add_event.php" class="form"method="post" enctype="multipart/form-data">
        <div class="input-box">
        
            <label for="eventTitle">Event Title:</label><br>
            <input type="text" id="eventTitle" name="eventTitle" required><br>
        </div>

        <div class="input-box">
            <label for="eventPrice">Event Price:</label><br>
            <input type="text" id="eventPrice" name="eventPrice" required><br> 
        </div>

        <div class="column">
          <div class="input-box">
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>
          </div>
          <div class="input-box">
            <label for="image">Upload Image:</label><br>
            <input type="file" id="image" name="image" accept="image/*" required><br>
          </div>
        </div>
        <div class="gender-box">
          <h3></h3>
          <div class="gender-option">
            <div class="gender">
                  <label for="typeId">Event Type:</label>
    <select name="typeId" id="typeId">
        <?php
        if ($result8->num_rows > 0) {
            // Output data of each row
            while($row8 = $result8->fetch_assoc()) {
                echo '<option value="' . $row8["type_id"] . '">' . $row8["type_title"] . '</option>';
            }
        } else {
            echo '<option value="0">No event types available</option>';
        }
        ?>
    </select><br>
            </div>
            <div class="gender">
                   
            <label for="staff">Staff:</label><br>
            <select name="staff" id="staff" required>
                <?php
                // Include your database connection code here
    
                // Query to fetch staff details
                $query_staff = "SELECT * FROM staff";
                $result_staff = mysqli_query($conn, $query_staff);
    
                // Display staff options in dropdown
                while ($row_staff = mysqli_fetch_assoc($result_staff)) {
                    echo "<option value='" . $row_staff['staff_name'] . "'>" . $row_staff['staff_name'] . "</option>";
                }
                ?>
            </select>
            </div>
            <div class="gender">
                <label for="student">Student:</label><br>
                <select name="student" id="student" required>
                    <?php
                    // Query to fetch student details
                    $query_student = "SELECT * FROM students";
                    $result_student = mysqli_query($conn, $query_student);
        
                    // Display student options in dropdown
                    while ($row_student = mysqli_fetch_assoc($result_student)) {
                        echo "<option value='" . $row_student['student_name'] . "'>" . $row_student['student_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
          </div>
        </div>
        <div class="input-box address">
          <label>Address</label>
          <label for="date">Date:</label><br>
            <input type="date" id="date" name="date" required ><br>
          <div class="column">
            <div class="input-box address">
                <label for="fromTime">From Time:</label><br>
                <input type="time" id="fromTime" name="fromTime" required><br>
            </div>
            <br>
            <div class="input-box address">
            <label for="toTime">To Time:</label><br>
<input type="time" id="toTime" name="toTime" required><br>
</div>
          </div>
          <div class="column">
            <div class="input-box address">
            <label for="venue">Venue:</label><br>
            <input type="text" id="venue" name="venue" required ">
          </div>
            <div class="input-box address">
            <label for="Tickets">Tickets:</label><br>
            <input type="number" id="ca" name="ca" required ">
            </div>
          </div>
        </div>
        <input type="submit" value="Add Event" class="formbutton">
      </form>
    </section>
  </body>
</html>
<style>
    /* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: rgb(130, 106, 251);
}
.container {
  position: relative;
  max-width: 700px;
  width: 100%;
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}
.container header {
  font-size: 1.5rem;
  color: #333;
  font-weight: 500;
  text-align: center;
}
.container .form {
  margin-top: 30px;
}
.form .input-box {
  width: 100%;
  margin-top: 20px;
}
.input-box label {
  color: #333;
}
.form :where(.input-box input, .select-box) {
  position: relative;
  height: 50px;
  width: 100%;
  outline: none;
  font-size: 1rem;
  color: #707070;
  margin-top: 8px;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 0 15px;
}
.input-box input:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}
.form .column {
  display: flex;
  column-gap: 15px;
}
.form .gender-box {
  margin-top: 20px;
}
.gender-box h3 {
  color: #333;
  font-size: 1rem;
  font-weight: 400;
  margin-bottom: 8px;
}
.form :where(.gender-option, .gender) {
  display: flex;
  align-items: center;
  column-gap: 50px;
  flex-wrap: wrap;
}
.form .gender {
  column-gap: 5px;
}
.gender input {
  accent-color: rgb(130, 106, 251);
}
.form :where(.gender input, .gender label) {
  cursor: pointer;
}
.gender label {
  color: #707070;
}
.address :where(input, .select-box) {
  margin-top: 15px;
}
.select-box select {
  height: 100%;
  width: 100%;
  outline: none;
  border: none;
  color: #707070;
  font-size: 1rem;
}
.formbutton {
  height: 55px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  font-weight: 400;
  margin-top: 30px;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  background: rgb(130, 106, 251);
}
.form button:hover {
  background: rgb(88, 56, 250);
}
/*Responsive*/
@media screen and (max-width: 500px) {
  .form .column {
    flex-wrap: wrap;
  }
  .form :where(.gender-option, .gender) {
    row-gap: 15px;
  }
}
</style>