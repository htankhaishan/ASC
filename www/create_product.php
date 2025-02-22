<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    die("Access Denied. <a href='index.php'>Go back</a>");
}

if (!isset($_GET["id"])) {
    die("Invalid request.");
}

$id = intval($_GET["id"]);

$query = "DELETE FROM products WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin.php?message=Product+deleted+successfully");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>