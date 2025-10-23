<?php
// ==========================================================
// === PHP BACK-END FOR DONATION CONFIRMATION PAGE ===
// ==========================================================

// 1. Database Connection Credentials (to fetch the home name)
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home"; // Your database name

// 2. Get details from the URL after the successful donation
$home_id = isset($_GET['home_id']) ? (int)$_GET['home_id'] : 0;
$amount = isset($_GET['amount']) ? (float)$_GET['amount'] : 0.00;

if ($home_id == 0 || $amount == 0.00) {
    // If accessed directly without parameters, redirect home
    header("Location: index.html");
    exit;
}

// 3. Fetch Home Name
$conn = new mysqli($servername, $username, $password, $dbname);
$stmt = $conn->prepare("SELECT name FROM children_home WHERE home_id = ?");
$stmt->bind_param("i", $home_id);
$stmt->execute();
$result = $stmt->get_result();
$home = $result->fetch_assoc();
$home_name = htmlspecialchars($home['name'] ?? 'Selected Home'); // Use 'Selected Home' if name not found
$conn->close();

// --- Start HTML Output ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Confirmed - <?php echo $home_name; ?></title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        .confirmation-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-align: center;
        }
        .confirmation-container h1 {
            color: var(--secondary-green);
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .confirmation-container p {
            font-size: 1.1em;
            margin-bottom: 15px;
        }
        .details-box {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .details-box strong {
            display: block;
            font-size: 1.5em;
            color: var(--primary-blue);
            margin-top: 5px;
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
            <button class="donate-btn-header">DONATE SECURELY</button>
        </nav>
    </header>

    <div class="confirmation-container">
        <h1>Donation Successful! 🎉</h1>
        <p>Thank you for your generous contribution to the welfare of vulnerable children.</p>

        <div class="details-box">
            <p>Donated to:</p>
            <strong><?php echo $home_name; ?></strong>
            <p style="margin-top: 15px;">Amount:</p>
            <strong>KES <?php echo number_format($amount, 2); ?></strong>
        </div>

        <p>You have made a significant impact. An email confirmation has been sent.</p>
        
        <a href="profile.php?id=<?php echo $home_id; ?>">
            <button class="cta-btn-main" style="margin-top: 20px;">Return to Home Profile</button>
        </a>
    </div>

    <footer>
        <p>&copy; 2024 Children’s Homes Management Platform. Security is a priority.</p>
    </footer>
</body>
</html>