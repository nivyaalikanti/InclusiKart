<?php
include '../db.php';
$id = $_GET['id'];

// Update the status to 'rejected'
$conn->query("UPDATE users SET status='rejected' WHERE id=$id");

header("Location: profile_verifiers.php");
exit();
?>
