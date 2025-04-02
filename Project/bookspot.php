<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set a notification message
    $_SESSION['notification'] = "BookSpot successfully!";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Spot</title>
</head>
<body>
    <?php if (isset($_SESSION['notification'])): ?>
        <div class="notification">
            <?= htmlspecialchars($_SESSION['notification'], ENT_QUOTES, 'UTF-8'); ?>
            <?php unset($_SESSION['notification']); // Clear notification after displaying ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <button type="submit">Book Spot</button>
    </form>
</body>
</html>
