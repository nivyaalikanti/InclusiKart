<?php
session_start();
include '../db.php'; // ✅ Add this to include the database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Force fetch the latest status from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT status FROM users WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

// Update session with fresh status
$_SESSION['status'] = $status;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        
    </style>
    <script>
        // Redirect to index.php after 3 seconds
        setTimeout(function() {
            window.location.href = '../index.php';
        }, 3000);
    </script>
</head>
<body>

<div class="container">
    <!-- <h2>Welcome to Your Dashboard</h2> -->

    <?php if ($status == 'pending'): ?>
        <p class="message pending">Please submit your details for verification.</p>
        <a href="submit_verification.php">Submit Details</a>

    <?php elseif ($status == 'submitted'): ?>
        <p class="message submitted">Your profile has been sent for verification. Please wait.</p>

    <?php elseif ($status == 'verified'): ?>
        <p class="message verified">Your profile has been successfully verified. You can share your stories or sell your products.</p>

    <?php else: ?>
        <p class="message rejected">Your profile verification was rejected. Please contact support.</p>
    <?php endif; ?>
</div>

</body>
</html>
