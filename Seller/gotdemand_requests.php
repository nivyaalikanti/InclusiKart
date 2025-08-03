<?php
session_start();
include '../db.php';

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Fetch demand requests for the seller's products
$query = "SELECT dr.id, dr.quantity, p.name AS product_name, b.username AS buyer_name,dr.status  
          FROM demand_requests dr 
          JOIN products p ON dr.product_id = p.id 
          JOIN buyers b ON dr.buyer_id = b.id 
          WHERE p.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle Approve or Reject actions
if (isset($_POST['action'])) {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        // Update the demand request status to approved
        $updateQuery = "UPDATE demand_requests SET status = 'approved' WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("i", $request_id);
        $updateStmt->execute();
        $updateStmt->execute();
        $message = "Request approved successfully.";
    } elseif ($action === 'reject') {
        // Update the demand request status to rejected
        $updateQuery = "UPDATE demand_requests SET status = 'rejected' WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("i", $request_id);
        $updateStmt->execute();
        $updateStmt->execute();
        $message = "Request rejected successfully.";
    }

    // Redirect to the same page to see updated requests
    header("Location: gotdemand_requests.php?message=" . urlencode($message));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Demand Requests</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../Styles/got_demand_requests.css">
</head>
<body>
    <div class="container">
        <h1>Demand Requests</h1>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Product Name</th>
                    <th>Buyer Name</th>
                    <th>Requested Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['buyer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td>
                    <?php if ($row['status'] === 'approved'): ?>
                        <span style="color: green;">Request approved successfully.</span>
                    <?php elseif ($row['status'] === 'rejected'): ?>
                        <span style="color: red;">Request rejected successfully.</span>
                    <?php else: ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit" name="action" value="approve">Approve</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    <?php endif; ?>
                </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No demand requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- <button><a href="seller_dashboard.php" style="color: white; text-decoration: none;">Back to</button> -->
                </div>
                <script>
    function disableButtons(button) {
        // Get the parent form of the clicked button
        const form = button.closest('form');
        
        // Disable both buttons in the same row
        const buttons = form.parentElement.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.disabled = true; // Disable the button
            btn.classList.add('disabled'); // Add a class to change the style if needed
        });
        
        // Optionally, you can show a message below the buttons
        const message = document.createElement('span');
        message.textContent = button.value === 'approve' ? 'Request approved successfully.' : 'Request rejected successfully.';
        message.style.color = 'green'; // Change color as needed
        form.parentElement.appendChild(message);
    }
</script>
</body>
</html>