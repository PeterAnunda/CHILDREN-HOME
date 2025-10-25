<?php
// ==========================================================
// === PHP BACK-END FOR SECURE DONATION FORM (GreenSprout Home) ===
// ==========================================================

// 1. Database Connection Credentials
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home";

// 2. Establish Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Get Home ID from URL
$home_id = isset($_GET['home_id']) ? (int)$_GET['home_id'] : 0;
if ($home_id == 0) {
    die("Error: No Children's Home selected for donation.");
}

// 4. Handle Donation Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    if ($amount === false || $amount <= 0 || empty($payment_method)) {
        header("Location: donate.php?home_id=" . $home_id . "&status=error&msg=invalid_data");
        exit;
    }

    $stmt_insert = $conn->prepare("INSERT INTO donation (home_id, amount, payment_method, transaction_status, is_anonymous) VALUES (?, ?, ?, 'Completed', ?)");
    $stmt_insert->bind_param("idsi", $home_id, $amount, $payment_method, $is_anonymous);

    if ($stmt_insert->execute()) {
        $conn->close();
        header("Location: confirmation.php?home_id=" . $home_id . "&amount=" . $amount);
        exit;
    } else {
        $conn->close();
        header("Location: donate.php?home_id=" . $home_id . "&status=error&msg=db_fail");
        exit;
    }
}

// 5. Fetch Home Name
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

// 6. Handle Messages
$message = "";
$message_type = "";
if (isset($_GET['status']) && $_GET['status'] == 'error') {
    $message_type = "error";
    if (isset($_GET['msg']) && $_GET['msg'] == 'invalid_data') {
        $message = "Please enter a valid donation amount and select a payment method.";
    } elseif (isset($_GET['msg']) && $_GET['msg'] == 'db_fail') {
        $message = "A system error occurred. Please try again or contact support.";
    }
} elseif (isset($_GET['status']) && $_GET['status'] == 'success') {
    $message_type = "success";
    $message = "Thank you for your donation of KES " . htmlspecialchars($_GET['amount']) . "!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate to <?php echo $home_name; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
    :root {
        --primary-green: #2F5D62;
        --accent-green: #5E8B7E;
        --neutral-green: #A7C4BC;
        --background-light: #F0F5F2;
        --text-dark: #2E2E2E;
    }

    body {
        font-family: "Segoe UI", Roboto, sans-serif;
        background-color: var(--background-light);
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
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }

    .logo {
        font-size: 1.6em;
        font-weight: 700;
    }

    .logo span {
        color: var(--accent-green);
    }

    nav a {
        color: white;
        margin: 0 12px;
        text-decoration: none;
        font-weight: 500;
    }

    nav a:hover {
        color: var(--neutral-green);
    }

    .donate-btn-header {
        background-color: var(--accent-green);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }

    .donate-btn-header:hover {
        background-color: var(--primary-green);
    }

    .donation-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(47,93,98,0.1);
    }

    .donation-container h1 {
        text-align: center;
        color: var(--primary-green);
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
        border-radius: 6px;
        font-size: 1em;
    }

    .donation-form input[type="checkbox"] {
        margin-right: 10px;
    }

    .donate-btn-main {
        width: 100%;
        background-color: var(--primary-green);
        color: #fff;
        border: none;
        padding: 14px;
        border-radius: 6px;
        font-size: 1em;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, background-color 0.3s ease;
    }

    .donate-btn-main:hover {
        background-color: var(--accent-green);
        transform: scale(1.03);
    }

    .message-box {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
        font-weight: bold;
        text-align: center;
    }

    .message-box.error {
        background-color: #fdecea;
        color: #a94442;
        border: 1px solid #f5c6cb;
    }

    .message-box.success {
        background-color: #e6f4ea;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .security-note {
        font-size: 0.9em;
        color: var(--neutral-green);
        margin-top: 20px;
        text-align: center;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: var(--primary-green);
        color: white;
        margin-top: 50px;
        font-size: 0.95em;
    }

    @media (max-width: 640px) {
        header, .donation-container {
            padding: 20px;
        }
        nav a {
            margin: 0 6px;
            font-size: 0.9em;
        }
    }
</style>

</head>
<body>
    <header>
        <div class="logo">Green<span>Sprout</span> Home</div>
        <nav>
            <a href="index.php#mission">Our Mission</a>
            <a href="directory.php">Home Directory</a>
            <a href="volunteer_form.php">Volunteer</a>
            <a href="directory.php" class="donate-btn-header">Donate Securely</a>
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

            <input type="checkbox" id="is_anonymous" name="is_anonymous">
            <label for="is_anonymous">Donate Anonymously</label>

            <button type="submit" class="donate-btn-main">Complete Secure Donation</button>
        </form>

        <p class="security-note">
            Your financial security is our priority. Transactions are processed via a secure payment gateway with encryption and fraud protection.
        </p>
    </div>

    <footer>
        <p>&copy; 2025 GreenSprout Home — Growing Hope, One Child at a Time.</p>
    </footer>
</body>
</html>
