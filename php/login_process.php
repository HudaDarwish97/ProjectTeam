<?php

// Start session if not already started
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once dirname(__DIR__) . '/php/config.php';

// Collect POST data
$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare the SQL query to fetch the user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    // Fetch user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // If no user found, set error message and redirect
        $_SESSION['error'] = "Invalid email or password";
        header("Location: " . BASE_URL . "/login.php");
        exit();
    }

    // Verify the password (use password_verify for hashed password)
    if (!password_verify($password, $user['password'])) {
        // If password does not match, set error message and redirect
        $_SESSION['error'] = "Invalid email or password";
        header("Location: " . BASE_URL . "/login.php");
        exit();
    }

    // If credentials are valid, set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on user role
    if ($user['role'] === 'admin') {
        header("Location: " . BASE_URL . "/admin_dashboard.php"); // Admin dashboard
    } else {
        header("Location: " . BASE_URL . "/user_dashboard.php"); // User dashboard
    }
    exit();

} catch (PDOException $e) {
    // Handle any errors by setting error message in session and redirecting
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header("Location: " . BASE_URL . "/login.php");
    exit();
}

?>

    
