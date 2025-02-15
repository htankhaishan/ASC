<?php

require_once 'config.php'; // Include database connection
$conn = new mysqli("db", "root", "root", "owasp_demo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $newPassword = "password123"; // Hardcoded weak password

    // No proper user verification (OWASP A7)
    $sql = "UPDATE users SET password='$newPassword' WHERE email='$email'";
    $conn->query($sql);
    echo "<p style='color:red;'>Password reset! New password: password123</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Reset Password</button>
    </form>

    <h3>Exploit:</h3>
    <p>No verification! Anyone can reset passwords by entering an email.</p>
</body>
</html>

<?php $conn->close(); ?>
