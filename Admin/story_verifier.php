<?php
session_start();
include '../db.php';

// Ensure that the user is logged in as a story verifier
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'story') {
    header('Location: admin_dashboard.php');
    exit();
}

// Fetch all pending stories
$query = "SELECT * FROM stories WHERE status = 'pending'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Verifier Dashboard</title>
    <link rel="stylesheet" href="../Styles/story_verifier.css">
</head>
<body>
    <h1>Pending Stories for Review</h1>

    <?php while ($story = $result->fetch_assoc()): ?>
        <div class="story">
            <h2><?= htmlspecialchars($story['title']) ?></h2>
            <p><?= htmlspecialchars($story['description']) ?></p>
            <?php if ($story['video_url']): ?>
                <video width="320" height="240" controls>
                    <source src="../<?= htmlspecialchars($story['video_url']) ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <?php if ($story['image_url']): ?>
                <img src="../<?= htmlspecialchars($story['image_url']) ?>" width="200" alt="Story Image">
            <?php endif; ?>

            <!-- Approve/Reject options -->
            <form action="approve_reject_story.php" method="POST">
                <input type="hidden" name="story_id" value="<?= $story['id'] ?>">
                <button type="submit" name="action" value="approve">Approve</button>
                <button type="submit" name="action" value="reject">Reject</button>
            </form>
        </div>
    <?php endwhile; ?>

</body>
</html>
