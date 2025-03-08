<?php
include 'database.php'; // Include your database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate input
    if (empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } else {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser  = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser ) {
            $error = "Email already registered.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            if ($stmt->execute([$email, $hashedPassword, $role])) {
                $_SESSION['user_id'] = $conn->lastInsertId(); // Get the last inserted ID
                $_SESSION['user_email'] = $email; // Store email in session
                $_SESSION['user_role'] = $role; // Store role in session
                header("Location: dashboard.php"); // Redirect to dashboard
                exit;
            } else {
                $error = "Error registering user.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($error)): ?>
            <div class="notification error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Select Role:</label>
            <select id="role" name="role" required>
                <option value="" disabled selected>Select your role</option>
                <option value="user">User </option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Register</button>
            <button type="button" onclick="window.location.href='login.php'">Back to Login</button>
        </form>
    </div>
</body>
</html>