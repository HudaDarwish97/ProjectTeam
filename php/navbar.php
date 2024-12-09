<?php
if (session_status() === PHP_SESSION_NONE) {
session_start();}
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
?>

<nav class="navbar">
<div class="container">
        <a class="logo" href="<?php echo BASE_URL; ?>">
            <img src="<?php echo BASE_URL; ?>/img/img.png" alt="Roomzy">
        </a>
    <ul>
        <?php if (!$isLoggedIn): ?>
            <!-- General Header for Visitors -->
            <li><a href="<?php echo BASE_URL; ?>/index.php">Home</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/room_browsing.php">Rooms</a></li>
            <li><a href="<?php echo BASE_URL; ?>/php/login.php">Login</a></li>
            <li><a href="<?php echo BASE_URL; ?>/php/register.php">Register</a></li>

        <?php elseif ($userRole === 'User'): ?>
            <!-- Header for Regular Users -->
            <li>Welcome, <?php echo htmlspecialchars($userName); ?>!</li>

             <!-- Profile Image -->
             <?php
                // Check if user has a profile image, if not use a default one
                $profileImage = isset($_SESSION['user']['image']) && !empty($_SESSION['user']['image']) ? $_SESSION['user']['image'] : 'img/profile_pic.png';
                ?>
                <img src="<?php echo BASE_URL . '/' . $profileImage; ?>" alt="User Profile Picture" class="user-image">

            <li><a href="<?php echo BASE_URL; ?>/views/UserProfile.html">My Profile</a></li>
            <li><a href="<?php echo BASE_URL; ?>/php/logout.php">Logout</a></li>
            <li><a href="<?php echo BASE_URL; ?>/php/MyBookings.php">My Booking</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/room_browsing.php">Rooms</a></li>
            
        <?php elseif ($userRole === 'Admin'): ?>
            <!-- Header for Admin Users -->
            <li>Admin Panel</li>
            <li><a href="<?php echo BASE_URL; ?>/views/structure.html">Dashbored</a></li>
            <li><a href="<?php echo BASE_URL; ?>/php/bookings_report.php">Reports</a></li>
            <li><a href="<?php echo BASE_URL; ?>/php/logout.php">Logout</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/room_browsing.php">Rooms</a></li>
        <?php endif; ?>
    </ul>
</nav>
