<?php

require_once 'config.php'; // Include database connection
session_start();

// No authentication check! (OWASP A1)
echo "<h2>Welcome to Admin Panel</h2>";
echo "<p><strong>WARNING:</strong> This page is accessible without authentication!</p>";

echo "<h3>Dangerous Actions:</h3>";
echo "<a href='delete_users.php'>Delete All Users</a>";
?>
