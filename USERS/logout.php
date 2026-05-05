<?php
session_start();

$_SESSION = [];
session_unset();
session_destroy();

header("Cache-Control: no-cache, must-revalidate");
header("Location: ../index.php");
exit();
?>
