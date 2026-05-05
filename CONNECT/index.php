<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Auction</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="form-container">

<h1>🛍️ Online Auction</h1>

<?php if(isset($_SESSION['user'])) { ?>

    <!-- ✅ USER LOGGED IN -->
    <p style="color:white;">
        Welcome, <?php echo $_SESSION['user']; ?> 👋
    </p>

    <!-- 🛒 Buyer -->
    <a href="buyer/items.php">
        <button>🛒 Browse Items</button>
    </a>

    <!-- 🧑‍💼 Seller -->
    <a href="seller/add_item.php">
        <button>➕ Add Item</button>
    </a>

    <!-- 🛠️ Admin (optional) -->
    <?php if($_SESSION['user'] == "admin@gmail.com") { ?>
        <a href="admin/admin.php">
            <button>🛠️ Admin Panel</button>
        </a>
    <?php } ?>

    <!-- 🚪 Logout -->
    <a href="user/logout.php">
        <button>🚪 Logout</button>
    </a>

<?php } else { ?>

    <!-- ❌ USER NOT LOGGED IN -->

    <a href="user/login.php">
        <button>🔐 Login</button>
    </a>

    <a href="user/register.php">
        <button>📝 Register</button>
    </a>

<?php } ?>

</div>

</body>
</html>
