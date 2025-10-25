<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centralized Children's Support Hub</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

    <header>
        <div class="logo">GreenSprout Home</div>
        <nav>
            <a href="#mission">Our Mission</a>
            <a href="#features">Features</a>
            <a href="adoption_process_guide.php">Apply for Adoption</a> 
            <a href="volunteer_form.php">Apply to Volunteer</a> 
        </nav>
        <a href="directory.php" class="header-action-btn"><button class="donate-btn-header">DONATE SECURELY</button></a>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>A Unified Digital Platform for Children’s Shelters</h1>
            <p>Streamlining support, enhancing transparency, and connecting homes with donors, volunteers, and adoptive families.</p><br>
            <button id="mainCtaBtn" class="cta-btn-main">View Homes Directory</button>
        </div>
    </section>

    <section class="mission" id="mission">
        <h2>Bridging the Support Gap</h2>
        <p class="summary">Many institutions, like Happy Life Children’s Home, face significant challenges including limited funding, low visibility, and fragmented communication systems. This platform addresses the lack of a unified system that currently results in disjointed, inefficient engagement with supporters.</p>
        <br>
        <div class="mission-cards">
            <div class="card">
                <h3>Visibility</h3>
                <p>A searchable directory helps users find homes based on location and needs.</p>
            </div>
            <div class="card">
                <h3>Transparency</h3>
                <p>Secure payment and data validation algorithms build trust with donors.</p>
            </div>
            <div class="card">
                <h3>Efficiency</h3>
                <p>Streamlined tools for adoption, volunteering, and donations centralize all support activities.</p>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <h2>Key Platform Features</h2>
        <div class="mission-cards"> 
            <div class="card" style="flex: 0 1 calc(50% - 20px);">
                <h3>1. Searchable Home Directory</h3>
                <p>Find children's homes based on location, services, and specific needs using a simple search tool.</p>
            </div>
            <div class="card" style="flex: 0 1 calc(50% - 20px);">
                <h3>2. Secure Donation Gateway</h3>
                <p>Facilitate secure financial contributions with encryption, fraud protection, and real-time transaction records.</p>
            </div>
            <div class="card" style="flex: 0 1 calc(50% - 20px);">
                <h3>3. Streamlined Adoption Process</h3>
                <p>Detailed adoption guidelines, eligibility checkers, and a document submission portal to simplify the legal process.</p>
            </div>
            <div class="card" style="flex: 0 1 calc(50% - 20px);">
                <h3>4. Volunteer Management</h3>
                <p>Tools for coordinating and tracking volunteer activities and schedules.</p>
            </div>
        </div>
    </section>

    <section id="volunteer-cta-block" style="background-color: var(--neutral-gray); padding: 60px 5%;">
        <div style="max-width: 900px; margin: 0 auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 10px;">Lend a Helping Hand Today</h2>
            <p style="font-size: 1.4em; color: var(--text-dark); margin-bottom: 30px;">
                Your skills matter. Become a vital part of a child's development journey by applying to volunteer at a verified home.
            </p>
            
            <a href="volunteer_form.php">
                <button class="cta-btn-main" style="padding: 18px 45px; font-size: 1.5em; border-radius: 5px;">
                    Start Your Volunteer Application →
                </button>
            </a>
        </div>
    </section>
    
    <footer>
        <p>&copy;© 2025 GreenSprout Home — Nurturing Hope and Growth for Every Child</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>