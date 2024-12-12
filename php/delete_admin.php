<?php
require 'db_connection.php'; // Include database connection

try {
    // Establish PDO connection
    $pdo = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the id is passed in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $booking_id = intval($_GET['id']); // Convert id to integer

        // Prepare and execute the DELETE query
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE booking_id = :booking_id");
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Record with Booking ID $booking_id deleted successfully.</p>";
        } else {
            echo "<p style='color: red;'>Failed to delete the record with Booking ID $booking_id.</p>";
        }
    } else {
        echo "<p style='color: red;'>Invalid Booking ID.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
<a href="IS_DETAILS.php">Go Back</a>
