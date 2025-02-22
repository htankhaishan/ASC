<?php
require_once 'config.php'; // Include database connection
$conn = new mysqli("db", "root", "root", "owasp_demo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $image = "";

    // File upload (⚠️ Vulnerable: No checks on file type)
    if (!empty($_FILES["image"]["name"])) {
        $image = basename($_FILES["image"]["name"]);
        $target = "uploads/" . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target);
    }

    // Vulnerable SQL Query (⚠️ No sanitization)
    $sql = "INSERT INTO products (name, price, quantity, owner_id, image) 
            VALUES (\"$name\", \"$price\", \"$quantity\", 1, \"$image\")"; 
    $conn->query($sql);

    echo "<p class='text-success'>Product added: " . $name . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Add a Product</h2>
    
    <form method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Product Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price ($):</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity:</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Image:</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
        <a href="admin.php" class="btn btn-secondary">Go Back to Admin</a>
    </form>

</body>
</html>

<?php $conn->close(); ?>