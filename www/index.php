<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OWASP Top 10 Demo</title>
</head>
<body>
    <h1>OWASP Top 10 Vulnerabilities Demo</h1>
    <ul>
        <li><strong>Confidentiality:</strong></li>
        <li><a href="admin.php">1. Broken Access Control (A1) - Unauthorized Access</a></li>
        <li><a href="login.php">2. Cryptographic Failures (A2) - Weak Password Storage</a></li>
        <li><a href="products.php">3. Injection (A3) - SQL Injection</a></li>
        <li><a href="insecure_login.php">4. Insecure Design (A4) - Credentials in URL</a></li>
        <li><a href="forgot_password.php">5. Identification & Authentication Failures (A7) - Weak Password Reset</a></li>
        <li><a href="ssrf.php">6. Server-Side Request Forgery (SSRF) (A10) - Unauthorized Internal Requests</a></li>
        <br>
        <li><strong>Integrity:</strong></li>
        <li><a href="add_product.php">7. Injection (A3) - XSS</a></li>
        <li><a href="api.php">8. Security Misconfiguration (A5) - API Misconfigurations</a></li>
        <li><a href="vulnerable_components.php">9. Vulnerable & Outdated Components (A6) - Unpatched Software</a></li>
        <li><a href="fake_update.php">10. Software & Data Integrity Failures (A8) - Fake Update</a></li>
        <br>
        <li><strong>Availability:</strong></li>
        <li><a href="upload.php">11. Security Misconfiguration (A5) - Insecure File Upload</a></li>
        <li><a href="login.php">12. Identification & Authentication Failures (A7) - Broken Authentication</a></li>
        <li><a href="csrf.php">13. Identification & Authentication Failures (A7) - CSRF Attack</a></li>
        <li><a href="no_logging.php">14. Security Logging & Monitoring Failures (A9) - No Detection of Attacks</a></li>
    </ul>
</body>
</html>
