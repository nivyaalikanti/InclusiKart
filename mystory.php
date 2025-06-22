<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch the latest story submitted by the logged-in user
$query = "SELECT title, description, video_url, image_url FROM stories WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($title, $description, $video_url, $image_url);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Story - InclusiKart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Styles/mystory.css">
</head>
<body>
    <div class="container">
        <h2>My Story</h2>
        
        <?php if ($title): ?>
            <h3 id="title"><?= htmlspecialchars($title) ?></h3>
            <p><?= htmlspecialchars($description) ?></p>
            
            <?php if ($video_url): ?>
                <video width="320" height="240" controls>
                    <source src="<?= htmlspecialchars($video_url) ?>" type="video/mp4">
                </video>
            <?php endif; ?>

            <?php if ($image_url): ?>
                <img src="<?= htmlspecialchars($image_url) ?>" width="200" alt="Story Image">
            <?php endif; ?>

        <?php else: ?>
            <p>You haven't shared your story yet.</p>
        <?php endif; ?>

    </div>
</body>
</html>
