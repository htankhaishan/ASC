<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($username === "admin" && $password === "wrongpass") {
        echo "<p>Invalid login.</p>";
        // No logging of failed attempts!
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>No Logging Example</title>
</head>
<body>
    <h2>Login (No Logging)</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>