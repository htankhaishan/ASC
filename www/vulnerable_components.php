<?php
// Using outdated jQuery (1.7.1) with known XSS vulnerabilities
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable & Outdated Components</title>
    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script> <!-- Old jQuery -->
</head>
<body>
    <h2>Vulnerable & Outdated Components</h2>
    <p>This page uses an outdated jQuery version with known security vulnerabilities.</p>
    <script>
        $(document).ready(function() {
            $("#danger").click(function() {
                eval("alert('Exploitable XSS!')"); // Vulnerable code
            });
        });
    </script>
    <button id="danger">Run JavaScript</button>
</body>
</html>