<?php
// get_room_details.php

if (isset($_GET['room_id'])) {
    $roomId = $_GET['room_id'];

    // Replace with your database connection details
    $pdo = new PDO('mysql:host=localhost;dbname=booking_system', 'username', 'password');

    // Prepare the SQL query to get room details
    $stmt = $pdo->prepare('SELECT * FROM rooms WHERE room_id = :room_id');
    $stmt->execute([':room_id' => $roomId]);

    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        echo json_encode([
            'success' => true,
            'room_number' => $room['room_number'],
            'description' => $room['description']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
