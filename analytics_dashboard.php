<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Analytics Dashboard</title>
</head>
<body>
<div class="container my-5">
    <h2>Room Popularity</h2>
    <canvas id="popularityChart"></canvas>
</div>
<script>
    const ctx = document.getElementById('popularityChart').getContext('2d');
    const chartData = {
        labels: <?= json_encode(array_column($roomUsage, 'room_name')) ?>,
        datasets: [{
            label: 'Bookings',
            data: <?= json_encode(array_column($roomUsage, 'usage_count')) ?>,
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
