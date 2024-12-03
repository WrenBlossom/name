<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set a notification message
    $_SESSION['notification'] = "BookSpot successfully!";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
