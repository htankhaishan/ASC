<?php
session_start();
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Store</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<div class="container mt-4">
    <!-- Top Bar: Welcome on Left, Login on Right -->
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Welcome to the Store</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    </div>

    <hr>

    <h3 class="mt-4">Available Products:</h3>
    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()) {
            echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>";
            echo "<div class='card h-100 text-center'>";
            if (!empty($row['image'])) {
                echo "<img src='uploads/{$row['image']}' class='card-img-top' alt='{$row['name']}'>";
            }
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$row['name']}</h5>";
            echo "<p class='card-text'>\${$row['price']} - Stock: {$row['quantity']}</p>";
            echo "</div></div></div>";
        }
        ?>
    </div>
</div>

<!-- ✅ Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <p id="loginMessage" class="text-danger mt-2"></p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ AJAX for Login -->
<p id="loginMessage" style="color:red;"></p> <!-- Error messages here -->

<script>
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    var formData = new FormData(this);

    fetch("login_process.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") {
            window.location.href = "admin.php"; // Redirect to admin page on success
        } else {
            document.getElementById("loginMessage").innerText = data; // Show error message
        }
    });
});
</script>

</body>
</html>