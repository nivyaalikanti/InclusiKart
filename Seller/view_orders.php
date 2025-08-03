<?php
// Database connection
// session_start();
include '../db.php'; // Database connection

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the user is logged in and their user ID is stored in the session
session_start();
$seller_id = $_SESSION['user_id']; // Replace with your session variable for user ID

// Function to calculate estimated delivery date
function calculateEstimatedDelivery() {
    // Current date
    $currentDate = new DateTime();
    
    // Assume standard delivery time of 5 to 7 days
    $daysToAdd = rand(5, 7); // Randomly choose between 5 to 7 days

    // Calculate estimated delivery date
    $estimatedDeliveryDate = clone $currentDate;
    $addedDays = 0;

    while ($addedDays < $daysToAdd) {
        $estimatedDeliveryDate->modify('+1 day');
        // Check if it's a weekend
        if ($estimatedDeliveryDate->format('N') < 6) {
            $addedDays++;
        }
    }

    return $estimatedDeliveryDate->format('Y-m-d');
}
// Fetch orders for the seller's products
$sql = "
    SELECT 
        o.id AS order_id,
        b.id AS buyer_id,
        b.name AS buyer_name,
        p.name AS product_name,
        p.image AS product_image,
        o.address AS buyer_address,
        o.status
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    JOIN buyers b ON o.buyer_id = b.id
    WHERE p.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #00437a;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .product-image {
    width: 100px; /* Set the desired width */
    height: auto; /* Maintain aspect ratio */
}
    </style>
</head>
<body>

<h1>Orders for Your Products</h1>

<table>
    <thead>
        <tr>
            <th>Buyer ID</th>
            <th>Buyer Name</th>
            <th>Delivery Address</th>
            <th>Product Name</th>
            <th>Product Image</th>
            <th>Status</th>
            <th>Estimated Delivery</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['buyer_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['buyer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['buyer_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td>
                        <?php if (!empty($row['product_image'])): ?>
                            <img src="../uploads_products/<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image" class="product-image">
                        <?php else: ?>
                            <img src="default.jpg" alt="No Image" class="product-image">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars(calculateEstimatedDelivery()); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No orders found for your products.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>