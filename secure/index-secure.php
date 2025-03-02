<?php
// Secure index page - Demonstrating Secure Practices

// Include necessary files, for example, for database connection and session handling
include('config.php');  // For database connection (make sure it's secured)

session_start();

// Ensure user is logged in (basic check)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit();
}

// Fetch products securely
$query = $mysqli->prepare("SELECT id, name, price FROM products");
$query->execute();
$result = $query->get_result();

// Fetch all products in a secure way
$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Product Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Product List</h1>
        <ul class="list-group">
            <?php foreach ($products as $product): ?>
                <li class="list-group-item">
                    <?= htmlspecialchars($product['name']) ?> - $<?= htmlspecialchars($product['price']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>