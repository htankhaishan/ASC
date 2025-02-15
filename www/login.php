<?php
session_start();
require_once 'config.php'; // Include database connection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hardcoded credentials (OWASP A2: Cryptographic Failures)
    if ($username === "admin" && $password === "password123") {
        $_SESSION["user"] = $username;
        header("Location: admin.php");
        exit();
    } else {
        echo "<p style='color:red;'>Invalid login</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login Page</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
<!-- admin&password123 -->