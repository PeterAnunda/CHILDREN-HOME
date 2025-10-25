<?php
// ===============================================
// === PHP BACK-END FOR HOME PROFILE DISPLAY ===
// ===============================================

// Database Connection
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the Home ID from URL
$home_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($home_id == 0) {
    die("Error: No Children's Home ID provided.");
}

// Fetch home details
$stmt = $conn->prepare("SELECT * FROM children_home WHERE home_id = ?");
$stmt->bind_param("i", $home_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: Children's Home not found.");
}

$home = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($home['name']); ?> | GreenSprout Home</title>
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
        background-color: var(--background-light);
        font-family: "Segoe UI", Roboto, sans-serif;
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
        letter-spacing: 0.5px;
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

    .profile-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 40px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(47,93,98,0.15);
    }

    .profile-container h1 {
        color: var(--primary-green);
        border-bottom: 2px solid var(--accent-green);
        padding-bottom: 10px;
        margin-bottom: 20px;
        text-align: center;
    }

    .profile-section {
        margin-bottom: 30px;
        padding: 20px;
        border-left: 5px solid var(--primary-green);
        background-color: var(--background-light);
        border-radius: 8px;
    }

    .profile-section h3 {
        color: var(--accent-green);
        margin-bottom: 12px;
    }

    .detail-item {
        margin-bottom: 8px;
    }

    .label {
        font-weight: bold;
        display: inline-block;
        width: 150px;
    }

    .donate-btn-main, .cta-btn-main {
        padding: 14px 25px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1em;
        margin: 10px 5px;
        transition: transform 0.2s ease, background-color 0.3s ease;
    }

    .donate-btn-main {
        background-color: var(--primary-green);
        color: white;
    }

    .donate-btn-main:hover {
        background-color: var(--accent-green);
        transform: scale(1.02);
    }

    .cta-btn-main {
        background-color: #6c757d;
        color: white;
    }

    .cta-btn-main:hover {
        background-color: #5a6268;
        transform: scale(1.02);
    }

    footer {
        background-color: var(--primary-green);
        color: white;
        text-align: center;
        padding: 20px;
        margin-top: 50px;
        font-size: 0.95em;
    }
</style>
</head>
<body>
<header>
    <div class="logo">Green<span style="color: var(--accent-green); font-weight: 700;">Sprout</span> Home</div>
    <nav>
        <a href="index.php#mission">Our Mission</a>
        <a href="directory.php">Home Directory</a>
        <a href="volunteer_form.php">Volunteer</a>
        <a href="directory.php"><button class="donate-btn-header">Donate Securely</button></a>
    </nav>
</header>

<div class="profile-container">
    <h1><?php echo htmlspecialchars($home['name']); ?></h1>
    
    <div class="profile-section">
        <h3>Mission & Overview</h3>
        <p><?php echo nl2br(htmlspecialchars($home['description'])); ?></p>
    </div>

    <div class="profile-section">
        <h3>Key Details</h3>
        <div class="detail-item"><span class="label">Location:</span> <?php echo htmlspecialchars($home['location']); ?></div>
        <div class="detail-item"><span class="label">Established:</span> <?php echo date('F j, Y', strtotime($home['date_established'])); ?></div>
        <div class="detail-item"><span class="label">Status:</span> <?php echo $home['is_verified'] ? 'Verified Partner ✅' : 'Pending Verification ⏳'; ?></div>
        <div class="detail-item"><span class="label">Contact Email:</span> <?php echo htmlspecialchars($home['email']); ?></div>
    </div>

    <div class="profile-section">
        <h3>Current Needs (How You Can Help)</h3>
        <p><?php echo nl2br(htmlspecialchars($home['current_needs'])); ?></p>
    </div>

    <div class="profile-section">
        <h3>Services Provided</h3>
        <p><?php echo nl2br(htmlspecialchars($home['services_offered'])); ?></p>
    </div>
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="donate.php?home_id=<?php echo $home_id; ?>">
            <button class="donate-btn-main">Sponsor or Donate to This Home</button>
        </a>
        <a href="directory.php">
            <button class="cta-btn-main">Back to Directory</button>
        </a>
    </div>
</div>

<footer>
    <p>&copy; 2025 GreenSprout Home — Growing Hope, One Child at a Time.</p>
</footer>
</body>
</html>
