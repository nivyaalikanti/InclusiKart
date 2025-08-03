<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $disability_type = $_POST['disability_type'];
    $contact = $_POST['contact'];
    $reason = $_POST['reason'];
    $qr_code = $_POST['qr_code']; // You can also use a file upload field if needed

    $sql = "INSERT INTO donations (user_id, name, age, disability_type, contact, reason, qr_code)
            VALUES ('$user_id', '$name', '$age', '$disability_type', '$contact', '$reason', '$qr_code')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Request submitted successfully!'); window.location.href='help.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receive Donations</title>
    <link rel="stylesheet" href="../Styles/receive_donations.css">
</head>
<body>
    <form method="POST">
        <h2>Request for Donation</h2>
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Age:</label>
        <input type="number" name="age" required>

        <label>Disability Type:</label>
        <input type="text" name="disability_type" required>

        <label>Contact:</label>
        <input type="text" name="contact" required>

        <label>Reason for Request:</label>
        <textarea name="reason" required></textarea>

        <label>Your QR Code (UPI ID or any ref code):</label>
        <input type="text" name="qr_code" required>

        <button type="submit">Submit Request</button>
    </form>
</body>
</html>
