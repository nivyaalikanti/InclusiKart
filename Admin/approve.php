<?php
include '../db.php';

// Ensure 'id' is received and is a valid integer
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Update the status to 'verified'
    $query = "UPDATE users SET status='verified' WHERE id=$id";
    
    if ($conn->query($query) === TRUE) {
        header("Location: profile_verifiers.php?success=User approved successfully!");
        exit();
    } else {
        header("Location: profile_verifiers.php?error=" . urlencode($conn->error));
        exit();
    }
} else {
    header("Location: profile_verifiers.php?error=Invalid user ID.");
    exit();
}
?>

