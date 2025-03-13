<?php
include 'database.php';
session_start();

// Restrict access to admins only
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle form submissions for adding/updating/deleting spots
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_spot'])) {
        $spotNumber = $_POST['spot_number'];
        $stmt = $conn->prepare("INSERT INTO parking_spots (spot_number, is_occupied) VALUES (?, 0)");
        $stmt->execute([$spotNumber]);
    } elseif (isset($_POST['delete_spot'])) {
        $spotId = $_POST['spot_id'];
        $stmt = $conn->prepare("DELETE FROM parking_spots WHERE id = ?");
        $stmt->execute([$spotId]);
    } elseif (isset($_POST['update_spot'])) {
        $spotId = $_POST['spot_id'];
        $spotNumber = $_POST['spot_number'];
        $stmt = $conn->prepare("UPDATE parking_spots SET spot_number = ? WHERE id = ?");
        $stmt->execute([$spotNumber, $spotId]);
    }
}

// Fetch all parking spots
$spots = $conn->query("SELECT * FROM parking_spots ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parking Spots</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard">
        <h1>Manage Parking Spots</h1>
        <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>

        <h2>Add New Spot</h2>
        <form method="POST" action="">
            <label for="spot_number">Spot Number:</label>
            <input type="text" name="spot_number" id="spot_number" required>
            <button type="submit" name="add_spot">Add Spot</button>
        </form>

        <h2>Existing Parking Spots</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Spot Number</th>
                    <th>Occupied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($spots as $spot): ?>
                    <tr>
                        <td><?= htmlspecialchars($spot['id']); ?></td>
                        <td><?= htmlspecialchars($spot['spot_number']); ?></td>
                        <td><?= $spot['is_occupied'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <!-- Update Form -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="spot_id" value="<?= $spot['id']; ?>">
                                <input type="text" name="spot_number" value="<?= htmlspecialchars($spot['spot_number']); ?>" required>
                                <button type="submit" name="update_spot">Update</button>
                            </form>

                            <!-- Delete Form -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="spot_id" value="<?= $spot['id']; ?>">
                                <button type="submit" name="delete_spot">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>
