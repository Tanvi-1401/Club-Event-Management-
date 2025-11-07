<?php
require 'db_connect.php';
try {
    $stmt = $pdo->query("SELECT DATABASE() as db");
    $row = $stmt->fetch();
    echo 'Connected to database: ' . htmlspecialchars($row['db']);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
