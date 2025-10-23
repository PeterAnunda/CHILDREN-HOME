<?php
session_start(); // Start the session for user authentication

// 1. Database Connection Credentials
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "children_home"; // Your database name

// 2. Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.html");
    exit;
}

// 3. Collect and sanitize form data
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password_input = $_POST['password']; // Raw password input

// 4. Basic Validation
if (empty($email) || empty($password_input)) {
    header("Location: index.html?login_error=missing_fields");
    exit;
}

// 5. Establish Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    header("Location: index.html?login_error=db_connection_fail");
    exit;
}

// 6. Fetch User Data (using prepared statement for security)
$stmt = $conn->prepare("SELECT user_id, password_hash, role FROM users WHERE email = ?");

// Check if the prepare statement failed (e.g., table 'users' doesn't exist)
if ($stmt === false) {
    // For production, you'd log the $conn->error. For prototype, redirect:
    $conn->close();
    header("Location: index.html?login_error=db_prepare_fail"); // Using db_prepare_fail for clarity
    exit;
}

// 7. Bind parameters and execute the query
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    // **PROTOTYPE HACK: Assuming successful login**
    
    // 8. Set Session Variables (Role-Based Access Control)
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = $user['role']; 
    
    // 9. Role-Based Redirection
    $dashboard = 'index.html'; // Default redirect

    if ($user['role'] == 'Admin' || $user['role'] == 'Home_Manager') {
        $dashboard = 'admin_dashboard.php'; 
    } elseif ($user['role'] == 'Donor' || $user['role'] == 'Volunteer') {
        $dashboard = 'user_dashboard.php'; 
    }
    
    $conn->close();
    header("Location: $dashboard"); // Redirect to the appropriate dashboard
    exit;
    
} else {
    // --- AUTHENTICATION FAILURE ---
    $conn->close();
    header("Location: index.html?login_error=invalid_credentials");
    exit;
}
?>