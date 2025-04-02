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

// Fetch expired bookings
$expiredBookingsQuery = $conn->query("SELECT * FROM bookings WHERE end_time <= NOW()");
$expiredBookings = $expiredBookingsQuery->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for booking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $spotId = intval($_POST['spot_id']);

    if ($action === 'accept') {
        $userId = 1; // Assume logged-in user with ID 1
        $carNumberPlate = $_POST['car_number_plate']; // Get the car number plate
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];

        // Update spot to occupied
        $stmt = $conn->prepare("UPDATE parking_spots SET is_occupied = 2 WHERE id = ?");
        $stmt->execute([$spotId]);

        // Insert booking with car number plate
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, parking_spot_id, car_number_plate, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $spotId, $carNumberPlate, $startTime, $endTime]);

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
        <a href="javascript:void(0);" onclick="showNotifications()" id="notification-bell" style="font-size: 24px; text-decoration: none;">
            🔔 Notification <span id="notification-count" style="color: red; font-weight: bold;"></span>
        </a>

        <h1>Parkopedia</h1>

        <h2>Empty Parking Spots</h2>
        <ul id="empty-spots">
            <?php foreach ($emptySpots as $spot): ?>
                <li id="spot-<?= htmlspecialchars($spot['id']); ?>">
                    Spot <?= htmlspecialchars($spot['spot_number']); ?>
                    <form onsubmit="return acceptSpot(event, <?= $spot['id']; ?>)">
                        <label for="car_number_plate_<?= $spot['id']; ?>">Car Number Plate:</label>
                        <input type="text" id="car_number_plate_<?= $spot['id']; ?>" name="car_number_plate" required>

                        <label for="start_time_<?= $spot['id']; ?>">Start Time:</label>
                        <input type="datetime-local" id="start_time_<?= $spot['id']; ?>" name="start_time" required disabled>
                        
                        <label for="end_time_<?= $spot['id']; ?>">End Time:</label>
                        <input type="datetime-local" id="end_time_<?= $spot['id']; ?>" name="end_time" required>

                        <button type="submit">Accept</button>
                    </form>
                    <button onclick="rejectSpot(<?= $spot['id']; ?>)">Reject</button>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Parking Space Availability</h2>
        <div class="parking-availability">
            <p>Total Parking Spots: <strong><?= htmlspecialchars($totalSpots); ?></strong></p>
            <p>Available Spots: <strong><?= htmlspecialchars($availableSpotsCount); ?></strong></p>
            <p>Booked Spots: <strong><?= htmlspecialchars($bookedSpotsCount); ?></strong></p>
        </div>

        <a href="logout.php" class="logout">Logout</a>
    </div>

    <script>
   function setCurrentDateTime() {
            const now = new Date();

            // Format to YYYY-MM-DDTHH:MM
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const formattedDate = `${year}-${month}-${day}T${hours}:${minutes}`;

            // Apply to all matching inputs
            document.querySelectorAll('input[name="start_time"]').forEach(input => {
                input.value = formattedDate;
                input.readOnly = true; // Ensure users can't modify
            });

            // Clear end time for user input
            document.querySelectorAll('input[name="end_time"]').forEach(input => {
                input.value = '';
            });
        }

        // Ensure the function runs when the page loads
        window.addEventListener('load', setCurrentDateTime);


        function setCurrentDateTime() {
        const now = new Date();
        const formattedDate = now.toISOString().slice(0, 16); // Format to YYYY-MM-DDTHH:MM

        const startTimeInputs = document.querySelectorAll('input[name="start_time"]');
        const endTimeInputs = document.querySelectorAll('input[name="end_time"]');

        startTimeInputs.forEach(input => {
            input.value = formattedDate; // Set current date-time
            input.disabled = true; // Keep it disabled
        });

        endTimeInputs.forEach(input => {
            input.value = ''; // Leave the end time empty, as the user will input it
        });
    }

    window.onload = setCurrentDateTime;

    function acceptSpot(event, spotId) {
        event.preventDefault();
        const form = event.target;

        // Enable the disabled start_time input before submitting
        const startTimeInput = form.querySelector('input[name="start_time"]');
        startTimeInput.disabled = false;

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
                location.reload();
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
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function showNotifications() {
        let expiredBookings = <?= json_encode($expiredBookings); ?>;
        let message = "";

        if (expiredBookings.length > 0) {
            message = "Booking session(s) expired:\n";
            expiredBookings.forEach(booking => {
                message += `Car ${booking.car_number_plate} at Spot ${booking.parking_spot_id} has expired!\n`;
            });
        } else {
            message = "No expired bookings.";
        }

        alert(message);
    }

    function checkNotifications() {
        let expiredBookings = <?= json_encode($expiredBookings); ?>;
        let notificationCount = expiredBookings.length;

        if (notificationCount > 0) {
            document.getElementById("notification-count").textContent = `(${notificationCount})`;
        }
    }

    checkNotifications();

    </script>
</body>
</html>
