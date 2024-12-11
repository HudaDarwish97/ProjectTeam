<?php
// get_room_details.php

if (isset($_GET['room_id'])) {
    $roomId = $_GET['room_id'];

    // Database connection
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=room_booking', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // Prepare the SQL query to get room details
    $stmt = $pdo->prepare('SELECT * FROM rooms WHERE room_id = :room_id');
    $stmt->execute([':room_id' => $roomId]);

    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        echo json_encode([
            'success' => true,
            'room_number' => $room['room_name'],
            'description' => $room['description'],
            'capacity' => $room['capacity'],
            'availability' => $room['availability_status']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
