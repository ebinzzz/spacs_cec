<?php
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

// Retrieve user ID from GET parameter
if (isset($_GET['memid'])) {
    $userId = intval($_GET['memid']); // Ensure $userId is an integer
} else {
    // Redirect to error page if memid is not set
    header("Location: error.php");
    exit();
}

// Fetch user details from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Fetch user details
    $photo = $row['photo_path'];
    $name1 = $row['first_name'];
    $name2 = $row['last_name'];
    $phone = $row['contact_no'];
    $email = $row['email'];
    $semester = $row['semester'];
    $program = $row['program'];
    $course = $row['course'];
    $college_name = $row['college_name'];
    $country = $row['country'];
    $state = $row['state'];
} else {
    // Redirect to error page if user not found
    header("Location: error.php");
    exit();
}

// Handle POST request to update user profile and add experience
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle profile update
    $name1 = htmlspecialchars($_POST['first_name']);
    $name2 = htmlspecialchars($_POST['last_name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $semester = htmlspecialchars($_POST['semester']);
    $program = htmlspecialchars($_POST['program']);
    $course = htmlspecialchars($_POST['course']);
    $college_name = htmlspecialchars($_POST['college_name']);
    $country = htmlspecialchars($_POST['country']);
    $state = htmlspecialchars($_POST['state']);

    // Update user profile in the database
    $updateQuery = "UPDATE users 
                    SET first_name=?, 
                        last_name=?, 
                        contact_no=?, 
                        email=?, 
                        semester=?, 
                        program=?, 
                        course=?, 
                        college_name=?, 
                        country=?, 
                        state=? 
                    WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssssssssi", $name1, $name2, $phone, $email, $semester, $program, $course, $college_name, $country, $state, $userId);

    if ($stmt->execute()) {
        // Success message for profile update
        echo '<script>alert("Profile updated successfully!");</script>';
    } else {
        // Error message for profile update
        echo "Error updating profile: " . $stmt->error;
    }

    // Handle file upload for photo update
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
        $targetDirectory = "uploads/photos/";
        $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $photo_path = $targetFile;

            // Update photo path in the database
            $updatePhotoQuery = "UPDATE users SET photo_path = ? WHERE id = ?";
            $stmt = $conn->prepare($updatePhotoQuery);
            $stmt->bind_param('si', $photo_path, $userId);

            if ($stmt->execute()) {
                echo '<script>alert("Photo updated successfully.");</script>';
            } else {
                echo "Error updating photo: " . $stmt->error;
            }
        } else {
            echo "Error moving uploaded file.";
        }
    }

    // Handle experience insertion
    $experience = htmlspecialchars($_POST['experience']);
    $additional_details = htmlspecialchars($_POST['additional_details']);

    // Insert new experience into the database
    $insertQuery = "INSERT INTO experience (user_id, experience, additional_details) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iss", $userId, $experience, $additional_details);

    if ($stmt->execute()) {
        // Success message for experience insertion
        echo '<script>alert("Experience added successfully!");</script>';
    } else {
        // Error message for experience insertion
        echo "Error adding experience: " . $stmt->error;
    }
}

// Close the database connection
$conn->close();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<a href="profile.php?memid=<?php echo"$userId ";?>" class="btn btn-secondary mb-3">Back to Profile</a>

<div class="container rounded bg-white mt-5 mb-5">
     
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" src="<?php echo $photo; ?>">
                  <form method="POST" action=""   enctype="multipart/form-data">

        <input type="file" id="file" name="file" accept="image/*">


    <input type="hidden" name="id" value="<?php echo $userId; ?>"> <!-- Replace with your actual user ID -->
  
    <input type="submit" name="submit" class="btn btn-success" value="Upload">
            

                        <span class="font-weight-bold"><?php echo $name1 . ' ' . $name2; ?></span>
                        <span class="text-black-50"><?php echo $email; ?></span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Name</label>
                                <input type="text" class="form-control" placeholder="first name" name="first_name" value="<?php echo $name1; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Surname</label>
                                <input type="text" class="form-control" placeholder="surname" name="last_name" value="<?php echo $name2; ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Mobile Number</label>
                                <input type="text" class="form-control" placeholder="enter phone number" name="phone" value="<?php echo $phone; ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email ID</label>
                                <input type="text" class="form-control" placeholder="enter email id" name="email" value="<?php echo $email; ?>">
                            </div>
                            <br>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center experience">
                                <span>Education Detail</span>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label class="labels">Semester</label>
                                <select class="form-control mb-3" name="semester">
                                    <option value="" disabled selected>Select Semester</option>
                                    <option value="1" <?php echo $semester == '1' ? 'selected' : ''; ?>>Semester 1</option>
                                    <option value="2" <?php echo $semester == '2' ? 'selected' : ''; ?>>Semester 2</option>
                                    <option value="3" <?php echo $semester == '3' ? 'selected' : ''; ?>>Semester 3</option>
                                    <option value="4" <?php echo $semester == '4' ? 'selected' : ''; ?>>Semester 4</option>
                                    <option value="5" <?php echo $semester == '5' ? 'selected' : ''; ?>>Semester 5</option>
                                    <option value="6" <?php echo $semester == '6' ? 'selected' : ''; ?>>Semester 6</option>
                                    <option value="7" <?php echo $semester == '7' ? 'selected' : ''; ?>>Semester 7</option>
                                    <option value="8" <?php echo $semester == '8' ? 'selected' : ''; ?>>Semester 8</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Programme</label>
                                <select class="form-control mb-3" name="program">
                                    <option value="" disabled selected>Select Program</option>
                                    <option value="B.Tech" <?php echo $program == 'btech' ? 'selected' : ''; ?>>B.Tech</option>
                                    <option value="MCA" <?php echo $program == 'mca' ? 'selected' : ''; ?>>MCA</option>
                                    <option value="mtech" <?php echo $program == 'mtech' ? 'selected' : ''; ?>>M.Tech</option>
                                    <option value="mba" <?php echo $program == 'mba' ? 'selected' : ''; ?>>MBA</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Course</label>
                                <select class="form-control mb-3" name="course">
                                    <option value="" disabled selected>Select Course</option>
                                    <option value="cse" <?php echo $course == 'cse' ? 'selected' : ''; ?>>Computer Science and Engineering</option>
                                    <option value="ece" <?php echo $course == 'ece' ? 'selected' : ''; ?>>Electronics and Communication Engineering</option>
                                    <option value="eee" <?php echo $course == 'eee' ? 'selected' : ''; ?>>Electrical and Electronics Engineering</option>
                                    <option value="ai" <?php echo $course == 'ai' ? 'selected' : ''; ?>>Artificial Intelligence</option>
                                    <option value="ot" <?php echo $course == 'ot' ? 'selected' : ''; ?>>Others</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">College Name</label>
                                <select class="form-control mb-3" name="college_name">
                                    <option value="" disabled selected>Select College</option>
                                    <option value="cectl" <?php echo $college_name == 'cectl' ? 'selected' : ''; ?>>College of Engineering Cherthala (CEC)</option>
                                    <option value="cet" <?php echo $college_name == 'cet' ? 'selected' : ''; ?>>College of Engineering Trivandrum (CET)</option>
                                    <option value="nitc" <?php echo $college_name == 'nitc' ? 'selected' : ''; ?>>National Institute of Technology Calicut (NITC)</option>
                                    <option value="tkmce" <?php echo $college_name == 'tkmce' ? 'selected' : ''; ?>>TKM College of Engineering, Kollam (TKMCE)</option>
                                    <option value="rit" <?php echo $college_name == 'rit' ? 'selected' : ''; ?>>Rajiv Gandhi Institute of Technology, Kottayam (RIT)</option>
                                    <option value="gect" <?php echo $college_name == 'gect' ? 'selected' : ''; ?>>Government Engineering College, Thrissur (GECT)</option>
                                    <option value="gecpt" <?php echo $college_name == 'gecpt' ? 'selected' : ''; ?>>Government Engineering College, Palakkad (GECPT)</option>
                                    <option value="mace" <?php echo $college_name == 'mace' ? 'selected' : ''; ?>>Mar Athanasius College of Engineering, Kothamangalam (MACE)</option>
                                    <option value="mcet" <?php echo $college_name == 'mcet' ? 'selected' : ''; ?>>Model Engineering College, Thrikkakara (MCET)</option>
                                    <option value="geci" <?php echo $college_name == 'geci' ? 'selected' : ''; ?>>Government Engineering College, Idukki (GECI)</option>
                                    <option value="geck" <?php echo $college_name == 'geck' ? 'selected' : ''; ?>>Government Engineering College, Kozhikode (GECK)</option>
                                    <option value="cec" <?php echo $college_name == 'cec' ? 'selected' : ''; ?>>College of Engineering Chengannur (CEC)</option>
                                    <option value="gect" <?php echo $college_name == 'gect' ? 'selected' : ''; ?>>Government Engineering College, Barton Hill (GECT)</option>
                                    <option value="vidya" <?php echo $college_name == 'vidya' ? 'selected' : ''; ?>>Vidya Academy of Science and Technology, Thrissur</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Country</label>
                                <input type="text" class="form-control" placeholder="country" name="country" value="<?php echo $country; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">State/Region</label>
                                <input type="text" class="form-control" placeholder="state" name="state" value="<?php echo $state; ?>">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center experience">
                            <span>Add Experience</span>
                            <span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <label class="labels">Experience</label>
                            <input type="text" class="form-control" placeholder="experience" name="experience" value="">
                        </div>
                        <br>
                        <div class="col-md-12">
                            <label class="labels">Additional Details</label>
                            <input type="text" class="form-control" placeholder="additional details" name="additional_details" value="">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
  

<style>
    .upload-form {
    position: relative;
}

.upload-form input[type="file"] {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file {
    position: relative;
    overflow: hidden;
    display: inline-block;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}

/* Additional styling to match Bootstrap button styles */
.file:hover {
    background-color: #0056b3;
}


body {
    background: rgb(99, 39, 120)
}


.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}

.profile-button {
    background: rgb(99, 39, 120);
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
}
</style>
<script>


</script>