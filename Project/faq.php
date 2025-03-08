<?php
// Include the database connection
include 'database.php';

// Handle form submission to add FAQ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['question'], $_POST['answer'])) {
    // Sanitize input to prevent XSS and other injection attacks
    $question = htmlspecialchars($_POST['question']);
    $answer = htmlspecialchars($_POST['answer']);

    // Prepare the SQL statement to insert the new FAQ
    $stmt = $conn->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
    $stmt->bind_param("ss", $question, $answer); // "ss" means both are strings

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<p>FAQ added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the prepared statement
    $stmt->close();
}

// Retrieve FAQs from the database
$sql = "SELECT * FROM faqs ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .faqs {
            margin-top: 20px;
        }
        .faq {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .faq h3 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Frequently Asked Questions</h2>

    <!-- Display FAQs -->
    <div class="faqs">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='faq'>
                        <h3>" . htmlspecialchars($row['question']) . "</h3>
                        <p>" . htmlspecialchars($row['answer']) . "</p>
                      </div>";
            }
        } else {
            echo "<p>No FAQs available.</p>";
        }
        ?>
    </div>

    <hr>

    <!-- Add New FAQ Form -->
    <h3>Add a New FAQ</h3>
    <form action="faq.php" method="POST">
        <label for="question">Question:</label><br>
        <input type="text" name="question" id="question" required><br><br>

        <label for="answer">Answer:</label><br>
        <textarea name="answer" id="answer" rows="5" required></textarea><br><br>

        <button type="submit">Add FAQ</button>
    </form>

</body>
</html>

<?php
// Close connection
$conn->close(); // This is fine as long as $conn is a mysqli connection
?>