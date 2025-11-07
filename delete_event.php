<?php
require 'db_connect.php'; // connect to database

// Check if event ID is given in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute delete query
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect to home page after deleting
    header("Location: index.php?msg=deleted");
    exit;
} else {
    echo "No event ID provided!";
    exit;
}
?>
