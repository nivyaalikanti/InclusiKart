<?php
session_start();
include '../db.php';

// Check if user is logged in
if (!isset($_SESSION['buyer_id'])) {
    header("Location: blogin.php");
    exit();
}

$buyer_id = $_SESSION['buyer_id'];
$total = 0;

// Fetch cart items to display in the checkout
$cartQuery = "SELECT p.name, p.price, c.quantity, p.id AS product_id 
              FROM cart c 
              JOIN products p ON c.product_id = p.id 
              WHERE c.user_id = ?";
$stmt = $conn->prepare($cartQuery);
$stmt->bind_param("i", $buyer_id);
$stmt->execute();
$result = $stmt->get_result();

// Calculate total
while ($row = $result->fetch_assoc()) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
}

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the delivery address from the form
$address = $_POST['address'];

// Insert order into orders table
$insertOrderQuery = "INSERT INTO orders (buyer_id, total, address) VALUES (?, ?, ?)";
$orderStmt = $conn->prepare($insertOrderQuery);
$orderStmt->bind_param("ids", $buyer_id, $total, $address);
    $orderStmt->execute();
    $order_id = $orderStmt->insert_id;

    // Insert order items into order_items table
    $result->data_seek(0); // Reset result pointer
    while ($row = $result->fetch_assoc()) {
        $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $orderItemStmt = $conn->prepare($insertOrderItemQuery);
        $orderItemStmt->bind_param("iiid", $order_id, $row['product_id'], $row['quantity'], $row['price']);
        $orderItemStmt->execute();
    }

    // Clear the cart
    $clearCartQuery = "DELETE FROM cart WHERE user_id = ?";
    $clearCartStmt = $conn->prepare($clearCartQuery);
    $clearCartStmt->bind_param("i", $buyer_id);
    $clearCartStmt->execute();

    // Redirect to order confirmation page
    header("Location: order_confirmation.php?order_id=" . $order_id);
    exit();
}
?><link rel="stylesheet" href="../Styles/checkout.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    
</head>
<body>
    <h2>Checkout</h2>
    <h3>Order Summary</h3>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price (₹)</th>
            <th>Quantity</th>
        </tr>
        <?php
        // Reset result pointer to display items
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <h3>Total: ₹<?php echo $total; ?></h3>
    <form method="POST">
        <label for="address">Delivery Address:</label>
        <input type="text" id="address" name="address" required>
        <button type="submit">Place Order</button>
    </form>
</body>
</html>