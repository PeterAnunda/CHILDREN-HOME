<?php
session_start();
// Basic Authorization Check (only Managers and Admins should access this)
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
    <title>Manage Homes</title>
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
        <h1>🏠 Home Directory Management</h1>
        <p>This module fulfills the objective of creating a **Searchable Home Directory** and managing **verification** for platform integrity.</p>
        <p>Current Role: **<?php echo $user_role; ?>**</p>
        <p style="margin-top: 20px;"><a href="admin_dashboard.php">← Back to Dashboard</a></p>
    </div>
</body>
</html>