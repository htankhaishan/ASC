<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $upload_dir = __DIR__ . '/uploads/';  // Set upload directory path
    $target = $upload_dir . basename($_FILES['image']['name']);
    
    // Ensure the uploads directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "<div class='alert alert-success'>File uploaded successfully!</div><br>";
        // Vulnerable: ExifTool used without sanitization
        $output = shell_exec("exiftool " . escapeshellarg($target));
        echo "<pre>$output</pre>";
    } else {
        echo "<div class='alert alert-danger'>Failed to upload file.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Upload Image (ExifTool Processing)</h1>
        
        <form method="post" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="image" class="form-label">Choose Image:</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <!-- Bootstrap JS (optional for additional functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>