<?php
session_start();
include '../db.php';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($res) > 0) {

        $row = mysqli_fetch_assoc($res);

        if (password_verify($pass, $row['password'])) {

            // ✅ store session
            $_SESSION['user'] = $email;
            $_SESSION['user_id'] = $row['user_id']; // 🔥 important

            header("Location: ../index.php");
            exit();

        } else {
            echo "<script>alert('Wrong Password');</script>";
        }

    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<div class="form-container">

<h1>Login</h1>

<form method="post">

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password" placeholder="Password" required>

    <button name="login">Login</button>

</form>

<br>

<a href="register.php">
    <button>Go to Register</button>
</a>

</div>

</body>
</html>
