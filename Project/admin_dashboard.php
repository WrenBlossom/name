<?php
include 'database.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch logged-in admin's name
$adminName = $_SESSION['user_name'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adash.css">
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?= htmlspecialchars($adminName); ?>!</h1>
        <a href="logout.php" class="logout">Logout</a>
        <h2>Admin Actions</h2>
        <ul>
        

            <li><a href="view_bookings.php">View All Bookings</a></li>
            <li><a href="manage_parking_spots.php">Manage Parking Spots</a></li>
        </ul>
    </div>
    
</body>
</html>
