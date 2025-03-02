<?php
// Secure checkout page

include('config.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit();
}

// Fetch the user's cart items securely
$user_id = $_SESSION['user_id'];
$query = $mysqli->prepare("SELECT cart.product_id, products.name, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
$query->bind_param("i", $user_id);  // Securely bind the user ID
$query->execute();
$result = $query->get_result();

// Fetch all cart items
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

// Calculate the total price of the cart
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'];
}

// Handle checkout (order creation) logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Example order processing
    $order_query = $mysqli->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
    $order_query->bind_param("id", $user_id, $total_price);  // Bind user ID and total price
    $order_query->execute();

    // Clear the user's cart after placing the order
    $mysqli->query("DELETE FROM cart WHERE user_id = $user_id");

    echo "Your order has been placed successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Checkout</h1>
        
        <?php if (count($cart_items) > 0): ?>
            <ul class="list-group">
                <?php foreach ($cart_items as $item): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($item['name']) ?> - $<?= htmlspecialchars($item['price']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h4>Total: $<?= htmlspecialchars($total_price) ?></h4>

            <form method="post">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>