<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}
?>

<h1>مرحبا بك في موقعك!</h1>
<p><a href="logout.php">تسجيل الخروج</a></p>
