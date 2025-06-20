<?php
session_start();
include 'db.php';

// Check if user is logged in and verified
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user's status from the database
$query = "SELECT status FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

// Redirect if user is not verified
if ($status !== "verified") {
    echo "<script>alert('Your profile is not verified yet.'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Your Story - InclusiKart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Styles/share_story.css">
</head>
<body>

    <div class="container">
        <h2>Share Your Story</h2>
        <form id="storyForm" action="upload_story.php" method="POST" enctype="multipart/form-data">
            <label for="story_title">Story Title</label>
            <input type="text" id="story_title" name="story_title" placeholder="Enter your story title" required>

            <label for="story_description">Story Description</label>
            <textarea id="story_description" name="story_description" placeholder="Write your story here..." rows="6" required></textarea>

            <label for="story_video">Upload Video (optional, max 50MB, MP4/AVI/MOV)</label>
            <input type="file" id="story_video" name="story_video" accept="video/mp4,video/x-msvideo,video/quicktime">

            <label for="story_image">Upload Image (optional, max 10MB, JPG/PNG)</label>
            <input type="file" id="story_image" name="story_image" accept="image/jpeg,image/png">

            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        document.getElementById('storyForm').addEventListener('submit', function(e) {
            const videoInput = document.getElementById('story_video');
            const imageInput = document.getElementById('story_image');
            const videoFile = videoInput.files[0];
            const imageFile = imageInput.files[0];
            
            // Check video size
            if (videoFile && videoFile.size > 50 * 1024 * 1024) { // 50MB limit
                alert("Video file is too large. Maximum allowed size is 50MB.");
                e.preventDefault();
            }
            
            // Check image size
            if (imageFile && imageFile.size > 10 * 1024 * 1024) { // 10MB limit
                alert("Image file is too large. Maximum allowed size is 10MB.");
                e.preventDefault();
            }
        });
    </script>

</body>
</html>
