<?php
ini_set('memory_limit', '512M');
ini_set('post_max_size', '500M');

session_start();
$mysqli = new mysqli("mysql", "root", "root", "ecommerce");

// 🚨 Vulnerability: Command Injection (CVE-2023-5678)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    shell_exec("echo 'Order confirmed for $email' >> orders.txt"); // No input validation
    $order_placed = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Checkout</h1>
        
        <?php if (isset($order_placed) && $order_placed): ?>
            <h2 class="text-success text-center">Order Placed!</h2>
            <div class="text-center">
                <a href="index.php"><button class="btn btn-secondary">Return to Main Menu</button></a>
            </div>
        <?php else: ?>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (optional for additional functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>