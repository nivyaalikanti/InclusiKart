<?php
session_start();
include '../db.php';

// Check if user is logged in
if (!isset($_SESSION['buyer_id'])) {
    header("Location: blogin.php");
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details
$orderQuery = "SELECT o.id, o.total, o.created_at, b.name 
               FROM orders o 
               JOIN buyers b ON o.buyer_id = b.id 
               WHERE o.id = ?";
$orderStmt = $conn->prepare($orderQuery);
$orderStmt->bind_param("i", $order_id);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
$order = $orderResult->fetch_assoc();

// Fetch order items
$orderItemsQuery = "SELECT oi.product_id, oi.quantity, oi.price, p.name 
                    FROM order_items oi 
                    JOIN products p ON oi.product_id = p.id 
                    WHERE oi.order_id = ?";
$orderItemsStmt = $conn->prepare($orderItemsQuery);
$orderItemsStmt->bind_param("i", $order_id);
$orderItemsStmt->execute();
$orderItemsResult = $orderItemsStmt->get_result();

// Store order items in an array
$orderItems = [];
while ($item = $orderItemsResult->fetch_assoc()) {
    $orderItems[] = $item;
}

// Decrease product quantity
foreach ($orderItems as $item) {
    $productId = $item['product_id'];
    $quantity = $item['quantity'];

    // Update the product quantity in product_variants
    $updateQuantityQuery = "UPDATE product_variants SET quantity = quantity - ? WHERE product_id = ?";
    $updateStmt = $conn->prepare($updateQuantityQuery);
    $updateStmt->bind_param("ii", $quantity, $productId);
    $updateStmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../Styles/order_confirmation.css">
</head>
<body>
    <h2>Order Confirmation</h2>
    <p>Thank you, <?php echo htmlspecialchars($order['name']); ?>! Your order has been placed successfully.</p>
    <p>Order ID: <b><?php echo $order['id']; ?></b></p>
    <p>Total Amount: <b>₹<?php echo $order['total']; ?></b></p>
    <p>Order Date: <?php echo $order['created_at']; ?></p>

    <h3>Order Summary</h3>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price (₹)</th>
        </tr>
        <?php foreach ($orderItems as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo $item['price']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="../shop.php" class="back-button">Continue Shopping</a>
</body>
</html>