<?php
require_once 'config.php'; // Include database connection
session_start();
$conn = new mysqli("db", "root", "root", "owasp_demo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Simulated logged-in user (no session validation)
$_SESSION['user_id'] = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['email'];

    // No CSRF protection! (OWASP A9)
    $sql = "UPDATE users SET email='$new_email' WHERE id=" . $_SESSION['user_id'];
    $conn->query($sql);

    echo "<p>Email updated successfully!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Demo</title>
</head>
<body>
    <h2>Change Email</h2>
    <form method="POST">
        <label>New Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Update</button>
    </form>

    <h3>CSRF Exploit:</h3>
    <p>Another website can auto-submit this form to change your email without consent.</p>
</body>
</html>

<?php $conn->close(); ?>
