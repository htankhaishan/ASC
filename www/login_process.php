<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"]; // ❌ No input sanitization
    $password = $_POST["password"]; // ❌ No input sanitization

    if (empty($username) || empty($password)) {
        echo "❌ Username or password is empty!";
        exit();
    }

    // ❌ Direct SQL query (SQL Injection vulnerability)
    $result = $conn->query("SELECT id, username, password, role FROM users WHERE username = '$username'");
    $user = $result->fetch_assoc();

    if ($user) {
        // ❌ Plaintext password comparison (No hashing)
        if ($password === $user["password"]) {
            $_SESSION["user"] = $user["username"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["user_id"] = $user["id"]; // Store user ID for orders

            echo "success"; // Response for AJAX
        } else {
            echo "❌ Invalid password!";
        }
    } else {
        echo "❌ User not found!";
    }
}
?>
