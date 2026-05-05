<?php
session_start();
include '../db.php';

// 🔐 login check
if(!isset($_SESSION['user'])){
    header("Location: ../user/login.php");
    exit();
}

// items fetch
$res = mysqli_query($conn, "SELECT * FROM items ORDER BY item_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Items</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<!-- 🔓 Logout Button -->
<div style="position:absolute; top:20px; right:20px;">
    <a href="../user/logout.php">
        <button>Logout</button>
    </a>
</div>

<div class="items-container">

<?php while($row = mysqli_fetch_assoc($res)){ ?>

    <div class="item-box">

        <!-- 🖼️ IMAGE -->
        <img src="../images/<?php echo $row['image']; ?>" alt="Item Image">

        <!-- 📝 TITLE -->
        <h3><?php echo $row['title']; ?></h3>

        <!-- 💰 PRICE -->
        <p><b>₹<?php echo $row['starting_price']; ?></b></p>

        <!-- 🏷️ CATEGORY -->
        <p><?php echo $row['category']; ?></p>

        <!-- 📅 DATE -->
        <p style="font-size:12px;">
            <?php echo $row['created_at']; ?>
        </p>

        <!-- 🔗 VIEW BUTTON -->
        <a href="item.php?id=<?php echo $row['item_id']; ?>">
            <button>View Item</button>
        </a>

    </div>

<?php } ?>

</div>

</body>
</html>
