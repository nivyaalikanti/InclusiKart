<?php
session_start();
include '../db.php'; // Database connection

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'story') {
    header('Location: admin_dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storyId = $_POST['story_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $query = "UPDATE stories SET status = 'approved' WHERE id = ?";
    } elseif ($action === 'reject') {
        $query = "UPDATE stories SET status = 'rejected' WHERE id = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $storyId);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the verifier dashboard
    header('Location: story_verifier.php');
    exit();
}
