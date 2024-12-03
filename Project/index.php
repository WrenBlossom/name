<?php
include 'database.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Fetch logged-in user's name
$userName = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?= htmlspecialchars($userName); ?>!</h1>
        <a href="logout.php" class="logout">Logout</a>
        <p>This is the user dashboard.</p>
    </div>
</body>
</html>
