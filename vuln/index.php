<?php
// index.php - Home Page (Vulnerable Web App)
session_start();
$mysqli = new mysqli("mysql", "root", "root", "ecommerce");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Modify the query to exclude 'Product X'
$products = $mysqli->query("SELECT * FROM products WHERE name != 'Product X'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Vulnerable E-Commerce</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Welcome to Vulnerable E-Commerce</h1>
        
        <!-- Product List -->
        <h2>Products</h2>
        <ul class="list-group">
            <?php while ($row = $products->fetch_assoc()): ?>
                <li class="list-group-item">
                    <a href="product.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?> - $<?= htmlspecialchars($row['price']) ?></a>
                </li>
            <?php endwhile; ?>
        </ul>

        <!-- Cart Link -->
        <div class="mt-3">
            <a href="cart.php" class="btn btn-primary">View Cart</a>
        </div>

        <!-- Upload Button -->
        <div class="mt-3">
            <a href="upload.php" class="btn btn-success">Upload</a>
        </div>
    </div>

    <!-- Bootstrap JS (optional for additional functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>