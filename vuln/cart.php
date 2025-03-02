<?php
session_start();
$mysqli = new mysqli("mysql", "root", "root", "ecommerce");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Ensure a test user exists
$mysqli->query("INSERT INTO users (id, username, password, email) VALUES (1, 'testuser', 'password', 'test@example.com') ON DUPLICATE KEY UPDATE id=id;");

// Check the product_id from POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Check if product exists in the products table
    $check_product = $mysqli->query("SELECT id FROM products WHERE id = $product_id");

    // If no product found, display an error message and stop the script
    if ($check_product->num_rows == 0) {
        die("Invalid product ID.");
    }

    // Insert into cart if product exists
    if (!$mysqli->query("INSERT INTO cart (user_id, product_id) VALUES (1, $product_id)")) {
        die("Insert Error: " . $mysqli->error);
    }
}

// Fetch cart items
$cart_items = $mysqli->query("SELECT products.name, products.price FROM cart JOIN products ON cart.product_id = products.id");

// Debugging: Check if query failed
if (!$cart_items) {
    die("Query Error: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Your Cart</h1>
        
        <?php if ($cart_items->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($item = $cart_items->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($item['name']) ?> - $<?= htmlspecialchars($item['price']) ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

        <div class="mt-3">
            <a href="checkout.php" class="btn btn-primary">Checkout</a>
        </div>

        <br>
        <div>
            <h2>Add Item to Cart (IDOR)</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="product_id" class="form-label">Product ID:</label>
                    <input type="number" id="product_id" name="product_id" class="form-control" required placeholder="Enter Product ID">
                </div>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>

    </div>

    <!-- Bootstrap JS (optional for additional functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>