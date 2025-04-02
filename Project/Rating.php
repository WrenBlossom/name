<?php
// Include the database connection
include 'database.php';

// Handle form submission
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Validate input
    if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        $message = "Invalid rating. Please select a rating between 1 and 5.";
    } else {
        try {
            // Use a prepared statement
            $sql = "INSERT INTO ratings (rating, comment) VALUES (:rating, :comment)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $message = "Thank you for your feedback!";
            } else {
                $message = "Error: Could not submit rating.";
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Our System</title>
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
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }

        .stars {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 1.5rem;
            cursor: pointer;
        }

        .stars span {
            font-size: 2rem;
            color: #ddd;
            transition: color 0.2s;
        }

        .stars span.active {
            color: rgb(53, 84, 185);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 0.5rem;
        }

        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            resize: vertical;
            min-height: 100px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.75rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rate Our System</h1>

        <?php if (isset($message)): ?>
            <div class="message"> <?php echo $message; ?> </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <div class="stars" id="star-rating">
                    <span data-value="1">⭐</span>
                    <span data-value="2">⭐</span>
                    <span data-value="3">⭐</span>
                    <span data-value="4">⭐</span>
                    <span data-value="5">⭐</span>
                </div>
                <input type="hidden" id="rating" name="rating" required>
            </div>

            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" rows="4" required></textarea>
            </div>

            <input type="submit" value="Submit">
        </form>
        <a href="index.html" style="text-decoration: none;">
        <a href="feeback.php" class="back-btn">See Your Feedback</a>
            
        </a>
    </div>

    <script>
        const stars = document.querySelectorAll('.stars span');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                ratingInput.value = value;
                
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>
