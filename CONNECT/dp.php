<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "auction_db";

$conn = mysqli_connect($host, $user, $pass, $db);

//  Connection error
if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Optional: set charset (important for text)
mysqli_set_charset($conn, "utf8");
?>
