<?php
// ===============================================
// === PHP BACK-END FOR HOME PROFILE DISPLAY ===
// ===============================================

// 1. Database Connection Credentials
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home"; // Your corrected database name

// 2. Establish Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Get the Home ID from the URL (the 'id' parameter)
$home_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($home_id == 0) {
    die("Error: No Children's Home ID provided.");
}

// 4. SQL Query to Fetch ALL details for the specific home
// Using prepared statements is a security best practice (SQL Injection prevention)
$stmt = $conn->prepare("SELECT * FROM children_home WHERE home_id = ?");
$stmt->bind_param("i", $home_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: Children's Home not found.");
}

$home = $result->fetch_assoc();
$conn->close();

// --- Start HTML Output ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($home['name']); ?> Profile</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        .profile-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-align: left;
        }
        .profile-container h1 {
            color: var(--primary-blue);
            border-bottom: 2px solid var(--secondary-green);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .profile-section {
            margin-bottom: 30px;
            padding: 15px;
            border-left: 5px solid var(--primary-blue);
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .profile-section h3 {
            color: var(--secondary-green);
            margin-bottom: 10px;
        }
        .detail-item {
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">MKU Children's Platform</div>
        <nav>
            <a href="index.html#mission">Our Mission</a>
            <a href="directory.php">Home Directory</a>
            <a href="index.html#register">Register/Login</a>
            <a href="directory.php"><button class="donate-btn-header">DONATE SECURELY</button></a>
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
            <!-- New Code: Links to 'donate.php' and passes the home_id so the donation is directed correctly. -->
            
        <a href="donate.php?home_id=<?php echo $home_id; ?>"><button class="donate-btn-main">Sponsor or Donate to This Home</button></a>
            <a href="directory.php" style="margin-left: 20px;">
                <button class="cta-btn-main" style="background-color: #6c757d;">Back to Directory</button>
            </a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Children’s Homes Management Platform. Security is a priority.</p>
    </footer>
</body>
</html>