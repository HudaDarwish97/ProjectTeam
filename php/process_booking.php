<?php
session_start();

try {
    $dsn = "mysql:host=localhost;port=3306;dbname=room_booking;charset=utf8mb4";
    $conn = new PDO($dsn, "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "You need to log in to confirm the booking.";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $room_id = 1; // Assume room ID is provided dynamically in a real system.
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Validate booking time
    if (strtotime($start_time) < strtotime('08:00') || strtotime($end_time) > strtotime('23:00')) {
        echo "Invalid booking time. Time should be between 8:00 AM and 11:00 PM.";
        exit;
    }

    // Check for conflicts
    $query = "
        SELECT * FROM bookings 
        WHERE room_id = :room_id 
          AND booking_date = :booking_date 
          AND (time_slot BETWEEN :start_time AND :end_time 
               OR :start_time BETWEEN time_slot AND ADDTIME(time_slot, '01:00:00'))
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':room_id' => $room_id,
        ':booking_date' => $booking_date,
        ':start_time' => $start_time,
        ':end_time' => $end_time
    ]);

    if ($stmt->rowCount() > 0) {
        echo "The selected time slot is not available. Please choose another slot.";
    } else {
        // Insert booking
        $insert_query = "
            INSERT INTO bookings (user_id, room_id, booking_date, time_slot, status) 
            VALUES (:user_id, :room_id, :booking_date, :time_slot, 'Pending')
        ";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->execute([
            ':user_id' => $user_id,
            ':room_id' => $room_id,
            ':booking_date' => $booking_date,
            ':time_slot' => $start_time
        ]);
        echo "Booking confirmed successfully.";
    }
}
?>
