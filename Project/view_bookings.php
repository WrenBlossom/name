<?php
include 'database.php';
session_start();

// Restrict access to admins only
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

try {
    // Prepare statement to fetch all bookings
    $stmt = $conn->prepare("
        SELECT b.id, u.name AS user_name, u.email, ps.spot_number, b.start_time, b.end_time, b.created_at
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN parking_spots ps ON b.parking_spot_id = ps.id
        ORDER BY b.created_at DESC
    ");
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard">
        <h1>All Bookings</h1>
        <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Spot Number</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Booking Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($bookings): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['id']); ?></td>
                            <td><?= htmlspecialchars($booking['user_name']); ?></td>
                            <td><?= htmlspecialchars($booking['email']); ?></td>
                            <td><?= htmlspecialchars($booking['spot_number']); ?></td>
                            <td><?= htmlspecialchars($booking['start_time']); ?></td>
                            <td><?= htmlspecialchars($booking['end_time']); ?></td>
                            <td><?= htmlspecialchars($booking['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No bookings found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
