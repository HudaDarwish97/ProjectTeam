<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in. Please log in to cancel your bookings.";
    exit;
}

// Fetch the booking ID from the POST request
if (isset($_POST['booking_id'])) {
    $bookingId = $_POST['booking_id'];
    $userId = $_SESSION['user_id'];

    // Database connection
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=room_booking', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // Prepare the cancellation query
    $query = "DELETE FROM bookings WHERE booking_id = :booking_id AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['booking_id' => $bookingId, 'user_id' => $userId]);

    // Redirect back to MyBookings page with a success message
    header("Location: MyBookings.php?message=Booking cancelled successfully.");
    exit;
} else {
    echo "No booking ID provided.";
}
?>
