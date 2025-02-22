<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

if (!isset($_SESSION["user"]) || !isset($_SESSION["role"])) {
    die("Session variables not set. Please log in.");
}

if ($_SESSION["role"] !== 'admin') {
    die("Access denied: You are not an admin.");
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { padding: 20px; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .search-box { margin-left: 10px; }
    </style>
</head>
<body>

<div class="container admin-container">
    <div class="admin-header">
        <h2>Welcome to Admin Panel</h2>
        <a href="admin.php?logout=true" class="btn btn-danger">🚪 Logout</a>
    </div>
    <p><strong>Admin:</strong> <?php echo htmlspecialchars($_SESSION["user"]); ?></p>

    <?php if (isset($_GET["message"])) {
        echo "<div class='alert alert-success'>" . htmlspecialchars($_GET["message"]) . "</div>";
    } ?>

    <!-- Manage Users -->
    <h3>Manage Users</h3>
    <div class="d-flex align-items-center mb-3">
        <a href='add_user.php' class="btn btn-primary">➕ Add New User</a>
        <input type="text" id="searchUser" class="form-control search-box" placeholder="Search Users...">
    </div>
    <table class='table table-bordered' id="userTable">
        <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr>
        <?php
        $result = $conn->query("SELECT id, username, email, role FROM users");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['role']) . "</td>
                    <td>
                        <a href='edit_user.php?id=" . urlencode($row['id']) . "' class='btn btn-warning btn-sm'>✏️ Edit</a>
                        <a href='delete_users.php?id=" . urlencode($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>🗑️ Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
    
    <!-- Manage Products -->
    <h3>Manage Products</h3>
    <div class="d-flex align-items-center mb-3">
        <a href='add_product.php' class="btn btn-primary">➕ Add New Product</a>
        <input type="text" id="searchProduct" class="form-control search-box" placeholder="Search Products...">
    </div>
    <table class='table table-bordered' id="productTable">
        <tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Image</th><th>Actions</th></tr>
        <?php
        $result = $conn->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()) {
            echo "<tr id='row-" . htmlspecialchars($row['id']) . "'>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['price']) . " USD</td>
                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                    <td>";
            if (!empty($row['image'])) {
                echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' width='100'>";
            }
            echo "</td>
                    <td>
                        <a href='edit_product.php?id=" . urlencode($row['id']) . "' class='btn btn-warning btn-sm'>✏️ Edit</a>
                        <button class='btn btn-danger btn-sm delete-btn' data-id='" . htmlspecialchars($row['id']) . "'>🗑️ Delete</button>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#searchUser").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#userTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        $("#searchProduct").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#productTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });

    $(document).on("click", ".delete-btn", function() {
        var productId = $(this).data("id");
        if (confirm("Are you sure you want to delete this product?")) {
            $.ajax({
                url: "delete_product.php",
                type: "POST",
                data: { id: productId },
                success: function(response) {
                    alert(response);
                    $("#row-" + productId).fadeOut();
                }
            });
        }
    });
</script>

</body>
</html>
