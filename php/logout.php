<?php
require_once 'config.php';

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = '';
$userRole = '';

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $query = "SELECT user_name, user_role FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($userName, $userRole);
    $stmt->fetch();
    $stmt->close();
}
$conn->close();

// No need to call session_start() again if it's already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

session_unset(); // Clear session variables
session_destroy(); // Destroy the session

header('Location: ' . BASE_URL . '/php/login.php');
exit();

?>
