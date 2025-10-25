<?php
// ==========================================================
// === PHP LOGIC TO POPULATE DROPDOWN FROM MYSQL ===
// ==========================================================
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

$home_options = ''; // Variable to store the HTML options

if ($conn->connect_error) {
    // Fallback message if database connection fails
    $home_options = '<option value="">Database connection failed! (Check XAMPP)</option>';
} else {
    // Fetch all homes for the dropdown list
    $sql = "SELECT home_id, name, location FROM children_home ORDER BY name";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Create an <option> tag for each home
            $home_options .= '<option value="' . $row['home_id'] . '">' . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['location']) . ')</option>';
        }
    } else {
        $home_options = '<option value="">No organizations found in directory.</option>';
    }
    $conn->close();
}
// --- PHP processing ends, HTML generation begins ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply to Volunteer</title>
    <link rel="stylesheet" href="style.css"> 
   <style>
    :root {
        --background-light: #F0F5F2;
        --primary-green: #2F5D62;
        --accent-green: #5E8B7E;
        --neutral-green: #A7C4BC;
        --text-dark: #2E2E2E;
    }

    /* General Layout */
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

    /* Volunteer Form Container */
    .volunteer-container {
        max-width: 650px;
        margin: 60px auto;
        padding: 40px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 14px rgba(47, 93, 98, 0.15);
    }

    .volunteer-container h1 {
        color: var(--primary-green);
        font-size: 2.2em;
        margin-bottom: 5px;
        text-align: center;
    }

    .volunteer-container p.summary {
        color: var(--accent-green);
        text-align: center;
        margin-bottom: 30px;
    }

    .volunteer-container form {
        text-align: left;
    }

    /* Inputs & Selects */
    .volunteer-container input[type="text"],
    .volunteer-container input[type="email"],
    .volunteer-container input[type="date"],
    .volunteer-container select,
    .volunteer-container textarea {
        width: 100%;
        padding: 14px;
        margin-bottom: 20px;
        border: 1px solid var(--neutral-green);
        border-radius: 6px;
        background-color: #fafdfc;
        transition: all 0.3s ease;
        font-size: 1em;
    }

    .volunteer-container input:focus,
    .volunteer-container select:focus,
    .volunteer-container textarea:focus {
        border-color: var(--accent-green);
        box-shadow: 0 0 0 3px rgba(94, 139, 126, 0.25);
        outline: none;
    }

    .volunteer-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-dark);
    }

    /* Submit Button */
    .donate-btn-main {
        background-color: var(--primary-green);
        color: #ffffff;
        padding: 14px 20px;
        font-size: 1.1em;
        border-radius: 6px;
        border: none;
        width: 100%;
        text-transform: uppercase;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .donate-btn-main:hover {
        background-color: var(--accent-green);
        transform: scale(1.02);
    }

    /* Links */
    a {
        color: var(--primary-green);
        text-decoration: none;
    }

    a:hover {
        color: var(--accent-green);
    }

    footer {
        background-color: var(--primary-green);
        color: white;
        text-align: center;
        padding: 20px;
        margin-top: 60px;
    }
</style>

</head>
<body>

    <header>
        <div class="logo" style="color:white;">GreenSprout Home</div>
        <nav>
            <a href="index.php#mission">Our Mission</a>
            <a href="index.php#features">Features</a>
            <a href="index.php">Home</a>
        </nav>
        <a href="directory.php" class="header-action-btn"><button class="donate-btn-header">DONATE SECURELY</button></a>
    </header>

    <div class="volunteer-container">
        <h1>Apply to Volunteer</h1>
        <p class="summary">Thank you for your interest! Please choose the organization you'd like to support and tell us about your skills.</p>
        
        <form id="volunteerForm" method="POST" action="handle_volunteer.php">
            
            <label for="home_select">Select Organization:</label>
            <select id="home_select" name="home_id" required>
                <option value="">-- Choose a Children's Home --</option>
                <?php echo $home_options; // Inject the generated HTML options ?>
            </select>
            
            <label for="name">Your Full Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Your Email Address:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="interest">Area of Interest/Skills:</label>
            <textarea id="interest" name="interest" placeholder="e.g., Tutoring Math, Mentorship, General Maintenance, etc." rows="4" required></textarea>
           <label for="start_date">Preferred Start Date:</label>
            <input type="date" id="start_date" name="start_date" required> 
            
            <label for="end_date">Preferred End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
            <button type="submit" id="submitVolunteerBtn" class="donate-btn-main" style="width: 100%; margin-top: 20px;">
                Submit Volunteer Application
            </button>
        </form>
        
        <p style="margin-top: 20px;"><a href="index.php">← Back to Homepage</a></p>
    </div>

    <footer>
        <p>&copy; 2024 Children’s Homes Management Platform. We appreciate your support!</p>
    </footer>
</body>
</html>