<?php
// check_conflicts.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['start_time'] ?? '';
    $endTime = $_POST['end_time'] ?? '';

    // Assuming you have a database connection set up here
    // Replace the following with your actual database connection details
    $pdo = new PDO('mysql:host=localhost;dbname=booking_system', 'username', 'password');

    // Prepare the SQL query to check for conflicting bookings
    $stmt = $pdo->prepare('SELECT * FROM bookings WHERE date = :date AND (start_time < :endTime AND end_time > :startTime)');
    $stmt->execute([
        ':date' => $date,
        ':startTime' => $startTime,
        ':endTime' => $endTime
    ]);

    $conflict = $stmt->rowCount() > 0; // If there are any rows, there is a conflict

    echo json_encode(['hasConflict' => $conflict]);
}
?>
