<?php
ini_set('memory_limit', '512M');
ini_set('post_max_size', '500M');

session_start(); 
$order_placed = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize the email input to remove unwanted characters and prevent code injection attacks.
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    // Validate the sanitized email to ensure it is in a correct and safe format.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Display an error message if the email is not valid.
        echo "<div class='alert alert-danger'>Invalid email address!</div>";
    } else {
        // htmlspecialchars() prevents XSS attacks by converting characters like "<" and ">" to HTML entities.
        $order_details = "Order confirmed for " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "\n";

        // Define a secure path for the orders.txt file inside the current directory.
        $file_path = __DIR__ . "/orders.txt";
        file_put_contents($file_path, $order_details, FILE_APPEND | LOCK_EX);
        // chmod 0600 ensures only the owner can read and write, preventing unauthorized access.
        if (!file_exists($file_path)) {
            chmod($file_path, 0600);
        }
        // Mark the order as successfully placed.
        $order_placed = true;
    }
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
        <h1 class="text-center">Secure Checkout</h1>
        
        <?php if ($order_placed): ?>
            <h2 class="text-success text-center">Order Placed Successfully!</h2>
            <div class="text-center">
                <a href="index.php"><button class="btn btn-secondary">Return to Main Menu</button></a>
            </div>
        <?php else: ?>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
