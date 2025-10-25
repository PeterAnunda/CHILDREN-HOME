<?php
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home";

$home_id = isset($_GET['home_id']) ? (int)$_GET['home_id'] : 0;
$amount = isset($_GET['amount']) ? (float)$_GET['amount'] : 0.00;

if ($home_id === 0 || $amount === 0.00) {
    header("Location: index.html");
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);
$stmt = $conn->prepare("SELECT name FROM children_home WHERE home_id = ?");
$stmt->bind_param("i", $home_id);
$stmt->execute();
$result = $stmt->get_result();
$home = $result->fetch_assoc();
$home_name = htmlspecialchars($home['name'] ?? 'Selected Home');
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Donation Confirmed - <?php echo $home_name; ?></title>
<link rel="stylesheet" href="style.css">
<style>
:root {
    --primary-green: #28a745;   /* Main brand green */
    --accent-green: #2ecc71;    /* Hover highlights */
    --secondary-gray: #6c757d;  /* Muted text */
}

body {
    font-family: Arial, sans-serif;
    background-color: #f1f5f9;
    margin: 0;
    padding: 0;
}

header {
    background-color: #fff;
    padding: 15px 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.logo {
    font-size: 1.5em;
    font-weight: bold;
}

.logo span {
    color: var(--accent-green);
}

nav a, nav button {
    margin-left: 20px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    background: none;
    border: none;
    cursor: pointer;
}

.donate-btn-header {
    background-color: var(--primary-green);
    color: #fff;
    padding: 8px 15px;
    border-radius: 5px;
    font-weight: bold;
    transition: background 0.3s;
}

.donate-btn-header:hover {
    background-color: var(--accent-green);
}

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
    color: var(--primary-green);
    font-size: 2.5em;
    margin-bottom: 20px;
}

.confirmation-container p {
    font-size: 1.1em;
    margin-bottom: 15px;
    color: var(--secondary-gray);
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
    color: var(--primary-green);
    margin-top: 5px;
}

.cta-btn-main {
    background-color: var(--primary-green);
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 1em;
    transition: background 0.3s;
}

.cta-btn-main:hover {
    background-color: var(--accent-green);
}

footer {
    text-align: center;
    padding: 20px;
    background-color: #fff;
    color: var(--secondary-gray);
    margin-top: 50px;
}
</style>
</head>
<body>

<header>
    <div class="logo">Green<span>Sprout</span> Home</div>
    <nav>
        <a href="index.html#mission">Our Mission</a>
        <a href="directory.php">Home Directory</a>
        <a href="index.html#register">Register/Login</a>
        <a href="directory.php" class="donate-btn-header">DONATE SECURELY</a>
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

    <p>Your support is making a real difference. A confirmation email has been sent.</p>
    
    <a href="profile.php?id=<?php echo $home_id; ?>">
        <button class="cta-btn-main" style="margin-top: 20px;">Return to Home Profile</button>
    </a>
</div>

<footer>
    <p>&copy; 2025 GreenSprout Home — Growing Hope, One Child at a Time.</p>
</footer>

</body>
</html>
