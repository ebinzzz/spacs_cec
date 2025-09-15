<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $memid = $_POST['memid'];

    // Database connection
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

    // Query to search for user by memid
    $sql = "SELECT first_name, last_name, memid, email, photo_path FROM users WHERE memid = ? AND status = 'active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $memid);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name, $memid, $email, $photo_path);

    if ($stmt->fetch()) {
        $user_found = true;
    } else {
        $user_found = false;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <style>
        body {
            background: url('path_to_your_background_image.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Verdana', sans-serif;
        }
        .form-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container input[type="submit"] {
            background-color: #0950ef;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0041ad;
        }
        .id-card-holder {
            width: 225px;
            padding: 4px;
            margin: 0 auto;
            background-color: #1f1f1f;
            border-radius: 5px;
            position: relative;
            display: <?php echo isset($user_found) && $user_found ? 'block' : 'none'; ?>;
        }
        .id-card-holder:after, .id-card-holder:before {
            content: '';
            width: 7px;
            display: block;
            background-color: #0a0a0a;
            height: 100px;
            position: absolute;
            top: 105px;
        }
        .id-card-holder:before {
            left: 222px;
            border-radius: 5px 0 0 5px;
        }
        .id-card-holder:after {
            border-radius: 0 5px 5px 0;
        }
        .id-card {
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 1.5px 0px #b9b9b9;
        }
        .id-card img {
            margin: 0 auto;
        }
        .header img {
            width: 280px;
            margin-top: 15px;
            margin-left: -18%;
        }
        .photo img {
            width: 80px;
            margin-top: 15px;
        }
        h2, h3, h4 {
            margin: 5px 0;
        }
        h3, h4 {
            font-weight: 300;
        }
        .qr-code img {
            width: 50px;
        }
        p {
            font-size: 5px;
            margin: 2px;
        }
        .id-card-hook, .id-card-tag-strip, .id-card-tag, .id-card-tag:after {
            background-color: #d7d6d3;
            position: relative;
            z-index: 1;
        }
        .id-card-hook {
            width: 70px;
            margin: 0 auto;
            height: 15px;
            border-radius: 5px 5px 0 0;
            background-color: #000;
        }
        .id-card-hook:after {
            width: 47px;
            height: 6px;
            display: block;
            top: 6px;
            border-radius: 4px;
        }
        .id-card-tag-strip {
            width: 45px;
            height: 40px;
            background-color: #0950ef;
            margin: 0 auto;
            border-radius: 5px;
            top: 9px;
            border: 1px solid #0041ad;
        }
        .id-card-tag-strip:after {
            width: 100%;
            height: 1px;
            background-color: #c1c1c1;
            top: 10px;
        }
        .id-card-tag {
            width: 0;
            height: 0;
            border-left: 100px solid transparent;
            border-right: 100px solid transparent;
            border-top: 100px solid #0958db;
            margin: -10px auto -30px auto;
        }
        .id-card-tag:after {
            width: 0;
            height: 0;
            border-left: 50px solid transparent;
            border-right: 50px solid transparent;
            border-top: 100px solid #d7d6d3;
            margin: -10px auto -30px auto;
            top: -130px;
            left: -50px;
        }
        .id-details h3, .id-details h4 {
            font-size: 12px;
        }
        .id-details h4 {
            font-size: 10px;
        }
        .verified-logo {
            width: 10px;
            margin: 10px auto;
        }
      .tech img {
    width: 200px; /* Set the desired width */
    height: auto; /* Maintain the aspect ratio */
         margin-top:-10px;
            margin-left: -2%;
}

    </style>
</head>
<body>

<div class="form-container">
    <form method="post" action="idcard.php">
        <input type="text" name="memid" placeholder="Enter Member ID" required>
        <input type="submit" value="Search">
    </form>
</div>


<div class="id-card-hook"></div>
<div class="id-card-holder">
    <div class="id-card">
        <div class="header">
            <img src="b.png" alt="Logo">
        </div>
        <div class="photo">
            <img src="<?php echo isset($photo_path) ? $photo_path : 'default-photo.jpg'; ?>" alt="User Photo">
        </div>
        <h2><?php echo isset($first_name) && isset($last_name) ? $first_name . " " . $last_name : 'Name'; ?></h2>
        <div class="id-details">
            <h3><?php echo isset($memid) ? 'Member ID: ' . $memid : 'Member ID'; ?></h3>
            <h4><?php echo isset($email) ? 'Email: ' . $email : 'Email'; ?></h4>
        </div>
        <div class="tech">
            <img src="verify.png" alt="Verified">
        </div>
        <h3>www.spacscec.free.nf</h3>
        <hr>
        <p><strong>"SPACS CEC"</strong>Pallipuram P.O Cherthala</p>
        <p>Near Thavanakadavu, Alappuzha Kerala, India <strong>695033</strong></p>
        <p>Ph: 9995226831 | E-mail: spacscectal@gmail.com</p>
    </div>
</div>

<?php if (isset($user_found) && !$user_found): ?>
    <p>User not found.</p>
<?php endif; ?>

</body>
</html>
