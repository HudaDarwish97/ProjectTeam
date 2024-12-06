<?php
session_start();

include 'db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (isset($users[$username])) {
        // Verify the password
        if (password_verify($password, $users[$username])) {
            // Authentication successful
            $_SESSION['user_id'] = $username; // In reality, this would be a unique user ID
            $_SESSION['username'] = $username;
            header("Location: protected_page.php");
            exit();
        }
    }
    
    // Authentication failed
    $_SESSION['login_error'] = "Invalid username or password";
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>