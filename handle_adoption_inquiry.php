<?php
// =========================================================
// === PHP BACK-END FOR ADOPTION INQUIRY SUBMISSION (FINAL) ===
// =========================================================

// 1. Database Connection Credentials
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home"; 

// 2. Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

// 3. Collect and sanitize form data
$family_name = filter_input(INPUT_POST, 'family_name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

// Collect optional Home ID input
$home_id_input = $_POST['target_home_id'] ?? ''; 
$target_home_id = filter_input(INPUT_POST, 'target_home_id', FILTER_VALIDATE_INT);

// 4. Determine if a Home was selected (The FIX Logic)
$home_selected = ($target_home_id !== false && $target_home_id > 0);

// 5. Basic Validation
if (empty($family_name) || empty($email)) {
    header("Location: adoption_application_form.php?status=error&msg=missing_fields");
    exit;
}

// 6. Establish Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    header("Location: adoption_application_form.php?status=error&msg=db_fail");
    exit;
}

// 7. Conditional Insertion Logic
$success = false;

if ($home_selected) {
    // === OPTION A: HOME SELECTED (Standard Binding) ===
    $sql = "INSERT INTO adoption_inquiries (family_name, email, target_home_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        $conn->close();
        header("Location: adoption_application_form.php?status=error&msg=db_prepare_fail");
        exit;
    }
    
    // Type string 'ssi' for (String, String, Integer)
    $stmt->bind_param("ssi", $family_name, $email, $target_home_id);
    
    if ($stmt->execute()) { // This should work for valid IDs
        $success = true;
    }
    
} else {
    // === OPTION B: NO PREFERENCE (Explicit NULL SQL) ===
    // This SQL skips the target_home_id column and explicitly tells MySQL to insert NULL.
    $sql = "INSERT INTO adoption_inquiries (family_name, email) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        $conn->close();
        header("Location: adoption_application_form.php?status=error&msg=db_prepare_fail_null");
        exit;
    }
    
    // Type string 'ss' for (String, String)
    $stmt->bind_param("ss", $family_name, $email);
    
    if ($stmt->execute()) { // This will work because the column defaults to NULL
        $success = true;
    }
}

// 8. Final Redirection
$conn->close();

if ($success) {
    header("Location: adoption_inquiry_success.php?family=" . urlencode($family_name));
    exit;
} else {
    // This catches the failed execute() call if the foreign key validation failed, 
    // ensuring the user sees the error.
    header("Location: adoption_application_form.php?status=error&msg=db_insert_fail");
    exit;
}
?>