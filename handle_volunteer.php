<?php
// =========================================================
// === PHP BACK-END FOR VOLUNTEER APPLICATION SUBMISSION ===
// =========================================================

// 1. Database Connection Credentials
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home"; 

// --- CONFIGURATION: SET THE RECIPIENT EMAIL HERE (FOR LOGGING PURPOSES) ---
$manager_email = "anundapeter46@gmail.com"; 
// -------------------------------------------------------------------------

// 2. Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

// 3. Collect and sanitize form data
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$interest = filter_input(INPUT_POST, 'interest', FILTER_SANITIZE_STRING);
$home_id = filter_input(INPUT_POST, 'home_id', FILTER_VALIDATE_INT);
$start_date = filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING);
$end_date = filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING);

// 4. Basic Validation
if (empty($name) || empty($email) || empty($interest) || empty($start_date) || empty($end_date) || $home_id === false || $home_id <= 0) {
    header("Location: volunteer_form.php?volunteer_status=error&msg=missing_fields");
    exit;
}

// 5. Establish Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    header("Location: volunteer_form.php?volunteer_status=error&msg=db_fail");
    exit;
}

// 6. Insert Application Data (Check for prepare failure)
$stmt = $conn->prepare("INSERT INTO volunteer_applications (home_id, applicant_name, email, interest_area, preferred_start_date, preferred_end_date) VALUES (?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    $conn->close();
    header("Location: volunteer_form.php?volunteer_status=error&msg=db_prepare_fail");
    exit;
}

// The type definition string is 'isssss'
$stmt->bind_param("isssss", $home_id, $name, $email, $interest, $start_date, $end_date);

if ($stmt->execute()) {
    // --- DATABASE SUCCESS: PROCEED WITH LOGGING THE EMAIL CONTENT ---
    
    // Attempt to fetch the home name for the log file
    $home_name = "Unknown Home";
    $stmt_home = $conn->prepare("SELECT name FROM children_home WHERE home_id = ?");
    $stmt_home->bind_param("i", $home_id);
    $stmt_home->execute();
    $result_home = $stmt_home->get_result();
    if ($result_home->num_rows > 0) {
        $row = $result_home->fetch_assoc();
        $home_name = $row['name'];
    }

    $conn->close(); // Close connection after all DB ops are done
    
    // --- 7. FILE LOGGING MECHANISM (Proof of Notification) ---
    $email_subject = "NEW Volunteer Application: " . $name . " for " . $home_name;
    
    $log_content = "\n\n==== APPLICATION LOG: " . date("Y-m-d H:i:s") . " ====\n";
    $log_content .= "RECIPIENT: " . $manager_email . "\n";
    $log_content .= "SUBJECT: " . $email_subject . "\n";
    $log_content .= "------------------------------------------------\n";
    $log_content .= "Applicant Name: " . $name . "\n";
    $log_content .= "Applicant Email: " . $email . "\n";
    $log_content .= "Organization: " . $home_name . "\n";
    $log_content .= "Interests/Skills: " . $interest . "\n";
    $log_content .= "Commitment: From " . $start_date . " to " . $end_date . "\n";
    $log_content .= "STATUS: Notification Written to File.\n";
    $log_content .= "================================================\n";

    // Write the email content to a file in the project directory
    $log_file = __DIR__ . "/email_notifications.log";
    file_put_contents($log_file, $log_content, FILE_APPEND | LOCK_EX);
    
    // --- END FILE LOGGING ---
    
    // SUCCESS REDIRECTION
    header("Location: volunteer_success.php?name=" . urlencode($name) . "&email=" . urlencode($email) . "&home_id=" . $home_id);
    exit;
    
} else {
    // --- DATABASE INSERTION ERROR ---
    $conn->close();
    header("Location: volunteer_form.php?volunteer_status=error&msg=db_insert_fail");
    exit;
}
?>