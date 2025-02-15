<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    echo "<p>Fetching: $url</p>";
    echo "<pre>" . file_get_contents($url) . "</pre>"; // SSRF vulnerability
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SSRF Demo</title>
</head>
<body>
    <h2>Server-Side Request Forgery (SSRF)</h2>
    <form method="GET">
        <label>Enter URL:</label>
        <input type="text" name="url" required>
        <button type="submit">Fetch</button>
    </form>
</body>
</html>