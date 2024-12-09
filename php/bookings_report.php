<?php
// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=room_booking', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch room usage statistics
$query = "SELECT rooms.room_name, COUNT(bookings.booking_id) AS usage_count 
          FROM bookings 
          INNER JOIN rooms ON bookings.room_id = rooms.room_id 
          WHERE bookings.status = 'Confirmed' 
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
    <title>Room Booking Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(245, 245, 220);
            color: #333;
        }
        header {
            background-color: rgb(87, 81, 81);
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        h2 {
            color: rgb(87, 81, 81);
            text-align: center;
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
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .chart-container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Reporting & Analytics</h1>
    </header>

    <section>
        <h2>Room Usage Report</h2>
        <table>
            <tr>
                <th>Room Name</th>
                <th>Usage Count</th>
            </tr>
            <?php foreach ($roomUsage as $room): ?>
                <tr>
                    <td><?php echo htmlspecialchars($room['room_name']); ?></td>
                    <td><?php echo htmlspecialchars($room['usage_count']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <section class="chart-container">
        <h2>Room Popularity</h2>
        <canvas id="popularityChart"></canvas>
    </section>

    <script>
        const ctx = document.getElementById('popularityChart').getContext('2d');
        const chartData = {
            labels: <?php echo json_encode(array_column($roomUsage, 'room_name')); ?>,
            datasets: [{
                label: 'Bookings',
                data: <?php echo json_encode(array_column($roomUsage, 'usage_count')); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });
    </script>
</body>
</html>
