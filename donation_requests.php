<?php
include 'db.php';
$sql = "SELECT * FROM donations ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donation Requests</title>
    <link rel="stylesheet" href="Styles/donation_requests.css">
</head>
<body>
    <h1>Donation Requests</h1>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="request">
            <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
            <p><strong>Age:</strong> <?= $row['age'] ?></p>
            <p><strong>Disability:</strong> <?= htmlspecialchars($row['disability_type']) ?></p>
            <p><strong>Contact:</strong> <?= htmlspecialchars($row['contact']) ?></p>
            <p><strong>Reason:</strong> <?= nl2br(htmlspecialchars($row['reason'])) ?></p>
            <p><strong>QR Code:</strong> <?= htmlspecialchars($row['qr_code']) ?></p>
        </div>
    <?php } ?>
</body>
</html>
