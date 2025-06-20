<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$userId = $_SESSION['user_id'];
$query = "SELECT p.id, p.name, p.image, p.description, p.price, p.status, COALESCE(pv.quantity, 0) AS quantity , 
                 COALESCE(pv.views, 0) AS views FROM products p LEFT JOIN product_variants pv ON p.id = pv.product_id WHERE p.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Products</title>
    <link rel="stylesheet" href="Styles/myproducts.css">
    
</head>
<body>
    <h2>My Products</h2>
    <table border="1">
        <tr>

            <th>Image</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Status</th>
            <th>Quantity</th>
            <th>Views</th>
            <!-- <th>Update Quantity</th> -->
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="uploads_products/<?php echo htmlspecialchars($row['image']); ?>" width="100"></td>
                <td><?php echo htmlspecialchars('IK' . $row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['views']); ?></td> <!-- Display Views -->
                <!-- <td>
                    <form action="update_quantity.php" method="post">
                        <input type="hidden" name="product_variant_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="number" name="quantity" min="0" required>
                        <input type="submit" class="button" value="Update">
                    </form>
                </td> -->
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
