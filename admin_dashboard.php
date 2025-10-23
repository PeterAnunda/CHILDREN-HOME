<?php
session_start();

// Check if user is logged in and is authorized (Admin or Home_Manager)
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'Admin' && $_SESSION['user_role'] != 'Home_Manager')) {
    header("Location: index.html?error=unauthorized");
    exit;
}

// 1. Database Connection Credentials
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home"; // Your database name

// 2. Establish Connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Fetch Dashboard Metrics (Crucial for a Manager)
$stats = [
    'total_donations' => 0,
    'total_homes' => 0,
    'new_volunteers' => 0,
    'total_kids' => 'N/A' // Placeholder since we don't have a 'children' table yet
];

// Query 1: Total Donation Amount (from the 'donation' table)
$sql_donations = "SELECT SUM(amount) AS total_donations FROM donation";
$result_donations = $conn->query($sql_donations);
if ($result_donations && $row = $result_donations->fetch_assoc()) {
    $stats['total_donations'] = number_format($row['total_donations'] ?? 0, 0);
}

// Query 2: Total Number of Homes in the directory
$sql_homes = "SELECT COUNT(home_id) AS total_homes FROM children_home";
$result_homes = $conn->query($sql_homes);
if ($result_homes && $row = $result_homes->fetch_assoc()) {
    $stats['total_homes'] = $row['total_homes'];
}

// Query 3: Total Donors/Volunteers (Estimated from the 'users' table, excluding Managers/Admins)
$sql_users = "SELECT COUNT(user_id) AS total_supporters FROM users WHERE role IN ('Donor', 'Volunteer')";
$result_users = $conn->query($sql_users);
if ($result_users && $row = $result_users->fetch_assoc()) {
    $stats['total_supporters'] = $row['total_supporters'];
}


$conn->close();
$user_role = htmlspecialchars($_SESSION['user_role'] ?? 'Guest');
$user_email = htmlspecialchars($_SESSION['user_email'] ?? 'Welcome');

// --- Start HTML Output ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - <?php echo $user_role; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Dashboard Specific Styles */
        .dashboard-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
        }
        .welcome-header {
            background-color: var(--primary-blue);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 {
            font-size: 1.2em;
            color: #6c757d;
        }
        .stat-card .number {
            font-size: 2.5em;
            font-weight: bold;
            color: var(--secondary-green);
            margin-top: 10px;
        }
        .management-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .management-links a {
            text-decoration: none;
            display: block;
            background-color: #e9ecef;
            color: var(--text-dark);
            padding: 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s, transform 0.1s;
            border-left: 5px solid var(--primary-blue);
        }
        .management-links a:hover {
            background-color: #dee2e6;
            transform: translateY(-2px);
            border-left-color: var(--secondary-green);
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">MKU Children's Platform</div>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="#reports">Reports</a>
            <a href="logout.php">Logout</a> </nav>
    </header>

    <div class="dashboard-container">
        <div class="welcome-header">
            <h1>Welcome, <?php echo $user_role; ?>!</h1>
            <p>You are logged in as: <?php echo $user_email; ?></p>
            <p>This is your centralized hub for managing the Children's Homes Platform.</p>
        </div>

        <h2>Key Performance Indicators (KPIs)</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Donations Received (KES)</h3>
                <div class="number">KES <?php echo $stats['total_donations']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Registered Homes</h3>
                <div class="number"><?php echo $stats['total_homes']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Active Supporters (Donors/Vols)</h3>
                <div class="number"><?php echo $stats['total_supporters']; ?>+</div>
            </div>
            <div class="stat-card">
                <h3>Children Records Available</h3>
                <div class="number"><?php echo $stats['total_kids']; ?></div>
            </div>
        </div>

        <h2 style="text-align: center;">Management Tools (Fulfills Objectives)</h2>
        <div class="management-links">
            <a href="manage_homes.php">🏠 Manage Home Directory & Verification</a>
            <a href="manage_volunteers.php">👥 Volunteer Coordination & Scheduling</a>
            <a href="manage_adoptions.php">👨‍👩‍👧‍👦 Streamline Adoption Process</a>
            <a href="donation_reports.php">💵 Financial Tracking & Donation Reports</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Children’s Homes Management Platform. Role: <?php echo $user_role; ?></p>
    </footer>
</body>
</html>