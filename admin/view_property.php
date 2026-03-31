<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../config/database.php";

if(!isset($_GET['id'])){
    header("Location: properties.php");
    exit();
}

$id = intval($_GET['id']);

/* FETCH PROPERTY */
$property = mysqli_query($conn,"SELECT * FROM properties WHERE id=$id");
$prop = mysqli_fetch_assoc($property);

/* FETCH DOCUMENT */
$doc = mysqli_query($conn,"SELECT * FROM documents WHERE property_id='".$prop['property_id']."'");
$document = mysqli_fetch_assoc($doc);

/* =========================
   FRAUD RISK CALCULATION
========================= */

$risk = 0;

/* 1. OCR vs Owner Check */
if($document){
    if(stripos($document['ocr_text'], $prop['owner_name']) === false){
        $risk += 40;
    }
}else{
    $risk += 30;
}

/* 2. Duplicate Address Check */
$dup_query = mysqli_query($conn,
"SELECT COUNT(*) as total FROM properties 
WHERE address='".$prop['address']."' AND id != $id");

$dup = mysqli_fetch_assoc($dup_query);

if($dup['total'] > 0){
    $risk += 30;
}

/* Risk Label */
if($risk >= 70){
    $risk_label = "<span class='badge bg-danger'>High Risk</span>";
}elseif($risk >= 40){
    $risk_label = "<span class='badge bg-warning text-dark'>Medium Risk</span>";
}else{
    $risk_label = "<span class='badge bg-success'>Low Risk</span>";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Property</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: #f4f6f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* SIDEBAR */
.sidebar {
    height: 100vh;
    background: #212529;
    color: white;
    padding: 20px;
    position: fixed;
    width: 220px;
}

.sidebar a {
    color: #adb5bd;
    display: block;
    padding: 10px;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 5px;
}

.sidebar a:hover,
.sidebar a.active {
    background: #0d6efd;
    color: white;
}

/* MAIN */
.main {
    margin-left: 220px;
    padding: 20px;
}

/* CARDS */
.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* BADGES */
.badge {
    font-size: 0.9em;
}

/* BUTTONS */
.btn {
    min-width: 100px;
}

/* MOBILE */
@media(max-width:768px){
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }
    .main {
        margin-left: 0;
    }
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="mb-4">LandVerify</h4>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="properties.php" class="active"><i class="bi bi-building"></i> Properties</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Property Details</h3>
    <a href="properties.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<!-- PROPERTY INFORMATION -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        Property Information
    </div>
    <div class="card-body">
        <p><strong>Property ID:</strong> <?php echo $prop['property_id']; ?></p>
        <p><strong>Owner:</strong> <?php echo $prop['owner_name']; ?></p>
        <p><strong>Agent:</strong> <?php echo $prop['agent_name']; ?></p>
        <p><strong>Address:</strong> <?php echo $prop['address']; ?></p>
        <p><strong>City:</strong> <?php echo $prop['city']; ?></p>
        <p><strong>State:</strong> <?php echo $prop['state']; ?></p>
        <p><strong>Plot Size:</strong> <?php echo $prop['plot_size']; ?></p>
        <p><strong>Title Type:</strong> <?php echo $prop['title_type']; ?></p>
        
        <p><strong>Status:</strong> 
        <?php
        $status = $prop['status'];
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
        </p>

        <p><strong>For Sale:</strong> 
        <?php
        if($prop['for_sale'] == 'yes'){
            echo "<span class='badge bg-success'>Yes</span>";
        }else{
            echo "<span class='badge bg-secondary'>No</span>";
        }
        ?>
        </p>

        <p><strong>Fraud Risk Score:</strong> <?php echo $risk; ?>% <?php echo $risk_label; ?></p>
    </div>
</div>

<!-- DOCUMENT SECTION -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        Uploaded Document
    </div>
    <div class="card-body">
    <?php if($document){ ?>
        <p><strong>Document Type:</strong> <?php echo $document['document_type']; ?></p>
        <a href="../<?php echo $document['file_path']; ?>" target="_blank" class="btn btn-sm btn-dark mb-3">
            <i class="bi bi-file-earmark-text"></i> View Document
        </a>
        <p><strong>OCR Extracted Text:</strong></p>
        <div style="max-height:200px; overflow:auto; background:#f8f9fa; padding:10px; border-radius:5px">
            <?php echo nl2br($document['ocr_text']); ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">No document uploaded</div>
    <?php } ?>
    </div>
</div>

<!-- ACTION BUTTONS -->
<div class="d-flex flex-wrap gap-2 justify-content-center mb-5">
    <a href="properties.php?action=approve&id=<?php echo $prop['id']; ?>" class="btn btn-success" onclick="return confirm('Approve this property?')">
        <i class="bi bi-check"></i> Approve
    </a>
    <a href="properties.php?action=reject&id=<?php echo $prop['id']; ?>" class="btn btn-danger" onclick="return confirm('Reject this property?')">
        <i class="bi bi-x"></i> Reject
    </a>
    <a href="properties.php?action=fraud&id=<?php echo $prop['id']; ?>" class="btn btn-warning" onclick="return confirm('Mark as fraud?')">
        <i class="bi bi-exclamation-triangle"></i> Fraud
    </a>
</div>

</div>
</body>
</html>