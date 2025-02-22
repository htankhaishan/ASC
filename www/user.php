<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION["user"])) {
    echo "<p style='color:red;'>Unauthorized access! Redirecting to login...</p>";
    header("refresh:2;url=login.php"); // No immediate redirect, gives time for exploitation
    exit();
}

// 🔥 Users can see other users' data (OWASP A1)
echo "<h2>Welcome, {$_SESSION["user"]}!</h2>";
echo "<h3>Your Orders:</h3>";

$user = $_SESSION["user"];
$result = $conn->query("SELECT * FROM orders WHERE user_id = (SELECT id FROM users WHERE username='$user')");
while ($row = $result->fetch_assoc()) {
    echo "<p>Order ID: {$row['id']} | Product ID: {$row['product_id']} | Quantity: {$row['quantity']} | Total: \${$row['total_price']}</p>";
}

// 🔥 Exposed User Data (No proper access control)
echo "<h3>All Users (Visible to Everyone!)</h3>";
$result = $conn->query("SELECT username, email FROM users");
while ($row = $result->fetch_assoc()) {
    echo "<p>Username: {$row['username']} | Email: {$row['email']}</p>";
}
?>