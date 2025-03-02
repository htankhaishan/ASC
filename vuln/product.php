<?php
session_start();
$mysqli = new mysqli("mysql", "root", "root", "ecommerce");

// 🚨 No validation, still vulnerable to SQL Injection
$id = isset($_GET['id']) ? $_GET['id'] : 1; // Default to 1 if 'id' is missing

$product = $mysqli->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><?= htmlspecialchars($product['name']) ?></h1>
        
        <div class="row">
            <div class="col-md-6">
                <p><strong>Price:</strong> $<?= htmlspecialchars($product['price']) ?></p>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>
        </div>

        <!-- Add to Cart Form -->
        <form method="post" action="cart.php" class="mt-3">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>

        <!-- Back Link -->
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <!-- Bootstrap JS (optional for additional functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>