<?php
include 'db.php'; // Database connection

// Fetch all approved stories
$query = "SELECT * FROM stories WHERE status = 'approved'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Stories</title>
    <link rel="stylesheet" href="Styles/stories.css">
</head>
<body>
    <h1>Approved Stories</h1>
    <div class="stories-container">
    <?php while ($story = $result->fetch_assoc()): ?>
        <div class="story">
            <h2><?= htmlspecialchars($story['title']) ?></h2>
            <?php if ($story['video_url']): ?>
                <video width="320" height="240" controls>
                    <source src="<?= htmlspecialchars($story['video_url']) ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <p><?= htmlspecialchars($story['description']) ?></p>
            <br>
            <?php if ($story['image_url']): ?>
                <img id="image"src="<?= htmlspecialchars($story['image_url']) ?>" width="200" alt="Story Image">
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
    </div>
</body>
</html>
