<?php
require_once 'config.php'; // Include database connection
header("Access-Control-Allow-Origin: *"); // Open CORS policy (OWASP A5)
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "owasp_demo");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row; // Exposing all user details
}

// Exposing sensitive debug info
echo json_encode([
    "users" => $users,
    "debug" => [
        "server" => $_SERVER,
        "php_version" => phpversion()
    ]
]);

$conn->close();
?>
