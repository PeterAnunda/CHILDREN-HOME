<?php
// =========================================================
// === PHP BACK-END FOR HOME DIRECTORY LISTING ===
// =========================================================

// Database Connection
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Directory Data
$sql = "SELECT home_id, name, location, current_needs, services_offered, date_established, is_verified FROM children_home";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home Directory | GreenSprout Home</title>
<link rel="stylesheet" href="style.css">
<style>
    :root {
        --background-light: #F0F5F2;
        --primary-green: #2F5D62;
        --accent-green: #5E8B7E;
        --neutral-green: #A7C4BC;
        --text-dark: #2E2E2E;
    }

    body {
        font-family: "Segoe UI", Roboto, sans-serif;
        background-color: var(--background-light);
        color: var(--text-dark);
        margin: 0;
        padding: 0;
    }

    header {
        background-color: var(--primary-green);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 40px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }

    .logo {
        font-size: 1.6em;
        font-weight: 700;
    }

    nav a {
        color: white;
        margin: 0 12px;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    nav a:hover {
        color: var(--neutral-green);
    }

    .donate-btn-header {
        background-color: var(--accent-green);
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .donate-btn-header:hover {
        background-color: var(--neutral-green);
    }

    .directory-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(47,93,98,0.1);
    }

    .directory-container h2 {
        text-align: center;
        color: var(--primary-green);
        margin-bottom: 15px;
    }

    .directory-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .directory-table th, .directory-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .directory-table th {
        background-color: var(--background-light);
        color: var(--primary-green);
    }

    .directory-table tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .verified-badge {
        color: var(--accent-green);
        font-weight: bold;
    }

    .cta-btn-main {
        background-color: var(--primary-green);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 8px 14px;
        cursor: pointer;
        font-weight: 600;
        transition: transform 0.2s ease, background-color 0.3s ease;
    }

    .cta-btn-main:hover {
        background-color: var(--accent-green);
        transform: scale(1.05);
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: var(--primary-green);
        color: white;
        margin-top: 50px;
        font-size: 0.95em;
    }

    @media (max-width: 768px) {
        header, .directory-container {
            padding: 20px;
        }
        nav a {
            margin: 0 6px;
            font-size: 0.9em;
        }
    }
</style>
</head>
<body>

<header>
    <div class="logo">GreenSprout Home</div>
    <nav>
        <a href="index.php#mission">Our Mission</a>
        <a href="directory.php">Home Directory</a>
        <a href="volunteer_form.php">Volunteer</a>
        <a href="directory.php"><button class="donate-btn-header">Donate Securely</button></a>
    </nav>
</header>

<div class="directory-container">
    <h2>Children's Homes Directory</h2>
    <p style="text-align:center;">This directory is pulled directly from the <strong>children_home</strong> database.</p>

    <?php if ($result->num_rows > 0): ?>
        <table class="directory-table">
            <thead>
                <tr>
                    <th>Home Name</th>
                    <th>Location</th>
                    <th>Current Needs</th>
                    <th>Services Offered</th>
                    <th>Established</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td><?php echo htmlspecialchars($row['current_needs']); ?></td>
                        <td><?php echo htmlspecialchars($row['services_offered']); ?></td>
                        <td><?php echo date('Y', strtotime($row['date_established'])); ?></td>
                        <td>
                            <?php echo $row['is_verified'] ? "<span class='verified-badge'>Verified ✅</span>" : "Pending ⏳"; ?>
                        </td>
                        <td>
                            <a href="profile.php?id=<?php echo $row['home_id']; ?>">
                                <button class="cta-btn-main">View Profile</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; font-style:italic;">No homes found in the directory.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</div>

<footer>
    <p>&copy; 2025 GreenSprout Home — Growing Hope, One Child at a Time.</p>
</footer>

</body>
</html>
