<?php
// ==========================================================
// === PHP BACK-END FOR VOLUNTEER CONFIRMATION PAGE ===
// ==========================================================

// Database Connection (for fetching home name)
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "children_home";

// Get data from URL parameters
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Future Volunteer';
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
$home_id = isset($_GET['home_id']) ? (int)$_GET['home_id'] : 0;

if (empty($email) || $home_id == 0) {
    header("Location: index.php");
    exit;
}

// Fetch Home Name
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
    <title>Volunteer Application Confirmed | GreenSprout Home</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        :root {
            --background-light: #F0F5F2;  /* Mist Green */
            --primary-green: #2F5D62;     /* Forest Green */
            --accent-green: #5E8B7E;      /* Moss Green */
            --neutral-green: #A7C4BC;     /* Seafoam */
            --text-dark: #2E2E2E;         /* Deep Gray */
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
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
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

        /* Confirmation Container */
        .confirmation-container {
            max-width: 700px;
            margin: 100px auto;
            padding: 50px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(47, 93, 98, 0.15);
            text-align: center;
        }

        .confirmation-container h1 {
            color: var(--primary-green);
            font-size: 2.4em;
            margin-bottom: 20px;
        }

        .confirmation-container p {
            font-size: 1.1em;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .details-box {
            background-color: var(--background-light);
            border: 1px solid var(--neutral-green);
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }

        .details-box strong {
            display: block;
            font-size: 1.3em;
            color: var(--accent-green);
            margin-top: 5px;
        }

        .cta-btn-main {
            background-color: var(--primary-green);
            color: white;
            border: none;
            padding: 14px 25px;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cta-btn-main:hover {
            background-color: var(--accent-green);
            transform: scale(1.02);
        }

        footer {
            background-color: var(--primary-green);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 80px;
            font-size: 0.95em;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            Green<span style="color: var(--accent-green); font-weight: 700;">Sprout</span> Home
        </div>
        <nav>
            <a href="index.php#mission">Our Mission</a>
            <a href="directory.php">Homes Directory</a>
            <a href="volunteer_form.php">Volunteer</a>
        </nav>
        <a href="directory.php" class="header-action-btn">
            <button class="donate-btn-header">Donate Securely</button>
        </a>
    </header>

    <div class="confirmation-container">
        <h1>Volunteer Application Received 🌿</h1>
        
        <div class="details-box">
            <p>Thank you, <strong><?php echo $name; ?></strong>, for your willingness to support children in need.</p>
            <p>Your volunteer application has been successfully submitted to:</p>
            <strong><?php echo $home_name; ?></strong>
        </div>

        <p>A confirmation and next steps will be sent to <strong><?php echo $email; ?></strong> within 48 hours.</p>
        
        <p style="margin-top: 30px;">In the meantime, feel free to explore other homes that need your support:</p>
        
        <a href="directory.php">
            <button class="cta-btn-main" style="margin-top: 15px;">View Homes Directory</button>
        </a>
    </div>

    <footer>
        <p>&copy; 2025 GreenSprout Home — Growing Hope, One Child at a Time.</p>
    </footer>
</body>
</html>
