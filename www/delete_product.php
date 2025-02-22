<?php
session_start();
require_once 'config.php';

// Check Admin Role
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== 'admin') {
    echo "Unauthorized access!";
    exit();
}

$conn = new mysqli("db", "root", "root", "owasp_demo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = (int) $_POST["id"]; // Convert to integer to prevent SQL Injection

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Product ID $id has been deleted.";
    } else {
        echo "Error deleting product.";
    }

    $stmt->close();
}

$conn->close();
?>