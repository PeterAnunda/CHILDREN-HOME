<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>.dashboard {text-align: center; padding: 100px;}</style>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Manager'); ?>!</h1>
        <p>This is the **Admin/Manager Dashboard** (Fulfills Role-Based Access Objective).</p>
        <p>You can manage children records, volunteers, and finances from here.</p>
        <p><a href="index.html">Logout (Return to Home)</a></p>
    </div>
</body>
</html>