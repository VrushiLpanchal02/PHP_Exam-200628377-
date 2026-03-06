<?php
// name Vrushil Panchal
// rollnumber 200628377
// date: 03/06/2026
// Include DB config
require_once 'config.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // cleanup and validate input
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $rating = filter_var($_POST['rating'] ?? 0, FILTER_VALIDATE_INT);
    $review_text = trim($_POST['review_text'] ?? '');

    $errors = [];
    if (empty($title)) $errors[] = 'Title required.';
    if (empty($author)) $errors[] = 'Author required.';
    if (!$rating || $rating < 1 || $rating > 5) $errors[] = 'Rating must be 1-5.';
    if (empty($review_text)) $errors[] = 'Review text required.';

    if (empty($errors)) {
        // INSERT with prepared statement (secure against SQL injection)
        $stmt = $pdo->prepare("INSERT INTO reviews (title, author, rating, review_text) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $author, $rating, $review_text]);
        $success = true;
    } else {
        $error = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Book Review</title>
</head>
<body>
    <h1>Submit a Book Review</h1>
    <?php if ($success): ?><p style="color:green;">Review added!</p><?php endif; ?>
    <?php if ($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>
    
    <form method="POST">
        <label>Book Title: <input type="text" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" required></label><br>
        <label>Author: <input type="text" name="author" value="<?php echo htmlspecialchars($author ?? ''); ?>" required></label><br>
        <label>Rating (1-5): <input type="number" name="rating" value="<?php echo $rating ?? ''; ?>" min="1" max="5" required></label><br>
        <label>Review: <textarea name="review_text" rows="6" cols="40" required><?php echo htmlspecialchars($review_text ?? ''); ?></textarea></label><br>
        <button type="submit">Submit</button>
    </form>
    <p><a href="admin.php">Admin Page</a></p>
</body>
</html>
