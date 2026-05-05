<?php
session_start();
include '../db.php';

// 🔐 Only admin access
if(!isset($_SESSION['user'])){
    header("Location: ../user/login.php");
    exit();
}

// 👉 simple admin check (change email if needed)
if($_SESSION['user'] != "admin@gmail.com"){
    echo "Access Denied";
    exit();
}

// 🗑️ DELETE ITEM
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM items WHERE item_id=$id");
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<div class="container">

<h1>🛠️ Admin Panel</h1>

<a href="../index.php"><button>🏠 Home</button></a>
<a href="../user/logout.php"><button>🚪 Logout</button></a>

<hr>

<h2>📦 All Items</h2>

<?php
$res = mysqli_query($conn, "SELECT * FROM items");

while($row = mysqli_fetch_assoc($res)){
?>

<div class="item-box">

    <h3><?php echo $row['title']; ?></h3>

    <img src="../images/<?php echo $row['image']; ?>" width="150">

    <p>₹<?php echo $row['starting_price']; ?></p>

    <a href="admin.php?delete=<?php echo $row['item_id']; ?>">
        <button>❌ Delete</button>
    </a>

</div>

<?php } ?>

<hr>

<h2>👤 All Users</h2>

<?php
$res2 = mysqli_query($conn, "SELECT * FROM users");

while($u = mysqli_fetch_assoc($res2)){
?>

<div class="item-box">

    <p><b>Name:</b> <?php echo $u['name']; ?></p>
    <p><b>Email:</b> <?php echo $u['email']; ?></p>

</div>

<?php } ?>

</div>

</body>
</html>
