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
            'html' => '<div class="card">
                          <div class="card-body">
                            <h2 class="card-title">' . htmlspecialchars($room['room_name']) . '</h2>
                            <hr style="border-top: 2px solid #1abc9c;"/>
                            <p><strong>Type:</strong> ' . (isset($room['type']) ? htmlspecialchars($room['type']) : 'N/A') . '</p>
                            <p><strong>Department:</strong> ' . htmlspecialchars($room['department']) . '</p>
                            <p><strong>Floor:</strong> ' . htmlspecialchars($room['floor']) . '</p>
                            <p><strong>Capacity:</strong> ' . htmlspecialchars($room['capacity']) . '</p>
                            <p><strong>Description:</strong> ' . htmlspecialchars($room['description']) . '</p>
                          </div>
                       </div>'
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
