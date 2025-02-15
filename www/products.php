<?php
// Insecure database connection
$conn = new mysqli("db", "root", "root", "owasp_demo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Vulnerable SQL query (no prepared statement)
$sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
</head>
<body>
    <h2>Search Products</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Search product">
        <button type="submit">Search</button>
    </form>

    <h3>Product List</h3>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["name"] . " - $" . $row["price"] . "</li>";
            }
        } else {
            echo "<li>No products found.</li>";
        }
        ?>
    </ul>

    <p><strong>Try SQL Injection:</strong> <br>
    <code>' OR 1=1 --</code></p>
</body>
</html>

<?php $conn->close(); ?>