<?php
require_once 'config.php';
$id = (int)($_GET['id'] ?? 0);

if ($id && isset($_GET['confirm'])) {
    // Secure DELETE with prepared statement
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php?deleted=1");
    exit;
}

die("Invalid request - use Admin page Delete link.");
?>