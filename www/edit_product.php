<?php
require_once 'config.php';
session_start();

// 🔥 No CSRF protection, any attacker can trick an admin into modifying products
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    die("Access Denied. <a href='index.php'>Go back</a>");
}

// 🔥 No prepared statement here (SQL Injection)
if (!isset($_GET["id"])) {
    die("Invalid Product ID");
}

$id = $_GET["id"]; // ❌ Directly using GET parameter (SQL Injection)
$result = $conn->query("SELECT * FROM products WHERE id = $id"); 
$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $image = $product["image"];

    // 🔥 No file type validation (RCE risk)
    if (!empty($_FILES["image"]["name"])) {
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);
    }

    // 🔥 SQL Injection vulnerability (no prepared statement)
    $query = "UPDATE products SET name='$name', price='$price', quantity='$quantity', image='$image' WHERE id=$id";
    $conn->query($query); // ❌ Query executed directly

    header("Location: admin.php?message=Product+updated+successfully");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="name" value="<?= $product["name"] ?>" required><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?= $product["price"] ?>" required><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $product["quantity"] ?>" required><br>

        <label>Upload Image:</label>
        <input type="file" name="image"><br>

        <button type="submit">Update Product</button>
    </form>

    <a href="admin.php">Back</a>
</body>
</html>
