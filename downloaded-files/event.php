
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
.navmenu a {
    color: blue;
}
.header{
    background-color:blue;
}
#header {
    background-color: grey;
}


  </style>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Spacs Cectl</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: May 13 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <meta name="google-site-verification" content="_2xHjnDnyBirK-OdK357TbNXDepSgPaCGyfm6ZYDroA" />
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center color-blue">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">SPACS CEC</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="">Home</a></li>
          <li><a href="#about">About</a></li>
            <li><a href="idcard.php">Search Members</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <li><a href="#team">Team</a></li>
          <li><a href="#pricing">Pricing</a></li>
         
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="dropdown">
        <button class="btn-getstarted">Sign in</button>
        <div class="dropdown-content">
            <a href="login.html">Member Login</a>
            <a href="spacs.html">Space Login</a>
        </div>
    </div>

    </div>
  </header>
  
<div class="main">
    <h1>Responsive Card Grid Layout</h1>
    <ul class="cards">
      <li class="cards_item">
        <div class="card">
          <div class="card_image"><img src="https://picsum.photos/500/300/?image=10"></div>
          <div class="card_content">
            <h2 class="card_title">Card Grid Layout</h2>
            <p class="card_text">Demo of pixel perfect pure CSS simple responsive card grid layout</p>
            <button class="btn card_btn">Read More</button>
          </div>
        </div>
      </li>
      <li class="cards_item">
        <div class="card">
          <div class="card_image"><img src="https://picsum.photos/500/300/?image=5"></div>
          <div class="card_content">
            <h2 class="card_title">Card Grid Layout</h2>
            <p class="card_text">Demo of pixel perfect pure CSS simple responsive card grid layout</p>
            <button class="btn card_btn">Read More</button>
          </div>
        </div>
      </li>
      <li class="cards_item">
        <div class="card">
          <div class="card_image"><img src="https://picsum.photos/500/300/?image=11"></div>
          <div class="card_content">
            <h2 class="card_title">Card Grid Layout</h2>
            <p class="card_text">Demo of pixel perfect pure CSS simple responsive card grid layout</p>
            <button class="btn card_btn">Read More</button>
          </div>
        </div>
      </li>
      <li class="cards_item">
        <div class="card">
          <div class="card_image"><img src="https://picsum.photos/500/300/?image=14"></div>
          <div class="card_content">
            <h2 class="card_title">Card Grid Layout</h2>
            <p class="card_text">Demo of pixel perfect pure CSS simple responsive card grid layout</p>
            <button class="btn card_btn">Read More</button>
          </div>
        </div>
      </li>
      <li class="cards_item">
        <div class="card">
          <div class="card_image"><img src="https://picsum.photos/500/300/?image=17"></div>
          <div class="card_content">
            <h2 class="card_title">Card Grid Layout</h2>
            <p class="card_text">Demo of pixel perfect pure CSS simple responsive card grid layout</p>
            <button class="btn card_btn">Read More</button>
          </div>
        </div>
      </li>
      <li class="cards_item">
        <div class="card">
          <div class="card_image"><img src="https://picsum.photos/500/300/?image=2"></div>
          <div class="card_content">
            <h2 class="card_title">Card Grid Layout</h2>
            <p class="card_text">Demo of pixel perfect pure CSS simple responsive card grid layout</p>
            <button class="btn card_btn">Read More</button>
          </div>
        </div>
      </li>
    </ul>
  </div>
  
  <h3 class="made_by">Made with ♡</h3>
  <style>
    /* Font */
@import url('https://fonts.googleapis.com/css?family=Quicksand:400,700');

/* Design */
*,
*::before,
*::after {
  box-sizing: border-box;
}

html {
  background-color: #ecf9ff;
}

body {
  color: #272727;
  font-family: 'Quicksand', serif;
  font-style: normal;
  font-weight: 400;
  letter-spacing: 0;
  padding: 1rem;
}

.main{
  max-width: 1200px;
  margin: 0 auto;
  margin-top:15%;
}

h1 {
    font-size: 24px;
    font-weight: 400;
    text-align: center;
}

img {
  height: auto;
  max-width: 100%;
  vertical-align: middle;
}

.btn {
  color: #ffffff;
  padding: 0.8rem;
  font-size: 14px;
  text-transform: uppercase;
  border-radius: 4px;
  font-weight: 400;
  display: block;
  width: 100%;
  cursor: pointer;
  border: 1px solid rgba(255, 255, 255, 0.2);
  background: transparent;
}

.btn:hover {
  background-color: rgba(255, 255, 255, 0.12);
}

.cards {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  margin: 0;
  padding: 0;
}

.cards_item {
  display: flex;
  padding: 1rem;
}

@media (min-width: 40rem) {
  .cards_item {
    width: 50%;
  }
}

@media (min-width: 56rem) {
  .cards_item {
    width: 33.3333%;
  }
}

.card {
  background-color: white;
  border-radius: 0.25rem;
  box-shadow: 0 20px 40px -14px rgba(0, 0, 0, 0.25);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.card_content {
  padding: 1rem;
  background: linear-gradient(to bottom left, #EF8D9C 40%, #FFC39E 100%);
}

.card_title {
  color: #ffffff;
  font-size: 1.1rem;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: capitalize;
  margin: 0px;
}

.card_text {
  color: #ffffff;
  font-size: 0.875rem;
  line-height: 1.5;
  margin-bottom: 1.25rem;    
  font-weight: 400;
}
.made_by{
  font-weight: 400;
  font-size: 13px;
  margin-top: 35px;
  text-align: center;
}
  </style>