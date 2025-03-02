<?php
// Secure upload page

include('config.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $upload_dir = 'uploads/';
    $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    // Allowed file extensions
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Validate the file extension
    if (!in_array(strtolower($file_extension), $allowed_extensions)) {
        die("Invalid file type. Only images are allowed.");
    }

    // Sanitize the file name
    $new_file_name = uniqid('img_', true) . '.' . $file_extension;
    $upload_file = $upload_dir . $new_file_name;

    // Move the uploaded file
    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
        echo "File has been uploaded.";
    } else {
        echo "Error uploading file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Upload a Secure Image</h1>
        <form action="upload-secure.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Select file to upload:</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>