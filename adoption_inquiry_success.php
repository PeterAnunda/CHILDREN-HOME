<?php
$family_name = isset($_GET['family']) ? htmlspecialchars($_GET['family']) : 'Applicant';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inquiry Submitted</title>
    <link rel="stylesheet" href="styles.css"> 
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

        /* Success Container */
        .success-container {
            max-width: 650px;
            margin: 100px auto;
            padding: 50px 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 14px rgba(47, 93, 98, 0.15);
            text-align: center;
        }

        .success-container h1 {
            color: var(--primary-green);
            font-size: 2.4em;
            margin-bottom: 15px;
        }

        .success-container p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .cta-btn-main {
            background-color: var(--primary-green);
            color: white;
            border: none;
            padding: 14px 22px;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            font-weight: 600;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cta-btn-main:hover {
            background-color: var(--accent-green);
            transform: scale(1.03);
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
            Green<span style="color: var(--neutral-green);">Sprout Home</span>
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

    <div class="success-container">
        <h1>Application Inquiry Received!</h1>
        <p>Thank you, <strong><?php echo $family_name; ?></strong>, for taking the first step in the adoption process.</p>
        <p style="font-weight: 600;">Your initial inquiry has been successfully submitted to our system.</p>
        <p>A manager will review your profile and update your status within 2–3 business days. You’ll be notified by email about the next steps in the eligibility process.</p>

        <a href="index.php">
            <button class="cta-btn-main" style="margin-top: 30px;">
                ← Return to Homepage
            </button>
        </a>
    </div>

    <footer>
        <p>&copy; © 2025 GreenSprout Home — Nurturing Hope and Growth for Every Child</p>
    </footer>
</body>
</html>
