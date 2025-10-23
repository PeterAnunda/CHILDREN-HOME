<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'Admin' && $_SESSION['user_role'] != 'Home_Manager')) {
    header("Location: index.html?error=unauthorized");
    exit;
}

$user_role = htmlspecialchars($_SESSION['user_role'] ?? 'Guest');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Reports</title>
    <link rel="stylesheet" href="style.css">
    <style>.page-content {text-align: center; padding: 100px;}</style>
</head>
<body>
    <header>
        <div class="logo">MKU Children's Platform</div>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="page-content">
        <h1>💵 Financial Tracking & Donation Reports</h1>
        [cite_start]<p>This module provides **real-time transaction records** and transparency for donations[cite: 50, 58].</p>
        <p>Managers can reconcile funds received via the **Secure Donation Gateway** here.</p>
        <p style="margin-top: 20px;"><a href="admin_dashboard.php">← Back to Dashboard</a></p>
    </div>
</body>
</html>