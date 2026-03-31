<?php
include "config/database.php";
include "phpqrcode/qrlib.php";
require_once __DIR__ . '/vendor/autoload.php';

use thiagoalessio\TesseractOCR\TesseractOCR;

$message = "";

if(isset($_POST['submit'])){

$owner_name = $_POST['owner_name'];
$agent_name = $_POST['agent_name'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$plot_size = $_POST['plot_size'];
$title_type = $_POST['title_type'];

$property_id = "LV-" . strtoupper(substr($city,0,3)) . "-" . rand(1000,9999);

/* DUPLICATE CHECK */
$check = "SELECT * FROM properties WHERE address='$address'";
$result = mysqli_query($conn,$check);

if(mysqli_num_rows($result) > 0){

$message = "<div class='alert alert-warning text-center'>⚠ This property may already be registered.</div>";

}else{

$query = "INSERT INTO properties
(property_id,owner_name,agent_name,address,city,state,plot_size,title_type)
VALUES
('$property_id','$owner_name','$agent_name','$address','$city','$state','$plot_size','$title_type')";

if(mysqli_query($conn,$query)){

$verify_link = "http://localhost/landverify/verify.php?property_id=".$property_id;
$qr_file = "uploads/qrcodes/".$property_id.".png";

QRcode::png($verify_link,$qr_file);

/* DOCUMENT UPLOAD */
$ocr_text = "";

if(isset($_FILES['land_document']) && $_FILES['land_document']['error'] == 0){

$ext = pathinfo($_FILES['land_document']['name'], PATHINFO_EXTENSION);
$new_doc_name = $property_id.".".$ext;
$doc_path = "uploads/documents/".$new_doc_name;

move_uploaded_file($_FILES['land_document']['tmp_name'],$doc_path);

try{
$ocr_text = (new TesseractOCR($doc_path))->run();
}catch(Exception $e){
$ocr_text = "OCR failed";
}

$doc_query = "INSERT INTO documents
(property_id,document_type,file_path,ocr_text)
VALUES
('$property_id','$title_type','$doc_path','$ocr_text')";

mysqli_query($conn,$doc_query);

if(stripos($ocr_text,$owner_name) === false){
$message .= "<div class='alert alert-warning text-center mt-2'>
⚠ Owner name not found in uploaded document.
</div>";
}
}

$message .= "
<div class='alert alert-success text-center'>
<h5>Property Registered Successfully!</h5>
<p><strong>Property ID:</strong> $property_id</p>

<p><strong>QR Code:</strong></p>
<img src='$qr_file' width='150' class='mb-3'>

<p><strong>Extracted Document Text:</strong></p>
<div style='max-height:150px;overflow:auto;background:#f8f9fa;padding:10px;border-radius:5px'>
$ocr_text
</div>
</div>
";

}else{
$message = "<div class='alert alert-danger text-center'>Error registering property.</div>";
}

}

}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Register Property | LandVerify</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* HERO */
.form-header{
background: linear-gradient(135deg, #0d6efd, #0dcaf0);
color:white;
padding:60px 20px;
text-align:center;
}

/* FORM CARD */
.form-card{
border:none;
border-radius:15px;
}

/* INPUT FOCUS */
.form-control:focus{
box-shadow:none;
border-color:#0d6efd;
}

/* MOBILE */
@media(max-width:576px){
.form-header{
padding:40px 15px;
}
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
<div class="container">

<a class="navbar-brand fw-bold" href="index.php">LandVerify</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="index.php">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="verify.php">Verify Property</a>
</li>

<li class="nav-item">
<a class="nav-link active" href="register.php">Register Property</a>
</li>

</ul>
</div>

</div>
</nav>

<!-- HEADER -->
<section class="form-header">
<h2 class="fw-bold"><i class="bi bi-building-add"></i> Register Property</h2>
<p class="mt-2">Secure your land and prevent fraud</p>
</section>

<!-- FORM -->
<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<?php echo $message; ?>

<div class="card form-card shadow p-4">

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Owner Name</label>
<input type="text" name="owner_name" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Agent Name</label>
<input type="text" name="agent_name" class="form-control">
</div>

</div>

<div class="mb-3">
<label class="form-label">Property Address</label>
<input type="text" name="address" class="form-control" required>
</div>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">City</label>
<input type="text" name="city" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">State</label>
<input type="text" name="state" class="form-control" required>
</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Plot Size</label>
<input type="text" name="plot_size" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Title Type</label>
<select name="title_type" class="form-control">
<option>Certificate of Occupancy</option>
<option>Deed of Assignment</option>
<option>Survey Plan</option>
</select>
</div>

</div>

<div class="mb-3">
<label class="form-label">Upload Land Document</label>
<input type="file" name="land_document" class="form-control" required>
</div>

<div class="text-center mt-4">

<button type="submit" name="submit" class="btn btn-primary btn-lg px-5">
<i class="bi bi-check-circle"></i> Register Property
</button>

</div>

</form>

</div>

</div>

</div>

</div>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-5">

<p class="mb-0">© <?php echo date("Y"); ?> LandVerify</p>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>