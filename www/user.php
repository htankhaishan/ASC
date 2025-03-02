<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION["user"]) || !isset($_SESSION["role"])) {
    echo "<p style='color:red;'>Unauthorized access! Redirecting to login...</p>";
    header("refresh:2;url=login.php");
    exit();
}

if ($_SESSION["role"] !== "user") { // ✅ Ensure only users can access
    die("<p style='color:red;'>Access denied. Admins cannot access this page.</p>");
}

echo "<h2>Welcome, {$_SESSION["user"]}!</h2>";
echo "<a href='user_dashboard.php'>Go to Dashboard</a>";
?>
