<?php
session_start();
include '../db.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID
    $title = $_POST['story_title'];
    $description = $_POST['story_description'];

    // Handle image upload
    if (isset($_FILES['story_image']) && $_FILES['story_image']['error'] == 0) {
        $image = $_FILES['story_image'];
        $imageName = time() . "_" . basename($image['name']);
        $imagePath = "uploads/" . $imageName;
        move_uploaded_file($image['tmp_name'], $imagePath);
    } else {
        $imagePath = null;
    }

    // Handle video upload
    if (isset($_FILES['story_video']) && $_FILES['story_video']['error'] == 0) {
        $video = $_FILES['story_video'];
        $videoName = time() . "_" . basename($video['name']);
        $videoPath = "uploads/" . $videoName;
        move_uploaded_file($video['tmp_name'], $videoPath);
    } else {
        $videoPath = null;
    }

    // Insert the story into the database
    $query = "INSERT INTO stories (user_id, title, description, video_url, image_url, status) VALUES (?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $userId, $title, $description, $videoPath, $imagePath);
    $stmt->execute();
    $stmt->close();

    // Redirect to a page after submission (optional)
    header('Location: story_submission_success.php');
    exit();
}
