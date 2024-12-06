<?php
session_start();
include 'db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $users;
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // In a real application, you'd save this to a database
    $users[$username] = $hashed_password;
    
    $_SESSION['registration_success'] = "Registration successful. You can now log in.";
    header("Location: login.php");
    exit();
}
?>
