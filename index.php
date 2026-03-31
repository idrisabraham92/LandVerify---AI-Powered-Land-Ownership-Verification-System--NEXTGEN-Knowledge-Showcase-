<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>LandVerify</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
background:#f8f9fa;
}

/* HERO */
.hero{
background: url('bg_img.png') center/cover no-repeat;
color:white;
padding:100px 20px;
text-align:center;
position: relative;
z-index: 1;
}

/* Dark overlay for readability */
.hero::before{
content: "";
position: absolute;
top:0;
left:0;
width:100%;
height:100%;
background: rgba(0,0,0,0.55);
z-index: -1;
}

.hero h1{
font-size:2.2rem;
}
.hero h1,
.hero p{
text-shadow: 0 2px 8px rgba(0,0,0,0.6);
}

@media(max-width:576px){
.hero{
padding:80px 15px;
}
}
@media(min-width:768px){
.hero h1{
font-size:3rem;
}
}

/* FEATURE CARDS */
.feature-card{
border:none;
border-radius:15px;
transition:0.3s;
}

.feature-card:hover{
transform:translateY(-5px);
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.feature-icon{
font-size:40px;
color:#0d6efd;
}

/* CTA */
.cta{
background:#0d6efd;
color:white;
border-radius:15px;
padding:40px 20px;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
<div class="container">

<a class="navbar-brand fw-bold" href="#">LandVerify</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link active" href="index.php">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="verify.php">Verify Property</a>
</li>

<li class="nav-item">
<a class="nav-link" href="register.php">Register Property</a>
</li>

</ul>
</div>

</div>
</nav>

<!-- HERO SECTION -->
<section class="hero">

<div class="container">

<h1 class="fw-bold">Verify Land Before You Buy</h1>

<p class="lead mt-3">
Stop land fraud and duplicate sales with smart verification.
</p>

<div class="mt-4 d-flex flex-column flex-md-row justify-content-center gap-3">

<a href="verify.php" class="btn btn-light btn-lg px-4">
<i class="bi bi-search"></i> Verify Property
</a>

<a href="register.php" class="btn btn-warning btn-lg px-4">
<i class="bi bi-plus-circle"></i> Register Property
</a>

</div>

</div>

</section>

<!-- FEATURES -->
<section class="py-5">

<div class="container">

<h2 class="text-center mb-5 fw-bold">Why Use LandVerify?</h2>

<div class="row g-4">

<div class="col-12 col-md-4">

<div class="card feature-card h-100 text-center p-4 shadow-sm">

<div class="feature-icon mb-3">
<i class="bi bi-shield-check"></i>
</div>

<h5>Property Verification</h5>

<p>
Quickly confirm ownership before making any land purchase.
</p>

</div>

</div>

<div class="col-12 col-md-4">

<div class="card feature-card h-100 text-center p-4 shadow-sm">

<div class="feature-icon mb-3">
<i class="bi bi-exclamation-triangle"></i>
</div>

<h5>Fraud Detection</h5>

<p>
Identify duplicate listings and suspicious transactions instantly.
</p>

</div>

</div>

<div class="col-12 col-md-4">

<div class="card feature-card h-100 text-center p-4 shadow-sm">

<div class="feature-icon mb-3">
<i class="bi bi-qr-code"></i>
</div>

<h5>QR Verification</h5>

<p>
Each property gets a QR code for fast and secure validation.
</p>

</div>

</div>

</div>

</div>

</section>

<!-- CTA SECTION -->
<section class="py-5">

<div class="container">

<div class="cta text-center shadow">

<h3 class="fw-bold">Protect Your Property Transactions</h3>

<p class="mt-3">
Register your property or verify ownership in seconds.
</p>

<a href="register.php" class="btn btn-light btn-lg mt-3">
Get Started
</a>

</div>

</div>

</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-5">

<p class="mb-0">
© <?php echo date("Y"); ?> LandVerify | Secure Land Transactions
</p>

</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>