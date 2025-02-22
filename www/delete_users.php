<?php
require_once 'config.php';
session_start();

// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is an admin
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    die("Access Denied. <a href='index.php'>Go back</a>");
}

// Check if an ID was provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. <a href='admin.php'>Go back</a>");
}

$user_id = intval($_GET['id']); // Convert ID to an integer

// Prevent deleting the admin account (optional)
if ($user_id == 1) { 
    die("You cannot delete the admin account. <a href='admin.php'>Go back</a>");
}

// Delete user query
$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: admin.php?message=User+deleted+successfully");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>