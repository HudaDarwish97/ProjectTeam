<?php
// Start the session to access the logged-in user information
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in. Please log in to view your bookings.";
    exit;
}

// Fetch the logged-in user's ID from the session
$userId = $_SESSION['user_id'];

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=room_booking', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Query for the user's bookings
$query = "SELECT rooms.room_name, bookings.booking_id, booking_date, time_slot, status 
          FROM bookings 
          INNER JOIN rooms ON bookings.room_id = rooms.room_id 
          WHERE bookings.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$userBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/firstask.css">
    <title>My Bookings</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: rgb(245, 245, 220);
        margin: 0;
        padding: 0;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: rgb(87, 81, 81);
        color: white;
    }

    /* Style for the cancellation button */
    .cancel-button {
        background-color: rgb(188, 31, 31);
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .cancel-button:hover {
        background-color: rgb(255, 0, 0);
    }
</style>

</head>
<body>
    <?php include_once '../php/navbar.php'; ?>
     <h1>My Bookings</h1>
    <table>
        <thead>
            <tr>
                <th>Room Name</th>
                <th>Booking Date</th>
                <th>Time Slot</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userBookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['room_name']); ?></td>
                    <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['time_slot']); ?></td>
                    <td><?php echo htmlspecialchars($booking['status']); ?></td>
                    <td>
                        <form action="cancel_booking.php" method="POST">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                            <button type="submit" class="cancel-button">Cancel Booking</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!--footer-->
    <footer class="footer py-3">
        <div class="text-center">
            <p>&copy; 2024 IT Collage Room Booking System. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
