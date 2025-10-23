<?php
// =========================================================
// === PHP BACK-END FOR HOME DIRECTORY LISTING (XAMPP) ===
// =========================================================

// 1. Database Connection Credentials (Adjust if necessary for your XAMPP setup)
$servername = "localhost";
$username = "root";     // Default XAMPP username
$password = "";         // Default XAMPP password (often empty)
$dbname = "children_home"; // The database you created

// 2. Establish Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. SQL Query to Fetch Directory Data
// Selects the essential fields for the public directory listing
// Updated SQL Query in directory.php
$sql = "SELECT home_id, name, location, current_needs, services_offered, date_established, is_verified FROM children_home";
$result = $conn->query($sql);

// 4. Start HTML Output (This content will replace the simulated alert)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Directory - Children's Platform</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Directory specific styles */
        .directory-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .directory-container h2 {
            text-align: center;
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
            background-color: #e9ecef;
            color: var(--primary-blue);
        }
        .directory-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .verified-badge {
            color: var(--secondary-green);
            font-weight: bold;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">MKU Children's Platform</div>
        <nav>
            <a href="index.html#mission">Our Mission</a>
            <a href="index.html#features">Platform Features</a>
            <a href="index.html#register">Register/Login</a>
            <a href="directory.php"><button class="donate-btn-header">DONATE SECURELY</button></a>
        </nav>
    </header>

    <div class="directory-container">
        <h2>Children's Homes Directory (Live Data)</h2>
        <p>This directory is pulled directly from the **children_platform_db** database you created in phpMyAdmin.</p>
        
        <?php
        if ($result->num_rows > 0) {
            echo "<table class='directory-table'>";
            echo "<thead><tr><th>Home Name</th><th>Location</th><th>Current Needs</th><th>Services Offered</th><th>Est.</th><th>Status</th><th>Details</th></tr></thead>";
            echo "<tbody>";
            // Loop through the results and display each row
            while($row = $result->fetch_assoc()) {
                $status = $row["is_verified"] ? "<span class='verified-badge'>Verified ✅</span>" : "Pending ⏳";
                $est_year = date('Y', strtotime($row['date_established']));

                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["current_needs"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["services_offered"]) . "</td>";
                echo "<td>" . $est_year . "</td>";
                echo "<td>" . $status . "</td>";
             // New Code: Links to 'profile.php' and passes the home_id as a parameter
                echo "<td><a href='profile.php?id=" . $row["home_id"] . "'><button class='cta-btn-main' style='font-size:0.9em; padding: 5px 10px;'>View Profile</button></a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p style='text-align:center; font-style: italic;'>No homes found in the directory. Please ensure you have inserted sample data into the children_home table.</p>";
        }
        // 5. Close Connection
        $conn->close();
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Children’s Homes Management Platform. Developed by Mount Kenya University (BSCCS/2022/50917).</p>
    </footer>
</body>
</html>