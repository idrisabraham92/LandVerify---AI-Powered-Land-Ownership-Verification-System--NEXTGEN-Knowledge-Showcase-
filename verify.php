<?php
include "config/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Verify Property | LandVerify</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* SEARCH HERO */
.search-section{
background: linear-gradient(135deg, #0d6efd, #0dcaf0);
color:white;
padding:80px 20px;
text-align:center;
}

.search-box{
max-width:500px;
margin:auto;
}

/* RESULT CARD */
.result-card{
border:none;
border-radius:15px;
overflow:hidden;
}

.result-card .card-header{
font-weight:bold;
}

/* LABELS */
.label{
font-weight:600;
color:#555;
}

.value{
font-weight:500;
}

/* MOBILE */
@media(max-width:576px){
.search-section{
padding:60px 15px;
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
<a class="nav-link active" href="verify.php">Verify Property</a>
</li>

<li class="nav-item">
<a class="nav-link" href="register.php">Register Property</a>
</li>

</ul>
</div>

</div>
</nav>

<!-- SEARCH SECTION -->
<section class="search-section">

<div class="container">

<h2 class="fw-bold">Verify Property Ownership</h2>

<p class="mt-2">Enter Property ID to confirm authenticity</p>

<form method="GET" class="mt-4 search-box">

<div class="input-group input-group-lg shadow">

<span class="input-group-text bg-white">
<i class="bi bi-search"></i>
</span>

<input 
type="text" 
name="property_id" 
class="form-control"
placeholder="Enter Property ID (e.g. LV-ABJ-1001)"
required>

<button class="btn btn-dark">
Verify
</button>

</div>

</form>

</div>

</section>

<?php

if(isset($_GET['property_id'])){

$property_id = $_GET['property_id'];

$query = "SELECT * FROM properties WHERE property_id='$property_id'";
$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result) > 0){

$row = mysqli_fetch_assoc($result);
?>

<div class="container mt-5">

<div class="card result-card shadow">

<div class="card-header bg-success text-white text-center">
<i class="bi bi-check-circle"></i> Property Verified
</div>

<div class="card-body">

<div class="row g-3">

<div class="col-md-6">
<p><span class="label">Property ID:</span><br><span class="value"><?php echo $row['property_id']; ?></span></p>
</div>

<div class="col-md-6">
<p><span class="label">Owner Name:</span><br><span class="value"><?php echo $row['owner_name']; ?></span></p>
</div>

<div class="col-md-6">
<p><span class="label">Agent Name:</span><br><span class="value"><?php echo $row['agent_name']; ?></span></p>
</div>

<div class="col-md-6">
<p><span class="label">Plot Size:</span><br><span class="value"><?php echo $row['plot_size']; ?></span></p>
</div>

<div class="col-md-6">
<p><span class="label">City:</span><br><span class="value"><?php echo $row['city']; ?></span></p>
</div>

<div class="col-md-6">
<p><span class="label">State:</span><br><span class="value"><?php echo $row['state']; ?></span></p>
</div>

<div class="col-12">
<p><span class="label">Address:</span><br><span class="value"><?php echo $row['address']; ?></span></p>
</div>

<div class="col-md-6">
<p><span class="label">Title Type:</span><br><span class="value"><?php echo $row['title_type']; ?></span></p>
</div>

<div class="col-md-6">
<p><span class="label">Registered On:</span><br><span class="value"><?php echo $row['created_at']; ?></span></p>
</div>

</div>

<hr>

<!-- STATUS -->
<p class="mt-3"><strong>Status:</strong> 
<?php
$status = $row['status'];

if($status == "verified"){
echo "<span class='badge bg-success'>Verified</span>";
}elseif($status == "rejected"){
echo "<span class='badge bg-danger'>Rejected</span>";
}elseif($status == "fraud"){
echo "<span class='badge bg-warning text-dark'>Fraud Alert</span>";
}else{
echo "<span class='badge bg-secondary'>Pending Verification</span>";
}
?>
</p>

<!-- FOR SALE -->
<p><strong>For Sale:</strong> 
<?php
if($row['for_sale'] == 'yes'){
echo "<span class='badge bg-success'>Available</span>";
}else{
echo "<span class='badge bg-secondary'>Not for Sale</span>";
}
?>
</p>

</div>

</div>

</div>

<?php

}else{
?>

<div class="container mt-5">

<div class="alert alert-danger text-center shadow">
<i class="bi bi-x-circle"></i> Property not found. Please check the Property ID.
</div>

</div>

<?php
}

}
?>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-5">

<p class="mb-0">
© <?php echo date("Y"); ?> LandVerify
</p>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>