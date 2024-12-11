<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $roomId = $_POST['room_id'];
    $date = $_POST['date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Database connection
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=room_booking', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // Insert booking into the database
    $query = "INSERT INTO bookings (user_id, room_id, booking_date, time_slot, status) VALUES (:user_id, :room_id, :date, :time_slot, 'Confirmed')";
    $stmt = $pdo->prepare($query);
    $timeSlot = $startTime . '-' . $endTime; // Format time slot
    $stmt->execute([
        ':user_id' => $userId,
        ':room_id' => $roomId,
        ':date' => $date,
        ':time_slot' => $timeSlot
    ]);

    echo json_encode(['success' => true]);
}
?> 