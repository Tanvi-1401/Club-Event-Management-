<?php
require 'db_connect.php'; // connect to DB

$message = ''; // to show after updating

// Get event ID from URL (like edit_event.php?id=1)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch that event's details
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$id]);
    $event = $stmt->fetch();

    if (!$event) {
        echo "Event not found!";
        exit;
    }
} else {
    echo "No event ID provided!";
    exit;
}

// When the form is submitted (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];

    // Update event data in DB
    $sql = "UPDATE events SET name = ?, date = ?, venue = ?, description = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $date, $venue, $description, $id]);

    $message = "Event updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 30px; }
        form { background: white; padding: 20px; border-radius: 10px; width: 400px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

    <h2>Edit Event</h2>

    <?php if ($message): ?>
        <p style="color: green;"><?= $message ?></p>
        <a href="index.php">← Go Back to Home</a>
    <?php else: ?>
        <form method="POST" action="">
            <label>Event Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>

            <label>Date:</label>
            <input type="date" name="date" value="<?= htmlspecialchars($event['date']) ?>" required>

            <label>Venue:</label>
            <input type="text" name="venue" value="<?= htmlspecialchars($event['venue']) ?>" required>

            <label>Description:</label>
            <textarea name="description" rows="3"><?= htmlspecialchars($event['description']) ?></textarea>

            <button type="submit">Update Event</button>
        </form>
    <?php endif; ?>

</body>
</html>
