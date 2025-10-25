<?php
// Adoption Inquiry - Step 1
// No database logic here; submission handled in handle_adoption_inquiry.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adoption Application: Step 1 | GreenSprout Home</title>
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
            color: #ffffff;
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

        /* Application Form Container */
        .application-container {
            max-width: 750px;
            margin: 60px auto;
            padding: 45px;
            background-color: #ffffff; 
            border-radius: 12px; 
            box-shadow: 0 6px 14px rgba(47, 93, 98, 0.15);
        }

        .application-container h1 {
            color: var(--primary-green);
            font-size: 2.2em;
            margin-bottom: 10px;
            text-align: center;
        }

        .application-container h3 {
            color: var(--accent-green);
            margin-bottom: 25px;
            text-align: center;
        }

        .application-container p.summary {
            text-align: center;
            color: var(--text-dark);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .application-container p.summary a {
            color: var(--accent-green);
            text-decoration: none;
            font-weight: 600;
        }

        .application-container p.summary a:hover {
            color: var(--primary-green);
        }

        .application-container form {
            text-align: left;
        }

        /* Inputs and Selects */
        .application-container input[type="text"],
        .application-container input[type="email"],
        .application-container select,
        .application-container textarea {
            width: 100%;
            padding: 14px; 
            margin-bottom: 20px;
            border: 1px solid var(--neutral-green);
            border-radius: 6px; 
            box-sizing: border-box; 
            transition: all 0.3s ease;
            background-color: #FAFDFC;
            font-size: 1em;
        }

        .application-container input:focus,
        .application-container select:focus,
        .application-container textarea:focus {
            border-color: var(--accent-green);
            box-shadow: 0 0 0 3px rgba(94, 139, 126, 0.25);
            outline: none;
        }

        .application-container label {
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: var(--text-dark);
        }

        /* Form sections */
        .form-section {
            border: 1px solid var(--neutral-green);
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            background-color: #FAFDFC;
        }

        /* Submit Button */
        .donate-btn-main {
            background-color: var(--primary-green);
            color: white;
            border: none;
            padding: 14px 20px;
            font-size: 1.05em;
            border-radius: 6px;
            width: 100%;
            text-transform: uppercase;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .donate-btn-main:hover {
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
            <a href="index.php">Home</a>
            <a href="adoption_process_guide.php">Requirements</a>
            <a href="volunteer_form.php">Volunteer</a>
        </nav>
        <a href="directory.php" class="header-action-btn">
            <button class="donate-btn-header">Donate Securely</button>
        </a>
    </header>

    <div class="application-container">
        <h1>Adoption Inquiry: Step 1</h1>
        <h3>Initial Screening & Family Profile</h3>
        <p class="summary">
            Please provide accurate information. This form begins the legal process as outlined in the 
            <a href="adoption_process_guide.php">Adoption Requirements Guide</a>.
        </p>
        
        <form method="POST" action="handle_adoption_inquiry.php">
            <div class="form-section">
                <label for="family_name">Primary Applicant Full Name(s):</label>
                <input type="text" id="family_name" name="family_name" placeholder="Mr. & Mrs. Okello" required>
                
                <label for="email">Contact Email:</label>
                <input type="email" id="email" name="email" placeholder="example@family.com" required>
                
                <label for="occupation">Primary Occupation(s):</label>
                <input type="text" id="occupation" name="occupation" placeholder="e.g., Engineer, Teacher, Self-employed" required>
            </div>
            
            <div class="form-section">
                <label for="marital_status">Marital Status:</label>
                <select id="marital_status" name="marital_status" required>
                    <option value="">-- Select Status --</option>
                    <option value="Married">Married</option>
                    <option value="Single">Single</option>
                    <option value="Divorced">Divorced</option>
                </select>

                <label for="target_home_id">Preferred Home/Location (Optional):</label>
                <select id="target_home_id" name="target_home_id">
                    <option value="">-- No Preference --</option>
                    <option value="1">Happy Life Children's Home (Thika)</option>
                    <option value="2">GreenSprout Home (Nairobi)</option>
                    <option value="3">Amani Angels Home (Mombasa)</option>
                </select>
                
                <label for="child_preference">Child Age Preference (e.g., 5–10 years):</label>
                <input type="text" id="child_preference" name="child_preference" placeholder="e.g., Male, 5–10 years old" required>
            </div>

            <button type="submit" class="donate-btn-main">
                Submit Initial Inquiry & Proceed to Eligibility Check
            </button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 GreenSprout Home — Nurturing Hope and Growth for Every Child.</p>
    </footer>
</body>
</html>

