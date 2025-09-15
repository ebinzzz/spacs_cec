<?php 

    $host1 = "sql213.infinityfree.com"; // Host name
    $dbUsername1 = "if0_35905142"; // MySQL username
    $dbPassword1 = "ZNczfupEaKJV"; // MySQL password
    $dbName1 = "if0_35905142_sem"; // Database name

    // Create connection
    $conn1 = new mysqli($host1, $dbUsername1, $dbPassword1, $dbName1);

// Check connection
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}

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


if (isset($_GET['memid'])) {
    $userId = $_GET['memid'];
} else {
    // Redirect or handle the case where memid is not set
    header("Location: error.php"); // Redirect to an error page or show an error message
    exit();
}

$sql = "SELECT *
        FROM users
        WHERE id='$userId'";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id=$row['id'];    
$name1=$row['first_name'];
$name2=$row['last_name'];
$memid=$row['memid'];
$email=$row['email'];
$photo=$row['photo_path'];
$phone=$row['contact_no'];
$program=$row['program'];
$profile=$row['position'];
$certi=$row['certi'];
$path=$row['certificate_path'];

    }
}
?>

<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>
<div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="<?php echo"$photo";?>" alt=""/>
                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                       <?php echo" $name1 $name2"; ?>

                                    </h5>
                                    <h6>
                                        <?php echo"$profile";?>
                                    </h6>
                                    <p class="proile-rating">RANKINGS : <span>8/10</span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                    <a href=" editprofile.php?memid=<?php echo"$id";?> #" class="btn btn-primary profile-edit-btn">Edit Profile</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                        <br>
                        <br>
                           <?php



$event_id_query = "SELECT event_id FROM participants WHERE spacsid = ?";
$stmt = $conn1->prepare($event_id_query);
$stmt->bind_param("i", $memid);
$stmt->execute();
$stmt->bind_result($event_id);
$stmt->fetch();
$stmt->close();

if ($event_id) {
    // Fetch event details from events table
    $event_query = "SELECT event_title, date FROM events WHERE event_id = ?";
    $stmt = $conn1->prepare($event_query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->bind_result($event_title, $date);
    $stmt->fetch();
    $stmt->close();
}
$event_id_query = "SELECT event_id FROM participants WHERE spacsid = ?";
$stmt = $conn1->prepare($event_id_query);
$stmt->bind_param("i", $memid);
$stmt->execute();
$stmt->bind_result($event_id);
$stmt->fetch();
$stmt->close();

if ($event_id) {
    // Fetch event details from events table
    $event_query = "SELECT event_title, date FROM events WHERE event_id = ?";
    $stmt = $conn1->prepare($event_query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->bind_result($event_title, $date);
    $stmt->fetch();
    $stmt->close();
}


?>


                        </div><?php
                     if ($certi == 'no') {
    echo '<a href="request_certificate.php?memid=' . $id . '" class="btn btn-success">Request Membership Certificate</a><br><br>';
} elseif ($certi == 'yes') {
    echo '<a href="https://www.spacscec.free.nf/' . $path . '" class="btn btn-success">Download Membership Certificate</a><br><br>';
} else {
    echo '<p>Unknown certificate status.</p>';

}
?>
                        <a href="ulogout.php" class="btn btn-danger">LogOut</a>

                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Membership Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $memid;?></p>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo"$name1 $name2";?></p>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo"$email";?></p>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo"$phone";?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Profession</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo"$program";?> Student</p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" name="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Experience</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Hourly Rate</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>10$/hr</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Total Projects</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>230</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>English Level</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Availability</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>6 months</p>
                                            </div>
                                        </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <p>Your detail description</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form> 
                      
        </div>
        <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Your Spacs Events</h1>
                </div>
        
                <div class="report-body">
        <div class="report-topic-heading">
            <h3 class="t-op">Event Name</h3>
            <h3 class="t-op">Event Date</h3>
            <h3 class="t-op">Download Certificate</h3>
        </div>

        <div class="items">
            <?php
            if ( $event_title && $date) {
                echo '<div class="item1">';
                echo '<h3 class="t-op-nextlvl">' . $event_title . '</h3>';
                echo '<h3 class="t-op-nextlvl">' . $date . '</h3>';
                echo '<a class="btn" href="download_certificate.php?memid=' . $memid . '">Download Certificate</a>';
                echo '</div>';
            } else {
                echo "No event details found.";
            }
            ?>
        </div>
    </div>
</div>
            </div>
        <style>
            body{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}

.report-container {
  min-height: 300px;
  max-width: 1200px;
  margin: 70px auto 0px auto;
  background-color: #ffffff;
  border-radius: 30px;
  box-shadow: 3px 3px 10px rgb(188, 188, 188);
  padding: 0px 20px 20px 20px;
}
.report-header {
  height: 80px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 20px 10px 20px;
  border-bottom: 2px solid rgba(0, 20, 151, 0.59);
}

.recent-Articles {
  font-size: 30px;
  font-weight: 600;
  color: #5500cb;
}

.view {
  height: 35px;
  width: 90px;
  border-radius: 8px;
  background-color: #5500cb;
  color: white;
  font-size: 15px;
  border: none;
  cursor: pointer;
}

.report-body {
  max-width: 1160px;
  overflow-x: auto;
  padding: 20px;
}
.report-topic-heading,
.item1 {
  width: 1120px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.t-op {
  font-size: 18px;
  letter-spacing: 0px;
}

.items {
  width: 1120px;
  margin-top: 15px;
}

.item1 {
  margin-top: 20px;
}
.t-op-nextlvl {
  font-size: 14px;
  letter-spacing: 0px;
  font-weight: 600;
}

.label-tag {
  width: 100px;
  text-align: center;
  background-color: rgb(0, 177, 0);
  color: white;
  border-radius: 4px;
            </style>