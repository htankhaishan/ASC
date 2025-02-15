<?php
require_once 'config.php'; // Include database connection
$conn = new mysqli("localhost", "root", "", "owasp_demo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    
    // Vulnerability: Storing user input without sanitization
    $sql = "INSERT INTO products (name, price) VALUES ('$name', 0)";
    $conn->query($sql);
    echo "<p style='color:green;'>Product added: " . $name . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product (XSS Demo)</title>
</head>
<body>
    <h2>Add a Product</h2>
    <form method="POST">
        <label>Product Name:</label>
        <input type="text" name="name" required>
        <button type="submit">Add</button>
    </form>

    <h3>Example XSS Attack:</h3>
    <p>Try adding: <code>&lt;script&gt;alert('Hacked!')&lt;/script&gt;</code></p>
</body>
</html>

<?php $conn->close(); ?>
