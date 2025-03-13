<?php
// Include the database connection
include 'database.php';

// Fetch all feedback from the database
try {
    $sql = "SELECT rating, comment, created_at FROM ratings ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .feedback {
            border-bottom: 1px solid #ddd;
            padding: 1rem 0;
        }

        .feedback:last-child {
            border-bottom: none;
        }

        .rating {
            font-size: 1.2rem;
            color: rgb(53, 84, 185);
        }

        .comment {
            font-size: 1rem;
            color: #555;
        }

        .date {
            font-size: 0.8rem;
            color: #777;
            margin-top: 0.5rem;
        }

        .back-btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Feedback</h1>
        
        <?php if (count($feedbacks) > 0): ?>
            <?php foreach ($feedbacks as $feedback): ?>
                <div class="feedback">
                    <div class="rating">Rating: <?php echo str_repeat('⭐', $feedback['rating']); ?></div>
                    <div class="comment">"<?php echo htmlspecialchars($feedback['comment']); ?>"</div>
                    <div class="date">Submitted on: <?php echo $feedback['created_at']; ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No feedback available yet.</p>
        <?php endif; ?>

        <a href="index.html" class="back-btn">Back to Home</a>
    </div>
</body>
</html>
