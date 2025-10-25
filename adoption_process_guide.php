<?php
// PHP logic (now empty, as the authorization check is removed)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adoption Requirements Guide</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .guide-container { max-width: 900px; margin: 50px auto; padding: 40px; background-color: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .guide-container h1 { color: var(--primary-blue); border-bottom: 3px solid var(--secondary-green); padding-bottom: 10px; margin-bottom: 30px; text-align: center;}
        .step { margin-bottom: 30px; padding: 15px; border-left: 5px solid var(--primary-blue); background-color: #f8f9fa; border-radius: 4px; }
        .step h3 { color: var(--secondary-green); margin-bottom: 10px; font-size: 1.5em; }
        .step ul { margin-left: 20px; }
    </style>
</head>
<body>
    <header>
        <div class="logo">GreenSprout Home</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="directory.php">Directory</a>
            <a href="volunteer_form.php">Apply to Volunteer</a>
        </nav>
        <a href="directory.php" class="header-action-btn"><button class="donate-btn-header">DONATE SECURELY</button></a>
    </header>

    <div class="guide-container">
        <h1>Detailed Adoption Requirements & Process</h1>
        <p class="summary" style="text-align: center; margin-bottom: 40px;">This guide centralizes all legal and platform-specific requirements, fulfilling the objective to simplify the legal process for prospective parents.</p>

        <div class="step">
            <h3>Step 1: Eligibility Checker & Initial Inquiry</h3>
            <p>Prospective parents must first pass the platform's automated eligibility check. This tool screens for basic legal constraints.</p>
            <ul>
                <li>Must be a resident citizen (or proven legal status).</li>
                <li>Minimum age requirement (varies by jurisdiction).</li>
                <li>Marital status validation (if applicable).</li>
            </ul>
        </div>

        <div class="step">
            <h3>Step 2: Document Submission Portal</h3>
            <p>Once preliminary eligibility is confirmed, the system activates the document submission portal. All documents must be uploaded and verified by a platform administrator.</p>
            <ul>
                <li>Certified copy of national ID/Passport.</li>
                <li>Proof of income/Financial stability.</li>
                <li>Health clearance certificates.</li>
                <li>Police/Background check reports.</li>
            </ul>
        </div>

        <div class="step">
            <h3>Step 3: Home Study and Social Worker Review</h3>
            <p>A social worker assigned through the platform will conduct a mandatory physical home study and in-depth interview to assess readiness, environment, and motivations.</p>
        </div>

        <div class="step">
            <h3>Step 4: Court Process and Finalization</h3>
            <p>Upon satisfactory review and approval by the platform/agency, the case is moved to the legal system for finalization and issuance of the adoption order.</p>
        </div>
        <div style="text-align: center; margin-top: 50px;">
            <p style="font-size: 1.2em; font-weight: 600; color: var(--primary-blue); margin-bottom: 20px;">
                Ready to take the next step?
            </p>
           <a href="adoption_application_form.php">
    <button class="donate-btn-main" style="background-color: var(--secondary-green); padding: 15px 40px; font-size: 1.1em;">
        Start Adoption Application →
    </button>
</a>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php">
                <button class="cta-btn-main" style="background-color: var(--primary-blue);">← Return to Homepage</button>
            </a>
        </div>
    </div>
</body>
</html>
       