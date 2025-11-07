<?php
require 'db_connect.php'; // connect to database

$message = ''; // for success message

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];

    // Insert event into database
    $sql = "INSERT INTO events (name, date, venue, description) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $date, $venue, $description]);

    $message = "Event added successfully!";


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Event</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 30px; }
        form { background: white; padding: 20px; border-radius: 10px; width: 400px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

    <h2>Add New Event</h2>

    <?php if ($message): ?>
        <p style="color: green;"><?= $message ?></p>
        <a href="index.php">← Go Back to Home</a>
    <?php else: ?>
        <form method="POST" action="">
            <label>Event Name:</label>
            <input type="text" name="name" required>

            <label>Date:</label>
            <input type="date" name="date" required>

            <label>Venue:</label>
            <input type="text" name="venue" required>

            <label>Description:</label>
            <textarea name="description" rows="3"></textarea>

            <button type="submit">Add Event</button>
        </form>
    <?php endif; ?>

</body>
</html>
