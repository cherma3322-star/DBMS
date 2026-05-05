<?php
session_start();
include '../db.php';

if (isset($_POST['register'])) {

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 🔍 check user already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already exists');</script>";
    } else {

        mysqli_query($conn, "INSERT INTO users(name,email,password)
        VALUES('$name','$email','$pass')");

        // ✅ auto login after register
        $_SESSION['user'] = $email;

        echo "<script>alert('Registered Successfully');</script>";
        echo "<script>window.location='../index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<div class="form-container">

<h1>Register</h1>

<form method="post">

    <input type="text" name="name" placeholder="Name" required>

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password" placeholder="Password" required>

    <button name="register">Register</button>

</form>

<br>

<a href="login.php">
    <button>Go to Login</button>
</a>

</div>

</body>
</html>
