<?php
// Fetch user bookings
$userId = 1; // Replace with the logged-in user's ID
$query = "SELECT rooms.room_name, booking_date, start_time, end_time 
          FROM bookings 
          INNER JOIN rooms ON bookings.room_id = rooms.room_id 
          WHERE bookings.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$userBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container my-5">
    <h2>My Bookings</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Room Name</th>
            <th>Booking Date</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($userBookings as $booking): ?>
            <tr>
                <td><?= htmlspecialchars($booking['room_name']) ?></td>
                <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                <td><?= htmlspecialchars($booking['start_time']) ?></td>
                <td><?= htmlspecialchars($booking['end_time']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
