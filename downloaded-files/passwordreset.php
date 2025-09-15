<?php
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

if(isset($_REQUEST['pwdrst']))
{
  $email = $_REQUEST['email'];
  $pwd = $_REQUEST['password'];
  $cpwd = $_REQUEST['cpwd'];
  if($pwd == $cpwd)
  {
    $hashed_pwd = password_hash($pwd, PASSWORD_BCRYPT);
    $reset_pwd = mysqli_query($conn, "update users set password='$hashed_pwd' where email='$email'");
    if($reset_pwd)
    {
      $msg = 'Your password updated successfully <a href="login.html">Click here</a> to login';
    }
    else
    {
      $msg = "Error while updating password.";
    }
  }
  else
  {
    $msg = "Password and Confirm Password do not match";
  }
}

if(isset($_GET['secret']))
{
  $email = base64_decode($_GET['secret']);
  $check_details = mysqli_query($conn, "select email from users where email='$email'");
  $res = mysqli_num_rows($check_details);
  if($res > 0)
    { ?>
<!DOCTYPE html>
<html>
<head>  
    <title>Password Reset</title>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #343a40;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .box {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
            color: #495057;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
            color: #495057;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            color: #ffffff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 20px;
            text-align: center;
        }

        a {
            color: #28a745;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">  
    <div class="table-responsive">  
    <h3 align="center">Reset Password</h3><br/>
    <div class="box">
     <form id="validate_form" method="post">  
      <input type="hidden" name="email" value="<?php echo $email; ?>"/>
      <div class="form-group">
       <label for="pwd">Password</label>
       <input type="password" name="password" id="pwd" placeholder="Enter Password" required 
       data-parsley-type="password" data-parsley-trigger="keyup" class="form-control"/>
      </div>
      <div class="form-group">
       <label for="cpwd">Confirm Password</label>
       <input type="password" name="cpwd" id="cpwd" placeholder="Enter Confirm Password" required data-parsley-type="cpwd" data-parsley-trigger="keyup" class="form-control"/>
      </div>
      <div class="form-group">
       <input type="submit" id="login" name="pwdrst" value="Reset Password" class="btn btn-success" />
       </div>
       
       <p class="error"><?php if(!empty($msg)){ echo $msg; } ?></p>
     </form>
     </div>
   </div>  
  </div>
</body>
</html>
<?php 
    } 
} 
?>
