<?php
session_start();
include "../config/database.php";

$message = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if($password == $user['password']){
            $_SESSION['admin'] = $user['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid password";
        }
    } else {
        $message = "Admin not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(to right, #0d6efd, #6610f2);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    height: 100vh;
}

.container {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    overflow: hidden;
}

.card-header {
    font-weight: bold;
    font-size: 1.3rem;
}

.card-body {
    padding: 2rem;
}

.form-control:focus {
    border-color: #6610f2;
    box-shadow: 0 0 0 0.2rem rgba(102,16,242,0.25);
}

.btn-primary {
    background: #6610f2;
    border: none;
}

.btn-primary:hover {
    background: #520dc2;
}

.alert {
    font-size: 0.9rem;
    padding: 0.7rem 1rem;
}

.brand {
    text-align: center;
    margin-bottom: 1rem;
    color: #fff;
}

.brand h1 {
    font-size: 2rem;
    font-weight: 700;
}

.brand p {
    font-size: 0.9rem;
    color: #e2e6ea;
}
</style>
</head>

<body>
<div class="container">
    <div class="col-md-4">

        <div class="brand">
            <h1>LandVerify</h1>
            <p>Secure Admin Access</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-header text-center bg-dark text-white">
                Admin Login
            </div>
            <div class="card-body">
                <?php if($message){ ?>
                    <div class="alert alert-danger"><?php echo $message ?></div>
                <?php } ?>

                <form method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="********" required>
                    </div>
                    <button name="login" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>