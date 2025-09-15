<?php
// request_certificate.php

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

// Check if memid is provided via GET request
if (isset($_GET['memid'])) {
    $memid = intval($_GET['memid']);
  
    // Insert request into admin_requests table
   $check_stmt = $conn->prepare("SELECT COUNT(*) FROM admin_requests WHERE memid = ? AND status = 'pending'");
    $check_stmt->bind_param('i', $memid);
    $check_stmt->execute();
    $check_stmt->bind_result($request_count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($request_count == 0) {
        // Retrieve first name and last name of the user from the users table
        $user_stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
        $user_stmt->bind_param('i', $memid);
        $user_stmt->execute();
        $user_stmt->bind_result($first_name, $last_name);
        $user_stmt->fetch();
        $user_stmt->close();

        if ($first_name && $last_name) {
            // Concatenate first name and last name
            $full_name = $first_name . ' ' . $last_name;

            // Insert request into admin_requests table with memid and full_name
            $insert_stmt = $conn->prepare("INSERT INTO admin_requests (memid, name) VALUES (?, ?)");
            $insert_stmt->bind_param('is', $memid, $full_name);

            if ($insert_stmt->execute()) {
                echo "<script>
                        alert('Certificate request submitted successfully.');
                        window.location.href = 'profile.php?memid=$memid';
                      </script>";
            } else {
                echo "<script>
                        alert('Error: " . $insert_stmt->error . "');
                        window.location.href = 'profile.php?memid=$memid';
                      </script>";
            }

            $insert_stmt->close();
        } else {
            echo "<script>
                    alert('User not found.');
                  window.location.href = 'profile.php?memid=$memid';
                  </script>";
        }
    } else {
        echo "<script>
                alert('You have already requested a certificate.');
                window.location.href = 'profile.php?memid=$memid';
              </script>";
    }

    $conn->close();
} else {
    echo "<script>
            alert('No member ID provided.');
            window.location.href = 'profile.php';
          </script>";
}
?>