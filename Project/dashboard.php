<?php
include 'database.php';

// Fetch empty parking spots
$query = $conn->query("SELECT * FROM parking_spots WHERE is_occupied = 0");
$emptySpots = $query->fetchAll(PDO::FETCH_ASSOC);

// Fetch accepted (booked) spots
$bookedQuery = $conn->query("SELECT * FROM parking_spots WHERE is_occupied = 2");
$bookedSpots = $bookedQuery->fetchAll(PDO::FETCH_ASSOC);

// Fetch total parking spots
$totalSpotsQuery = $conn->query("SELECT COUNT(*) AS total_spots FROM parking_spots");
$totalSpots = $totalSpotsQuery->fetch(PDO::FETCH_ASSOC)['total_spots'];

// Count available and booked spots
$availableSpotsCount = count($emptySpots);
$bookedSpotsCount = count($bookedSpots);

// Handle form submission for booking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $spotId = intval($_POST['spot_id']);

    if ($action === 'accept') {
        $userId = 1; // Assume logged-in user with ID 1
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];

        // Update spot to occupied
        $stmt = $conn->prepare("UPDATE parking_spots SET is_occupied = 2 WHERE id = ?");
        $stmt->execute([$spotId]);

        // Insert booking
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, parking_spot_id, start_time, end_time) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $spotId, $startTime, $endTime]);

        echo json_encode(['success' => true, 'message' => 'Spot successfully booked!']);
        exit;
    } elseif ($action === 'reject') {
        // Delete parking spot from the database
        $stmt = $conn->prepare("DELETE FROM parking_spots WHERE id = ?");
        $stmt->execute([$spotId]);

        echo json_encode(['success' => true, 'message' => 'Spot successfully rejected!']);
        exit;
    }
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
    <a href="notication.php" style="font-size: 24px; text-decoration: none;">
    🔔 Notification
</a>

        <h1>Parkopedia</h1>

        <h2>Empty Parking Spots</h2>
        <ul id="empty-spots">
            <?php foreach ($emptySpots as $spot): ?>
                <li id="spot-<?= htmlspecialchars($spot['id']); ?>">
                    Spot <?= htmlspecialchars($spot['spot_number']); ?>
                    <form onsubmit="return acceptSpot(event, <?= $spot['id']; ?>)">
                        <label for="start_time_<?= $spot['id']; ?>">Start Time:</label>
                        <input type="datetime-local" id="start_time_<?= $spot['id']; ?>" name="start_time" required>
                        
                        <label for="end_time_<?= $spot['id']; ?>">End Time:</label>
<input type="datetime-local" id="end_time_<?= $spot['id']; ?>" name="end_time" required>

<button onclick="scheduleNotification(<?= $spot['id']; ?>); window.open('notication.php', '_blank');">
    Set Reminder </button>



<script>
function scheduleNotification(spotId) {
    let endTimeInput = document.getElementById(`end_time_${spotId}`);
    let endTime = new Date(endTimeInput.value).getTime();
    let currentTime = new Date().getTime();
    
    if (isNaN(endTime) || endTime <= currentTime) {
        alert("Please select a valid future time.");
        return;
    }

    let timeDifference = endTime - currentTime;

    setTimeout(() => {
        showNotification();
    }, timeDifference);

    alert("Notification will be triggered when the time ends.");
}

function showNotification() {
    if (Notification.permission === "granted") {
        new Notification("Time's up!", {
            body: "The selected time has ended.",
            icon: "https://cdn-icons-png.flaticon.com/512/3909/3909444.png"
        });
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                new Notification("Time's up!", {
                    body: "The selected time has ended.",
                    icon: "https://cdn-icons-png.flaticon.com/512/3909/3909444.png"
                });
            }
        });
    }
}
</script>


                        <button type="submit">Accept</button>
                    </form>
                    <button onclick="rejectSpot(<?= $spot['id']; ?>)">Reject</button>
                </li>
            <?php endforeach; ?>
        </ul>


        <h2>Parking Space Availability</h2>
        <div class="parking-availability">
    <?php
    $totalSpots = 50; // Fixed total parking spots
    $availableSpotsCount = max(0, $totalSpots - $bookedSpotsCount); // Calculate available spots
    ?>
    <p>Total Parking Spots: <strong><?= htmlspecialchars($totalSpots); ?></strong></p>
    <p>Available Spots: <strong><?= htmlspecialchars($availableSpotsCount); ?></strong></p>
    <p>Booked Spots: <strong><?= htmlspecialchars($bookedSpotsCount); ?></strong></p>
</div>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <script>
        function acceptSpot(event, spotId) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            formData.append('action', 'accept');
            formData.append('spot_id', spotId);

            fetch('dashboard.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Temporary: Improve by dynamically updating the DOM
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function rejectSpot(spotId) {
            const formData = new FormData();
            formData.append('action', 'reject');
            formData.append('spot_id', spotId);

            fetch('dashboard.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Temporary: Improve by dynamically updating the DOM
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
    </script>
</body>
</html>
