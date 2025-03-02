<?php
// Secure product page

include('config.php');
session_start();

// Check if the product_id is valid and secure
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    die("Invalid product ID.");
}

$product_id = (int)$_GET['product_id'];  // Secure the product ID by casting it to an integer

// Fetch the product details securely
$query = $mysqli->prepare("SELECT id, name, description, price FROM products WHERE id = ?");
$query->bind_param("i", $product_id);  // Securely bind the product ID
$query->execute();
$result = $query->get_result();

// Check if the product exists
if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><?= htmlspecialchars($product['name']) ?></h1>
        <p><strong>Description:</strong> <?= htmlspecialchars($product['description']) ?></p>
        <p><strong>Price:</strong> $<?= htmlspecialchars($product['price']) ?></p>

        <form action="cart-secure.php" method="post">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
    </div>
</body>
</html>