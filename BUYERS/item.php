<?php
session_start();
include '../db.php';

// 🔐 login check
if(!isset($_SESSION['user'])){
    header("Location: ../user/login.php");
    exit();
}

// 👉 get user_id
$email = $_SESSION['user'];
$user_res = mysqli_query($conn, "SELECT user_id FROM users WHERE email='$email'");
$user_row = mysqli_fetch_assoc($user_res);
$user_id = $user_row['user_id'];

// 👉 get item id safely
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// item details
$res = mysqli_query($conn, "SELECT * FROM items WHERE item_id=$id");
$row = mysqli_fetch_assoc($res);

if(!$row){
    echo "Item not found";
    exit();
}

// highest bid
$bid_res = mysqli_query($conn,
"SELECT MAX(bid_amount) AS max_bid FROM bids WHERE item_id=$id");

$bid_row = mysqli_fetch_assoc($bid_res);
$highest_bid = $bid_row['max_bid'];

// 🏆 winner name
$winner_res = mysqli_query($conn,
"SELECT users.name 
 FROM bids 
 JOIN users ON bids.user_id = users.user_id
 WHERE bids.item_id=$id
 ORDER BY bids.bid_amount DESC
 LIMIT 1");

$winner_row = mysqli_fetch_assoc($winner_res);
$winner_name = $winner_row['name'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Item Details</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<div class="form-container">

<h1><?php echo $row['title']; ?></h1>

<img src="../images/<?php echo $row['image']; ?>" width="250">

<p><b>Starting Price:</b> ₹<?php echo $row['starting_price']; ?></p>

<p><b>Category:</b> <?php echo $row['category']; ?></p>

<p><b>Posted:</b> <?php echo $row['created_at']; ?></p>

<p><b>Current Time:</b> <?php echo date("d-m-Y H:i:s"); ?></p>

<p><b>Highest Bid:</b> ₹<?php echo $highest_bid ? $highest_bid : "No bids yet"; ?></p>

<!-- 🏆 Winner or Running -->
<?php
if(isset($row['auction_end']) && date("Y-m-d H:i:s") > $row['auction_end']){
    echo "<p><b>Winner:</b> " . ($winner_name ? $winner_name : "No bids") . "</p>";
} else {
    echo "<p><b>Status:</b> Auction Running...</p>";
}
?>

<hr>

<h3>Place Bid</h3>

<form method="post">
    <input type="number" name="bid" required>
    <button name="submit">Bid</button>
</form>

</div>

</body>
</html>

<?php
// 💰 BIDDING LOGIC
if(isset($_POST['submit'])){

    // auction ended check
    if(isset($row['auction_end']) && date("Y-m-d H:i:s") > $row['auction_end']){
        echo "<script>alert('Auction Ended');</script>";
        exit();
    }

    $bid = $_POST['bid'];

    if($highest_bid){
        if($bid > $highest_bid){
            mysqli_query($conn,
            "INSERT INTO bids(item_id,user_id,bid_amount)
             VALUES('$id','$user_id','$bid')");

            echo "<script>alert('Bid Placed'); window.location='item.php?id=$id';</script>";
        } else {
            echo "<script>alert('Enter higher bid');</script>";
        }
    } else {
        if($bid >= $row['starting_price']){
            mysqli_query($conn,
            "INSERT INTO bids(item_id,user_id,bid_amount)
             VALUES('$id','$user_id','$bid')");

            echo "<script>alert('First Bid Added'); window.location='item.php?id=$id';</script>";
        } else {
            echo "<script>alert('Bid must be greater than starting price');</script>";
        }
    }
}
?>
