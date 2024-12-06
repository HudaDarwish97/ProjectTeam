<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $users;

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // In a real application, you'd save this to a database instead of a session variable
    // You can either insert the user in your users table or store them in a session for testing

    // Example with a database insertion
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    
    if ($stmt->execute()) {
        $_SESSION['registration_success'] = "Registration successful. You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['registration_error'] = "Registration failed. Please try again.";
    }
}
?>

