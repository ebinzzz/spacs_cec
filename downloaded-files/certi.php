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

if (isset($_GET['memid'])) {
    $userId = $_GET['memid'];
} else {
    // Redirect or handle the case where memid is not set
    header("Location: error.php"); // Redirect to an error page or show an error message
    exit();
}

$sql = "SELECT *
        FROM users
        WHERE id='$userId' and profile='com'";

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
$memid=$row['memid'];
$registration_date=$row['registration_date'];


    }
}else{
    echo '<script>alert("profile incomplete!");</script>';
    header("Location: profile.php?memid=$userId"); // Redirect to an error page or show an error message
    exit;
}
$formatted_date = date("F j, Y", strtotime($registration_date));

// Output the formatted date

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Certificate</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="certificate">
        <div class="header">
            <img class="college-logo" src="cece.png" alt="College Logo">
            <h1>Membership Certificate</h1>
            <img class="space-logo" src="logo.png" alt="Space Logo">
        </div>
        <div class="content">
            <p>This is to certify that</p>
            <h2> <?php echo" $name1 $name2"; ?></h2>
            <p>is a distinguished member of</p>
            <h3>SPACS CEC, College of Engineering Cherthala</h3>
            <p> <?php echo" $name1 "; ?> has consistently demonstrated a commitment to excellence and active participation within the club. His dedication and contribution have greatly enriched our community. We are proud to acknowledge his efforts and accomplishments.</p>
        </div>
        
        <div class="additional-info">
            <p>Certificate Number: <strong><?php echo" $memid"; ?></strong></p>
            <p>Date of Issue: <strong><?php echo" $formatted_date"; ?></strong></p>
        </div>
        <div class="signatures">
            <div class="signature-block">
                <img class="signature" src="chairman_signature.png" alt="Chairman Signature">
                <p class="name">EBIN BENNY</p>
                <p>Chairman</p>

            </div>
            <div class="signature-block">
                <img class="signature1" src="anitha.png" alt="Program Officer Signature">
                <p class="name">ANITHA M A</p>
                <p>Program Officer</p>
                
            </div>
        </div>
        <div class="footer">
            <img class="seal" src="seal.png" alt="Official Seal">
        </div>
    </div>
    <div class="print-button-container">
        <button id="printButton">Print Certificate</button>
    </div>

</html>
<script>
    // Function to handle printing
    function printCertificate() {
        // Hide the print button during printing
        var printButton = document.getElementById('printButton');
        printButton.style.display = 'none';

        // Set the title for the print document
        document.title = 'Membership Certificate for John Doe'; // Replace 'John Doe' with the actual name

        // Trigger the print dialog
        window.print();

        // Reset the document title after printing (optional)
        setTimeout(function() {
            document.title = 'Membership Certificate'; // Reset to original title
            printButton.style.display = 'block'; // Show the print button
        }, 1000); // 1000 milliseconds (1 second) delay
    }

    // Attach the function to the button click event
    var button = document.getElementById('printButton');
    button.addEventListener('click', printCertificate);
</script>



<style>

.print-button-container {
    text-align: center; /* Center align the button */
    margin-bottom: 1rem; /* Adjust margin as needed */
}

#printButton {
    padding: 1rem 2rem; /* Add padding to the button */
    font-size: 1.2rem; /* Adjust font size */
    background-color: #007bff; /* Button background color */
    color: white; /* Button text color */
    border: none; /* Remove button border */
    cursor: pointer;
}

#printButton:hover {
    background-color: #0056b3; /* Hover background color */
}
  body {
    font-family: 'Georgia', serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.certificate {
    width: 80%;
    max-width: 900px;
    background-color: white;
    padding: 2rem;
    border: 10px solid #d3d3d3;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    position: relative;
    background: url('images (3).jpg') no-repeat center center / cover;
    background-blend-mode: overlay;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header img {
    height: 120px;
}

.header .space-logo {
    height: 90px;
}

h1 {
    font-size: 2.5rem;
    text-align: center;
    margin: 0;
    font-family: 'Times New Roman', Times, serif;
    color: #333;
}

h2 {
    font-size: 2rem;
    text-align: center;
    margin: 0.5rem 0;
    font-family: 'Arial', sans-serif;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

h3 {
    font-size: 1.5rem;
    text-align: center;
    margin: 1rem 0;
    font-family: 'Arial', sans-serif;
    color: #777;
    font-weight: bold;
}

.content {
    text-align: center;
    margin-bottom: 2rem;
}

.additional-info {
    text-align: center;
    margin-bottom: 2rem;
    font-family: 'Courier New', Courier, monospace;
    font-size: 1rem;
    color: #444;
}

.signatures {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
}

.signature-block {
    text-align: center;
    width: 45%; /* Adjust width to balance spacing */
}

.signature-block img.signature {
    height: 50px;
    margin-bottom: 0.3rem; /* Add margin for space between image and text */
}

.signature-block img.signature1 {
    height: 100px;
    margin-bottom: -1.0rem; /* Add margin for space between image and text */
    margin-top: -1.9rem; /* Add margin for space between image and text */

}

.signature-block .name {
    font-weight: bold;
    margin-top: 0.2rem;
    color: #333;
    font-size: 1rem;
}

.footer {
    text-align: center;
    
}

.footer p {
    margin-bottom: -1.9rem;
    font-size: 1rem;
    color: #333;
}

.footer .seal {
    height: 120px;
    margin-bottom: -1.9rem;
    margin-top: -4.9rem;
}

@media (max-width: 768px) {
    .certificate {
        padding: 1rem;
    }

    .header img {
        height: 60px;
    }

    h1 {
        font-size: 2rem;
    }

    h2 {
        font-size: 1.5rem;
    }

    h3 {
        font-size: 1.2rem;
    }

    .signature-block img.signature {
        height: 40px;
    }

    .footer .seal {
        height: 30px;
    }
}


    </style>