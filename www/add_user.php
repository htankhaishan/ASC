<?php
require_once 'config.php';
session_start();

// Check if the user is an admin
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    die("<div class='alert alert-danger text-center mt-3'>Access Denied. <a href='index.php' class='alert-link'>Go back</a></div>");
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Securely hash the password
    $role = trim($_POST["role"]); // Get role from form

    // Validate role
    if (!in_array($role, ['admin', 'user'])) {
        $message = "<div class='alert alert-danger'>Invalid role selected.</div>";
    } else {
        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>User added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding user.</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-3">Add New User</h2>

            <?= $message ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username:</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role:</label>
                    <select name="role" class="form-control" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">➕ Add User</button>
                <a href="admin.php" class="btn btn-secondary">⬅ Back to Admin Panel</a>
            </form>
        </div>
    </div>
</body>
</html>