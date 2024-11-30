<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');

// Fetch room usage statistics
$query = "SELECT rooms.room_name, COUNT(bookings.booking_id) AS usage_count 
          FROM bookings 
          INNER JOIN rooms ON bookings.room_id = rooms.room_id 
          GROUP BY bookings.room_id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$roomUsage = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Room Usage Report</title>
</head>
<body>
<div class="container my-5">
    <h1>Room Usage Report</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Room Name</th>
            <th>Usage Count</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($roomUsage as $room): ?>
            <tr>
                <td><?= htmlspecialchars($room['room_name']) ?></td>
                <td><?= htmlspecialchars($room['usage_count']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
