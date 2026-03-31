<?php
session_start();

if(!isset($_SESSION['admin'])){
header("Location: login.php");
exit();
}

include "../config/database.php";

$total_properties = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM properties"));
$total_documents = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM documents"));
?>

<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* LAYOUT */
body{
background:#f4f6f9;
}

/* SIDEBAR */
.sidebar{
height:100vh;
background:#212529;
color:white;
padding:20px;
position:fixed;
width:220px;
}

.sidebar a{
color:#adb5bd;
display:block;
padding:10px;
text-decoration:none;
border-radius:5px;
}

.sidebar a:hover,
.sidebar a.active{
background:#0d6efd;
color:white;
}

/* MAIN */
.main{
margin-left:220px;
padding:20px;
}

/* CARDS */
.dashboard-card{
border:none;
border-radius:15px;
transition:0.3s;
}

.dashboard-card:hover{
transform:translateY(-5px);
box-shadow:0 10px 20px rgba(0,0,0,0.1);
}

.icon-box{
font-size:30px;
}

/* MOBILE */
@media(max-width:768px){
.sidebar{
position:relative;
width:100%;
height:auto;
}

.main{
margin-left:0;
}
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<h4 class="mb-4">LandVerify</h4>

<a href="dashboard.php" class="active">
<i class="bi bi-speedometer2"></i> Dashboard
</a>

<a href="properties.php">
<i class="bi bi-building"></i> Properties
</a>

<a href="logout.php">
<i class="bi bi-box-arrow-right"></i> Logout
</a>

</div>

<!-- MAIN CONTENT -->
<div class="main">

<div class="d-flex justify-content-between align-items-center mb-4">

<h3>Dashboard</h3>

<span class="text-muted">Welcome Admin</span>

</div>

<div class="row g-4">

<!-- TOTAL PROPERTIES -->
<div class="col-md-6 col-lg-4">

<div class="card dashboard-card shadow-sm p-3">

<div class="d-flex justify-content-between align-items-center">

<div>
<h4><?php echo $total_properties ?></h4>
<p class="mb-0 text-muted">Total Properties</p>
</div>

<div class="icon-box text-primary">
<i class="bi bi-building"></i>
</div>

</div>

</div>

</div>

<!-- TOTAL DOCUMENTS -->
<div class="col-md-6 col-lg-4">

<div class="card dashboard-card shadow-sm p-3">

<div class="d-flex justify-content-between align-items-center">

<div>
<h4><?php echo $total_documents ?></h4>
<p class="mb-0 text-muted">Uploaded Documents</p>
</div>

<div class="icon-box text-success">
<i class="bi bi-file-earmark-text"></i>
</div>

</div>

</div>

</div>

</div>

<!-- ACTION BUTTON -->
<div class="mt-4">

<a href="properties.php" class="btn btn-primary">
<i class="bi bi-gear"></i> Manage Properties
</a>

</div>

</div>

</body>
</html>