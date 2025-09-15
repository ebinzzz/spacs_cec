<!DOCTYPE html>
<html lang="en">

<head>
      <style>
    /* Basic styles for the button */
.btn-getstarted {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* Position the dropdown container */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Hide the dropdown content initially */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 10px;
}

/* Style the dropdown links */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}
header.header {
  margin-top: 0 !important;
  top: 0;
  z-index: 999;
}


/* Show the dropdown content when hovering over the dropdown container */
.dropdown:hover .dropdown-content {
    display: block;
    border-radius: 10px;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
    background-color: #f1f1f1;
    border-radius: 10px;
}

  </style>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Spacs Cectl</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: May 13 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>


<body class="service-details-page">


  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="../index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">SPACS CEC</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../#hero" class="">Home</a></li>
          <li><a href="../#about">About</a></li>
          <li><a href="../#services">Services</a></li>
          <li><a href="event_list.php">Events</a></li>
          <li><a href="../#team">Team</a></li>
          <li><a href="../#pricing">Pricing</a></li>
         
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="dropdown">
        <button class="btn-getstarted">Sign in</button>
        <div class="dropdown-content">
            <a href="../login.html">Member Login</a>
            <a href="../spacs.html">Space Login</a>
        </div>
    </div>

    </div>
  </header>


<?php
// Database connection
@include 'config.php';


$sql = "SELECT id, event_name, poster, registration_last_date, registration_fee, prize_pool, description FROM events ORDER BY event_date ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPACS Events</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Inter', sans-serif;
  background-color: #f2f5f9;
  color: #333;
  padding: 0px 20px; /* Removed top padding */
  margin: 0; /* Ensure no default margin */
}

header.header {
  margin-top: 0 !important;
  top: 0;
  z-index: 999;
}

h1.title {
  text-align: center;
  font-size: 2.8rem;
  margin-bottom: 40px;
  color: #202124;
  font-weight: 600;
}

/* Grid container with 4 cards per row */
.events-container {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  max-width: 1300px;
  margin: auto;
}

/* Card styling */
.event-card {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: transform 0.3s ease;
  width: 100%;
}

.event-card:hover {
  transform: translateY(-4px);
}

.event-poster {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.event-info {
  padding: 20px;
}

.event-name {
  font-size: 1.3rem;
  font-weight: 600;
  color: #1a73e8;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.desc-icon {
  font-size: 0.95rem;
  color: #5f6368;
  cursor: pointer;
  margin-left: 8px;
}

.event-info p {
  font-size: 0.9rem;
  margin: 6px 0;
}

.register-button {
  display: inline-block;
  margin-top: 12px;
  padding: 10px 20px;
  background-color: #1a73e8;
  color: white;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 500;
  transition: background 0.3s;
}

.register-button:hover {
  background-color: #1558b0;
}

/* Modal styling */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.modal-content {
  background: #fff;
  max-width: 480px;
  width: 100%;
  padding: 30px;
  border-radius: 10px;
  position: relative;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  animation: fadeIn 0.3s ease;
}

.modal-content h3 {
  margin-bottom: 12px;
  color: #1a73e8;
}

.modal-content p {
  color: #444;
  line-height: 1.6;
  font-size: 0.95rem;
}

.close {
  position: absolute;
  top: 12px;
  right: 18px;
  font-size: 24px;
  cursor: pointer;
  color: #777;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

/* Responsive layout for tablets and mobile */
@media screen and (max-width: 1024px) {
  .events-container {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media screen and (max-width: 600px) {
  .events-container {
    grid-template-columns: 1fr;
  }
}

  </style>
</head>
<body>
<br>
<br>
<h1 class="title">Upcoming Events</h1>

<div class="events-container">
<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $event_name = htmlspecialchars($row['event_name']);
        $poster = htmlspecialchars($row['poster']);
        $last_date = date("F j, Y", strtotime($row['registration_last_date']));
        $fee = $row['registration_fee'] == 0 ? "Free" : "$" . number_format($row['registration_fee'], 2);
        $prize_pool = $row['prize_pool'] !== null ? "$" . number_format($row['prize_pool'], 2) : null;
        $description = htmlspecialchars($row['description']);
        $modal_id = "modal_" . $id;

        echo '
        <div class="event-card">
            <img src="uploads/posters/' . $poster . '" alt="' . $event_name . ' Poster" class="event-poster">
            <div class="event-info">
                <div class="event-name">
                    ' . $event_name . '
                    <span class="desc-icon" onclick="openModal(\'' . $modal_id . '\')">🛈</span>
                </div>
                <p><strong>Last Date:</strong> ' . $last_date . '</p>
                <p><strong>Fee:</strong> ' . $fee . '</p>';
                if ($prize_pool) {
                    echo '<p><strong>Prize Pool:</strong> ' . $prize_pool . '</p>';
                }
        echo '
<a href="event_register.php?event=' . $id . '" class="register-button">Register</a>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="' . $modal_id . '">
            <div class="modal-content">
                <span class="close" onclick="closeModal(\'' . $modal_id . '\')">&times;</span>
                <h3>' . $event_name . '</h3>
                <p>' . nl2br($description) . '</p>
            </div>
        </div>';
    }
} else {
    echo "<p style='text-align:center; font-size:1.2rem;'>No events available.</p>";
}
mysqli_close($conn);
?>
</div>

<script>
  function openModal(id) {
    document.getElementById(id).style.display = 'flex';
  }
  function closeModal(id) {
    document.getElementById(id).style.display = 'none';
  }
  window.onclick = function(e) {
    if (e.target.classList.contains('modal')) {
      e.target.style.display = 'none';
    }
  };
</script>

</body>
</html>

<footer id="footer" class="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
            <form action="forms/newsletter.php" method="post" class="php-email-form">
              <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your subscription request has been sent. Thank you!</div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">CECTL</span>
          </a>
          <div class="footer-contact pt-3">
            <p>College of engineering Cherthala</p>
            <p>Pallipuram P.O Cherthala Alappuzha</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+91 984 626 1894</span></p>
            <p><strong>Email:</strong> <span>spacscectl@gmail.com</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
          </ul>
        </div>

  <div class="col-lg-2 col-md-3 footer-links">
  <h4>Our Services</h4>
  <ul>
    <li><i class="bi bi-chevron-right"></i> <a href="#">Computer Programming Contest</a></li>
    <li><i class="bi bi-chevron-right"></i> <a href="#">Seminars on IT Related Subjects</a></li>
    <li><i class="bi bi-chevron-right"></i> <a href="#">Workshops on Programming and Managerial Skills</a></li>
    <li><i class="bi bi-chevron-right"></i> <a href="#">Career Guidance in IT Industry</a></li>
  </ul>
</div>


     <div class="col-lg-4 col-md-12">
  <h4>Follow Us</h4>
  <p>Stay updated with our latest news and events.</p>
  <div class="social-links d-flex">
    <a href="#"><i class="bi bi-twitter"></i></a>
    <a href="#"><i class="bi bi-facebook"></i></a>
    <a href="#"><i class="bi bi-instagram"></i></a>
    <a href="#"><i class="bi bi-linkedin"></i></a>
  </div>
</div>


      </div>
      <p>please follow our <a href="terms.html">  Our Terms and Conditions</a>,<a href="refund.html">  Cancellation & Refund Policy</a></p>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SPACS CEC</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="www.cectl.ac.in">CEC</a>
      </div>
    </div>
    <br>
    <br>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>