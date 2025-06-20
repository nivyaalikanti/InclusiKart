<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['buyer_id'])) {
    header("Location: blogin.php");
    exit();
}

$buyer_id = $_SESSION['buyer_id'];

// Fetch all orders for the logged-in user
$orderQuery = "SELECT o.id, o.total, o.created_at 
               FROM orders o 
               WHERE o.buyer_id = ? 
               ORDER BY o.created_at DESC";
$orderStmt = $conn->prepare($orderQuery);
$orderStmt->bind_param("i", $buyer_id);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order History</title>
    <link rel="stylesheet" href="Styles/order_history.css">
</head>
<body>
    <h2>Your Order History</h2>

    <?php if ($orderResult->num_rows === 0): ?>
        <p>You have not placed any orders yet.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Total Amount (₹)</th>
                <th>Order Date</th>
                <th>Action</th>
            </tr>
            <?php while ($order = $orderResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['total']; ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td>
                        <a href="order_confirmation.php?order_id=<?php echo $order['id']; ?>" class="view-button">View Details</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>