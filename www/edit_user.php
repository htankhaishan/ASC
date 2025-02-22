<?php
require_once 'config.php';
session_start();

// Check if the user is an admin
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    die("<div class='alert alert-danger text-center mt-3'>Access Denied. <a href='index.php' class='alert-link'>Go back</a></div>");
}

// Fetch user details
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    die("<div class='alert alert-danger text-center mt-3'>Invalid user ID. <a href='admin.php' class='alert-link'>Go back</a></div>");
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Validate role
    if (!in_array($role, ['admin', 'user'])) {
        $message = "<div class='alert alert-danger'>Invalid role selected.</div>";
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $id);
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>User updated successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error updating user.</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-3">Edit User</h2>

            <?= $message ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username:</label>
                    <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role:</label>
                    <select name="role" class="form-control" required>
                        <option value="user" <?= ($user['role'] === 'user') ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">✅ Update User</button>
                <a href="admin.php" class="btn btn-secondary">⬅ Back to Admin Panel</a>
            </form>
        </div>
    </div>
</body>
</html>