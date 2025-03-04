<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $upload_dir = __DIR__ . '/uploads/';  // Set upload directory path
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif']; // Allowed MIME types

    // Ensure the uploads directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    $file_tmp  = $_FILES['image']['tmp_name'];
    $file_name = basename($_FILES['image']['name']);
    $target    = $upload_dir . $file_name;
    $file_type = mime_content_type($file_tmp);
    
    // Validate file type
    if (!in_array($file_type, $allowed_types)) {
       // If the uploaded file is NOT one of the allowed types (JPG, PNG, GIF), show an error message.
        echo "<div class='alert alert-danger'>Invalid file type! Only JPG, PNG, and GIF are allowed.</div>";
    } else {
        // Generate a unique file name to prevent overwriting
        $safe_target = $upload_dir . uniqid('img_', true) . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
        // Move the uploaded file from its temporary location to the target directory with a secure name.
        if (move_uploaded_file($file_tmp, $safe_target)) {
            echo "<div class='alert alert-success'>File uploaded successfully!</div><br>";
            echo "<p>File saved as: " . htmlspecialchars(basename($safe_target)) . "</p>";
        } else {
            echo "<div class='alert alert-danger'>Failed to upload file.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Upload</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Secure File Upload</h1>
        
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
