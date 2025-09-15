<?php
if (isset($_GET['memid'])) {
    $userId = $_GET['memid'];
} else {
    // Redirect or handle the case where memid is not set
    header("Location: error.php"); // Redirect to an error page or show an error message
    exit();
}
?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<div class="container mt-5 px-5">
    <div class="mb-4">
        <h2>Confirm order and submit</h2>
        <span>please make the payment through online mode and upload the details, once admin approves you can access your profile.</span>
    </div>
    <form action="submit_payment.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3">
                    <h6 class="text-uppercase">Payment details</h6>
                    <div class="inputbox mt-3">
                        <input type="text" name="paymentId" class="form-control" required="required">
                        <span>Payment ID / Referral ID</span>
                    </div>
                    <div class="inputbox mt-3">
                    <label>Date of Payment</label>
                        <input type="date" name="paymentDate" class="form-control" required="required">
                       
                    </div>
                    <div class="inputbox mt-3">
                    <label for="bankName">Bank Name</label>
    <select name="bankName" id="bankName" class="form-control" required="required">
        <option value="">Select Bank</option>
        <option value="State Bank of India">State Bank of India</option>
        <option value="HDFC Bank">HDFC Bank</option>
        <option value="ICICI Bank">ICICI Bank</option>
        <option value="Axis Bank">Axis Bank</option>
        <option value="Punjab National Bank">Punjab National Bank</option>
        <option value="Federal Bank">Federal Bank</option>
              <option value="Other">Other</option>
        <!-- Add more options as needed -->
    </select>
                    </div>
                    <div class="inputbox mt-3">
                        <input type="text" name="recipientName" class="form-control" required="required">
                        <span>Remitter's Name</span>
                    </div>
                    <div class="inputbox mt-3">
                        <input type="text" name="phoneNumber" class="form-control" required="required">
                        <span>Phone Number</span>
                    </div>
                    <div class="inputbox mt-3">
                    <label>Upload Proof of Payment</label>
                        <input type="file" name="paymentProof" class="form-control" required="required">
                 
                    </div>
                </div>
                <div class="mt-4 mb-4 d-flex justify-content-between">
                    <span>Previous step</span>
                    <button type="submit" class="btn btn-success px-3">Submit Payment Details</button>
                </div>
            </div>
           <div class="col-md-4">
    <div class="card card-blue p-3 text-white mb-3">
        <span>You have to pay</span>
        <div class="d-flex flex-row align-items-end mb-3">
            <h1 class="mb-0 yellow">Rs.100</h1> <span>.00</span>
        </div>
        <span>Enjoy all the features and perks after you complete the payment</span>
        <a href="#" class="yellow decoration">Know all the features</a>
        <div class="highlight">
            <span>100% Guaranteed support and updates for the next 3 years.</span>
        </div>
        <div class="mt-3 text-center">
            <span>Scan the QR code below to complete your payment</span>
            <div class="mt-2">
                <img src="gpay.jpg" alt="Payment QR Code" class="img-fluid">
            </div>
        </div>
    </div>
</div>

        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


      <style>
body{

background-color: #eee;
}

.container{

height: 100vh;
.text-center {
    text-align: center;
}

.mt-2 {
    margin-top: 10px;
}

.mt-3 {
    margin-top: 20px;
}

}


.card{
border:none;
}

.form-control {
border-bottom: 2px solid #eee !important;
border: none;
font-weight: 600
}

.form-control:focus {
color: #495057;
background-color: #fff;
border-color: #8bbafe;
outline: 0;
box-shadow: none;
border-radius: 0px;
border-bottom: 2px solid blue !important;
}



.inputbox {
position: relative;
margin-bottom: 20px;
width: 100%
}

.inputbox span {
position: absolute;
top: 7px;
left: 11px;
transition: 0.5s
}

.inputbox i {
position: absolute;
top: 13px;
right: 8px;
transition: 0.5s;
color: #3F51B5
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
-webkit-appearance: none;
margin: 0
}

.inputbox input:focus~span {
transform: translateX(-0px) translateY(-15px);
font-size: 12px
}

.inputbox input:valid~span {
transform: translateX(-0px) translateY(-15px);
font-size: 12px
}

.card-blue{

background-color: #492bc4;
}

.hightlight{

background-color: #5737d9;
padding: 10px;
border-radius: 10px;
margin-top: 15px;
font-size: 14px;
}

.yellow{

color: #fdcc49; 
}

.decoration{

text-decoration: none;
font-size: 14px;
}

.btn-success {
color: #fff;
background-color: #492bc4;
border-color:#492bc4;
}

.btn-success:hover {
color: #fff;
background-color:#492bc4;
border-color: #492bc4;
}


.decoration:hover{

text-decoration: none;
color: #fdcc49; 
}
        </style>