// ===============================================
// === Children's Homes Platform Interaction JS ===
// ===============================================

// 1. Get references to the HTML elements
const loginForm = document.getElementById('loginForm');
const formMessage = document.getElementById('formMessage');
const mainCtaBtn = document.getElementById('mainCtaBtn'); 

// 2. Define the function for the 'View Homes Directory' button
function viewDirectory() {
    window.location.href = 'directory.php'; 
}

// 3. Attach the event listener for the Directory button
mainCtaBtn.addEventListener('click', viewDirectory);

// --- LOGIN SIMULATION REMOVED ---
// We now rely on 'login_process.php' for authentication. 

// The loginForm listener is also removed because the form now submits directly to PHP.
// We can add a simple front-end validation check here if needed, but the core logic moves to PHP.

// Optional: Display error messages from PHP redirection
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('login_error');
    if (error) {
        formMessage.style.color = 'red';
        if (error === 'invalid_credentials') {
            formMessage.textContent = 'Login Failed: Invalid email or password.';
        } else if (error === 'missing_fields') {
            formMessage.textContent = 'Login Failed: Please enter both email and password.';
        } else {
             formMessage.textContent = 'An unknown login error occurred.';
        }
    }
});