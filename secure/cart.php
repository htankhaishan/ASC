<?php
session_start();
$mysqli = new mysqli("secure_mysql", "root", "root", "ecommerce");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Ensure a user exists
$stmt = $mysqli->prepare("INSERT INTO users (id, username, password, email) 
                          VALUES (1, 'testuser', 'password', 'test@example.com') 
                          ON DUPLICATE KEY UPDATE id=id;");
$stmt->execute();

// Ensure user is logged in (Replace with real authentication check)
$user_id = 1; // Simulating a logged-in user

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Secure: Use Prepared Statements to prevent SQL injection and Blacklisting Product
    $stmt = $mysqli->prepare("SELECT id FROM products WHERE id = ? AND name != 'Product X'");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Secure: Ensure product is not restricted (prevents IDOR)
    if ($result->num_rows === 0) {
        die("Invalid product ID or unauthorized access.");
    }

    // Secure: Use Prepared Statements to insert into cart
    $stmt = $mysqli->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $product_id);
    
    if (!$stmt->execute()) {
        die("Insert Error: " . $stmt->error);
    }
}

// Fetch cart items securely
$stmt = $mysqli->prepare("SELECT products.name, products.price FROM cart 
                          JOIN products ON cart.product_id = products.id 
                          WHERE cart.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();
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
            <h2>Add Item to Cart</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="product_id" class="form-label">Product ID:</label>
                    <input type="number" id="product_id" name="product_id" class="form-control" required placeholder="Enter Product ID">
                </div>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
