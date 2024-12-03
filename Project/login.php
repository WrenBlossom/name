<?php
include 'database.php';
session_start();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = MD5(?)");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Parking System</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="dashboard">
        <h1>Login to Parkopedia</h1>
        <?php if (!empty($error)): ?>
            <div class="notification error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
            <button onclick="window.location.href='register.html'">Create New Account↪️</button>
            <button onclick="window.location.href='index.html'">Back to Home</button>
        </form>
    </div>
</body>
</html>
