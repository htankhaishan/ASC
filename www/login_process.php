<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]); // Trim to remove unwanted spaces

    if (empty($username) || empty($password)) {
        echo "❌ Username or password is empty!";
        exit();
    }

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Direct plaintext comparison (⚠️ NOT SECURE)
        if ($password === $user["password"]) {
            $_SESSION["user"] = $user["username"];
            $_SESSION["role"] = $user["role"];
            echo "success"; // Ensure AJAX gets only "success"
        } else {
            echo "❌ Invalid password!";
        }
    } else {
        echo "❌ User not found!";
    }
}
?>