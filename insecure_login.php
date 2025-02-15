<?php
session_start();
require_once 'config.php'; // Include database connection
if (isset($_GET["username"]) && isset($_GET["password"])) {
    $username = $_GET["username"];
    $password = $_GET["password"];

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
    <title>Insecure Login</title>
</head>
<body>
    <h2>Insecure Login</h2>
    <p>Login using the URL: <code>?username=admin&password=password123</code></p>
    <form method="GET">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="text" name="password" required><br> <!-- OWASP A2: Credentials exposed -->
        <button type="submit">Login</button>
    </form>
</body>
</html>
