<?php
include 'database.php';

$query = $conn->query("SELECT id, car_number_plate, parking_spot_id, start_time, end_time, created_at FROM bookings");
$bookings = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="admin.css">
</head>
    <tr>
        <th>ID</th>
        <th>Car Number Plate</th>
        <th>Spot Number</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Booking Date</th>
    </tr>
    <?php foreach ($bookings as $booking): ?>
    <tr>
        <td><?= htmlspecialchars($booking['id']); ?></td>
        <td><?= htmlspecialchars($booking['car_number_plate']); ?></td>
        <td><?= htmlspecialchars($booking['parking_spot_id']); ?></td>
        <td><?= htmlspecialchars($booking['start_time']); ?></td>
        <td><?= htmlspecialchars($booking['end_time']); ?></td>
        <td><?= htmlspecialchars($booking['created_at']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>