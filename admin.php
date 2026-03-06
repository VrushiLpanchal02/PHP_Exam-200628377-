<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Admin Reviews</title>
    <style>table{border-collapse:collapse;width:100%;}th,td{border:1px solid #ddd;padding:8px;}</style>
</head>
<body>
    <h1>Book Reviews (Admin)</h1>
    <a href="index.php">Submit Review</a>
    
    <?php
    $stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($reviews)): ?>
        <p>No reviews.</p>
    <?php else: ?>
        <table>
            <tr><th>ID</th><th>Title</th><th>Author</th><th>Rating</th><th>Review</th><th>Created</th><th>Actions</th></tr>
            <?php foreach ($reviews as $r): ?>
                <tr>
                    <td><?php echo $r['id']; ?></td>
                    <td><?php echo htmlspecialchars($r['title']); ?></td>
                    <td><?php echo htmlspecialchars($r['author']); ?></td>
                    <td><?php echo $r['rating']; ?></td>
                    <td><?php echo htmlspecialchars(substr($r['review_text'], 0, 100)) . '...'; ?></td>
                    <td><?php echo $r['created_at']; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $r['id']; ?>">Edit</a> |
                        <a href="delete.php?id=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
