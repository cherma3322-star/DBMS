<?php
session_start();
include '../db.php';

// 🔐 login check
if(!isset($_SESSION['user'])){
    header("Location: ../user/login.php");
    exit();
}

// 👉 get user_id from email
$email = $_SESSION['user'];
$res_user = mysqli_query($conn, "SELECT user_id FROM users WHERE email='$email'");
$user_row = mysqli_fetch_assoc($res_user);
$user_id = $user_row['user_id'];

if(isset($_POST['add'])){

    $title = $_POST['title'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // image check
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

        $image = time() . "_" . basename($_FILES['image']['name']);
        $tmp = $_FILES['image']['tmp_name'];

        // upload image
        if(move_uploaded_file($tmp, "../images/" . $image)){

            // 🕒 created time
            $date = date("Y-m-d H:i:s");

            // ⏳ auction end (1 day later)
            $auction_end = date("Y-m-d H:i:s", strtotime("+1 day"));

            // 🔥 insert query
            $query = "INSERT INTO items(title,starting_price,image,category,created_at,user_id,auction_end)
                      VALUES('$title','$price','$image','$category','$date','$user_id','$auction_end')";

            if(mysqli_query($conn,$query)){
                echo "<script>alert('Item Added Successfully'); window.location='../buyer/items.php';</script>";
            } else {
                echo "DB Error: " . mysqli_error($conn);
            }

        } else {
            echo "<script>alert('Image upload failed');</script>";
        }

    } else {
        echo "<script>alert('Please select image');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Item</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<!-- 🔓 Logout -->
<div style="position:absolute; top:20px; right:20px;">
    <a href="../user/logout.php">
        <button>Logout</button>
    </a>
</div>

<div class="form-container">

<h1>Add Item</h1>

<form method="post" enctype="multipart/form-data">

    <input type="text" name="title" placeholder="Item Name" required>

    <input type="number" name="price" placeholder="Starting Price" required>

    <select name="category" required>
        <option value="">Category</option>
        <option>Electronics</option>
        <option>Fashion</option>
        <option>Home</option>
        <option>Vehicles</option>
    </select>

    <input type="file" name="image" required>

    <button name="add">Add Item</button>

</form>

</div>

</body>
</html>
