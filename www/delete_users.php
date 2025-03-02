<?php
require_once 'config.php';
session_start();
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is admin
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    echo json_encode(["status" => "error", "message" => "Access Denied"]);
    exit();
}

// Check if an ID was provided
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

$user_id = intval($_POST['id']); // Convert ID to an integer

// Prevent deleting the admin account (optional)
if ($user_id == 1) { 
    echo json_encode(["status" => "error", "message" => "You cannot delete the admin account"]);
    exit();
}

// Delete user query
$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error deleting user: " . $conn->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();