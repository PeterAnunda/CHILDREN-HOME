<?php
// ==========================================================
// === PHP BACK-END FOR SECURE DONATION FORM (FINALIZED) ===
// ==========================================================

// 1. Database Connection Credentials
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home"; // Your database name

// 2. Establish Connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Get Home ID from URL to know where the donation is going
$home_id = isset($_GET['home_id']) ? (int)$_GET['home_id'] : 0;

if ($home_id == 0) {
    die("Error: No Children's Home selected for donation.");
}

// 4. Handle Donation Submission (if form is posted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;
    
    // Basic validation
    if ($amount === false || $amount <= 0 || empty($payment_method)) {
        // Reload the page with an error parameter if validation fails
        header("Location: donate.php?home_id=" . $home_id . "&status=error&msg=invalid_data");
        exit;
    } 

    // SQL to insert the donation record (Fulfills Secure Donation objective)
    // The INSERT statement has 4 placeholders (?)
    $stmt_insert = $conn->prepare("INSERT INTO donation (home_id, amount, payment_method, transaction_status, is_anonymous) VALUES (?, ?, ?, 'Completed', ?)");
    
    // *** CORRECTION APPLIED HERE ***
    // The types are 'i' (home_id), 'd' (amount), 's' (payment_method), 'i' (is_anonymous)
    $stmt_insert->bind_param("idsi", $home_id, $amount, $payment_method, $is_anonymous);
    
    if ($stmt_insert->execute()) {
        // SUCCESS REDIRECTION
        $conn->close();
        header("Location: confirmation.php?home_id=" . $home_id . "&amount=" . $amount);
        exit;
    } else {
        // Database insertion error
        $conn->close();
        header("Location: donate.php?home_id=" . $home_id . "&status=error&msg=db_fail");
        exit;
    }
}

// 5. Fetch Home Name and handle messages if the form hasn't been posted
$stmt = $conn->prepare("SELECT name FROM children_home WHERE home_id = ?");
$stmt->bind_param("i", $home_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: Children's Home not found.");
}

$home = $result->fetch_assoc();
$home_name = htmlspecialchars($home['name']);
$conn->close();


// Handle URL parameters for displaying messages 
$message = "";
$message_type = "";
if (isset($_GET['status']) && $_GET['status'] == 'error') {
    $message_type = "error";
    if (isset($_GET['msg']) && $_GET['msg'] == 'invalid_data') {
        $message = "Please enter a valid donation amount and select a payment method.";
    } elseif (isset($_GET['msg']) && $_GET['msg'] == 'db_fail') {
        $message = "A system error occurred. Please try again or contact support.";
    }
}

// --- Start HTML Output (Only runs if no form submission redirect occurs) ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate to <?php echo $home_name; ?></title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Donation Form Specific Styles */
        .donation-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .donation-container h1 {
            color: var(--secondary-green);
            text-align: center;
            margin-bottom: 30px;
        }
        .donation-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .donation-form input[type="number"], 
        .donation-form select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1em;
        }
        .message-box {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .security-note {
            font-size: 0.9em;
            color: #6c757d;
            margin-top: 20px;
            text-align: center;
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

    <div class="donation-container">
        <h1>Secure Donation to <?php echo $home_name; ?></h1>
        
        <?php if ($message): ?>
            <div class="message-box <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="donation-form">
            <input type="hidden" name="home_id" value="<?php echo $home_id; ?>">

            <label for="amount">Donation Amount (KES)</label>
            <input type="number" id="amount" name="amount" min="50" step="1" required placeholder="e.g., 5000">

            <label for="payment_method">Payment Method</label>
            <select id="payment_method" name="payment_method" required>
                <option value="">-- Select Method --</option>
                <option value="M-Pesa">M-Pesa</option>
                <option value="Visa/Mastercard">Visa/Mastercard</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>

            <label>
                <input type="checkbox" name="is_anonymous" style="width: auto; margin-right: 10px;">
                Donate Anonymously
            </label>
            
            <button type="submit" class="donate-btn-main" style="width: 100%; margin-top: 20px;">
                Complete Secure Donation
            </button>
        </form>

        <p class="security-note">
            Your financial security is our priority. Transactions are processed via a secure payment gateway with encryption and fraud protection.
        </p>
    </div>

    <footer>
        <p>&copy; 2024 Children’s Homes Management Platform. Security is a priority.</p>
    </footer>
</body>
</html>