<?php
// Secure cart page

include('config.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch cart items securely
$user_id = $_SESSION['user_id'];
$query = $mysqli->prepare("SELECT products.name, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
$query->bind_param("i", $user_id);  // Securely bind the user ID
$query->execute();
$result = $query->get_result();

// Fetch cart items
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Secure Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Your Cart</h1>
        <?php if (count($cart_items) > 0): ?>
            <ul class="list-group">
                <?php foreach ($cart_items as $item): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($item['name']) ?> - $<?= htmlspecialchars($item['price']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
        <div class="mt-3">
            <a href="checkout-secure.php" class="btn btn-primary">Checkout</a>
        </div>
    </div>
</body>
</html>