<?php
$host = "db";
$username = "root";
$password = "root";
$database = "owasp_demo";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
