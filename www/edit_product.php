<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    die("Access Denied. <a href='index.php'>Go back</a>");
}

if (!isset($_GET["id"])) {
    die("Invalid Product ID");
}

$id = intval($_GET["id"]);
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $image = $product["image"];

    if (!empty($_FILES["image"]["name"])) {
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);
    }

    $query = "UPDATE products SET name=?, price=?, quantity=?, image=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdisi", $name, $price, $quantity, $image, $id);

    if ($stmt->execute()) {
        header("Location: admin.php?message=Product+updated+successfully");
        exit();
    }
}
?>

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