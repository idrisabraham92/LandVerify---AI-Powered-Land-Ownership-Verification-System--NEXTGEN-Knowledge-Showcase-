<?php
session_start();

if(!isset($_SESSION['admin'])){
header("Location: login.php");
exit();
}

include "../config/database.php";

/* HANDLE STATUS UPDATE */
if(isset($_GET['action']) && isset($_GET['id'])){
$id = intval($_GET['id']);
$action = $_GET['action'];

if($action == "approve"){
$status = "verified";
}elseif($action == "reject"){
$status = "rejected";
}elseif($action == "fraud"){
$status = "fraud";
}

mysqli_query($conn,"UPDATE properties SET status='$status' WHERE id=$id");
header("Location: properties.php");
exit();
}

/* HANDLE FOR SALE TOGGLE */
if(isset($_GET['toggle_sale']) && isset($_GET['id'])){
$id = intval($_GET['id']);

$res = mysqli_query($conn,"SELECT for_sale FROM properties WHERE id=$id");
$data = mysqli_fetch_assoc($res);

$new_status = ($data['for_sale'] == 'yes') ? 'no' : 'yes';

mysqli_query($conn,"UPDATE properties SET for_sale='$new_status' WHERE id=$id");
header("Location: properties.php");
exit();
}

/* FETCH PROPERTIES */
$result = mysqli_query($conn,"SELECT * FROM properties ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Properties</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

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

/* TABLE */
.table-container{
background:white;
padding:20px;
border-radius:15px;
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

<a href="dashboard.php">
<i class="bi bi-speedometer2"></i> Dashboard
</a>

<a href="properties.php" class="active">
<i class="bi bi-building"></i> Properties
</a>

<a href="logout.php">
<i class="bi bi-box-arrow-right"></i> Logout
</a>

</div>

<!-- MAIN -->
<div class="main">

<div class="d-flex justify-content-between align-items-center mb-4">

<h3>Manage Properties</h3>

<a href="dashboard.php" class="btn btn-secondary btn-sm">
<i class="bi bi-arrow-left"></i> Back
</a>

</div>

<div class="table-container shadow-sm">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-dark">
<tr>
<th>#</th>
<th>Property ID</th>
<th>Owner</th>
<th>City</th>
<th>Status</th>
<th>For Sale</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['property_id']; ?></td>

<td><?php echo $row['owner_name']; ?></td>

<td><?php echo $row['city']; ?></td>

<!-- STATUS -->
<td>
<?php
$status = $row['status'];

if($status == "verified"){
echo "<span class='badge bg-success'>Verified</span>";
}elseif($status == "rejected"){
echo "<span class='badge bg-danger'>Rejected</span>";
}elseif($status == "fraud"){
echo "<span class='badge bg-warning text-dark'>Fraud</span>";
}else{
echo "<span class='badge bg-secondary'>Pending</span>";
}
?>
</td>

<!-- FOR SALE -->
<td>
<?php
if($row['for_sale'] == 'yes'){
echo "<span class='badge bg-success'>Yes</span>";
}else{
echo "<span class='badge bg-secondary'>No</span>";
}
?>
</td>

<!-- ACTIONS -->
<td>

<div class="d-flex flex-wrap gap-2">

<a href="?action=approve&id=<?php echo $row['id']; ?>" 
class="btn btn-success btn-sm"
title="Approve"
onclick="return confirm('Approve this property?')">
<i class="bi bi-check"></i>
</a>

<a href="?action=reject&id=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm"
title="Reject"
onclick="return confirm('Reject this property?')">
<i class="bi bi-x"></i>
</a>

<a href="?action=fraud&id=<?php echo $row['id']; ?>" 
class="btn btn-warning btn-sm"
title="Mark Fraud"
onclick="return confirm('Mark as fraud?')">
<i class="bi bi-exclamation-triangle"></i>
</a>

<a href="?toggle_sale=1&id=<?php echo $row['id']; ?>" 
class="btn btn-info btn-sm"
title="Toggle Sale"
onclick="return confirm('Change sale status?')">
<i class="bi bi-arrow-repeat"></i>
</a>

<a href="view_property.php?id=<?php echo $row['id']; ?>" 
class="btn btn-dark btn-sm"
title="View">
<i class="bi bi-eye"></i>
</a>

</div>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>