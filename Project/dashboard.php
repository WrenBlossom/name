<?php
include 'database.php';

// Fetch empty parking spots
$query = $conn->query("SELECT * FROM parking_spots WHERE is_occupied = 0");
$emptySpots = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = 1; // Assume logged-in user with ID 1
    $spotId = $_POST['spot_id'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Update spot to occupied
    $conn->prepare("UPDATE parking_spots SET is_occupied = 2 WHERE id = ?")
        ->execute([$spotId]);

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, parking_spot_id, start_time, end_time) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userId, $spotId, $startTime, $endTime]);


    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <h1>Parkopedia</h1>

        <h2>Empty Parking Spots</h2>
        <ul>
            <?php foreach ($emptySpots as $spot): ?>
                <li>Spot <?= $spot['spot_number']; ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Book a Parking Spot</h2>
        <form method="POST" action="">
            <label for="spot_id">Select Spot:</label>
            <select name="spot_id" id="spot_id" required>
                <?php foreach ($emptySpots as $spot): ?>
                    <option value="<?= $spot['id']; ?>">Spot <?= $spot['spot_number']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="start_time">Start Time:</label>
            <input type="datetime-local" name="start_time" id="start_time" required>

            <label for="end_time">End Time:</label>
            <input type="datetime-local" name="end_time" id="end_time" required>

            <button type="submit">Book Spot</button>
            <button type="submit"><a href="logout.php" class="logout">Logout</a></button>
        </form>
       
    </script>
    </style>
    <script>
        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.innerText = message;
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        }
        <div id="notification" class="notification"></div>
    </script>
    </div>
</body>
</html>
