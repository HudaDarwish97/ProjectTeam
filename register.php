<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and trim input data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']); // Confirm password field
    $role = trim($_POST['role']);
    $email = trim($_POST['email']); // Adding email if needed

    // Basic validation to ensure fields are not empty
    if (empty($username) || empty($password) || empty($confirmPassword) || empty($role) || empty($email)) {
        $_SESSION['registration_error'] = "All fields are required.";
        header("Location: register.php");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['registration_error'] = "Passwords do not match.";
        header("Location: register.php");
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashed_password, $role, $email);

    if ($stmt->execute()) {
        $_SESSION['registration_success'] = "Registration successful. You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['registration_error'] = "Registration failed. Please try again.";
        header("Location: register.php");
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
