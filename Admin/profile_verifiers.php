<?php
include '../session_check.php'; 
include '../db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'profile') {
    echo "<p style='text-align:center; font-family: Arial; color: red; margin-top: 40px;'>
            Unauthorized access. Please <a href='admin_dashboard.php'>login here</a>.
          </p>";
    exit;
}

// Fetch user data
$result = $conn->query("SELECT u.id, u.username, d.name, d.dob, d.address, d.disability_type, d.document 
                        FROM users u 
                        JOIN user_details d ON u.id = d.user_id 
                        WHERE u.status='submitted'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Verifier Dashboard</title>
  <link rel="stylesheet" href="../Styles/profile_verifiers.css">
</head>
<body>
  <div class="container">
    <h2>Profile Verifier Dashboard</h2>
    
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="user-card">
        <p><strong>Username:</strong> <?= htmlspecialchars($row['username']) ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
        <p><strong>Date of Birth:</strong> <?= htmlspecialchars($row['dob']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($row['address']) ?></p>
        <p><strong>Disability Type:</strong> <?= htmlspecialchars($row['disability_type']) ?></p>
        <p><strong>Document:</strong> 
          <a href="/InclusiKart/<?= htmlspecialchars($row['document']) ?>" target="_blank" class="document-link">View document</a>
        </p>
        <a href="approve.php?id=<?= $row['id'] ?>" class="approve">Approve</a>
        <a href="reject.php?id=<?= $row['id'] ?>" class="reject">Reject</a>
      </div>
    <?php endwhile; ?>
    <a href="profile_verifier_logout.php" class="logout">Logout</a>
  </div>
</body>
</html>