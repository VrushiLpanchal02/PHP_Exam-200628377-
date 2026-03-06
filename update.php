<?php
require_once 'config.php';
$id = (int)($_GET['id'] ?? 0);
$review = null;
$error = $success = '';

if (!$id) die('Invalid ID.');

// finding existing reviews
$stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = ?");
$stmt->execute([$id]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$review) die('Review not found.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $rating = filter_var($_POST['rating'] ?? 0, FILTER_VALIDATE_INT);
    $review_text = trim($_POST['review_text'] ?? '');

    $errors = [];
    if (empty($title)) $errors[] = 'Title required.';
    if (empty($author)) $errors[] = 'Author required.';
    if (!$rating || $rating < 1 || $rating > 5) $errors[] = 'Rating 1-5.';
    if (empty($review_text)) $errors[] = 'Review required.';

    if (empty($errors)) {
        // updating with prepared statement
        $stmt = $pdo->prepare("UPDATE reviews SET title=?, author=?, rating=?, review_text=? WHERE id=?");
        $stmt->execute([$title, $author, $rating, $review_text, $id]);
        $success = 'Updated!';
    } else {
        $error = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head><title>Edit Review</title></head>
<body>
    <h1>Edit Review ID: <?php echo $id; ?></h1>
    <?php if ($success): ?><p style="color:green;"><?php echo $success; ?></p><?php endif; ?>
    <?php if ($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>
    
    <form method="POST">
        <label>Title: <input type="text" name="title" value="<?php echo htmlspecialchars($review['title'] ?? ''); ?>" required></label><br>
        <label>Author: <input type="text" name="author" value="<?php echo htmlspecialchars($review['author'] ?? ''); ?>" required></label><br>
        <label>Rating: <input type="number" name="rating" value="<?php echo $review['rating'] ?? ''; ?>" min="1" max="5" required></label><br>
        <label>Review: <textarea name="review_text" required><?php echo htmlspecialchars($review['review_text'] ?? ''); ?></textarea></label><br>
        <button type="submit">Update</button>
        <a href="admin.php">Cancel</a>
    </form>
</body>
</html>
