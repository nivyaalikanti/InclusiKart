<?php
session_start();
include '../db.php';

// Only product verifiers can access this page
if (!isset($_SESSION['verifier_id'])) {
    die("Unauthorized access.");
}

// Handle product approval/rejection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['product_id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $status = 'approved';
    } else {
        $status = 'rejected';
    }

    $updateQuery = "UPDATE products SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $status, $productId);
    $stmt->execute();

    // Refresh the page after status update
    header("Location: products_verifier.php");
    exit;
}

// Fetch all pending products
$query = "SELECT * FROM products WHERE status = 'pending'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Verification</title>
    <link rel="stylesheet" href="../Styles/products_verifier.css">
</head>
<body>
    <h2>Verify Products</h2>
    <table border="1">
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="../uploads_products/<?php echo htmlspecialchars($row['image']); ?>" width="100"></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="approve" class="approve-btn">Approve</button>
                        <button type="submit" name="action" value="reject" class="reject-btn">Reject</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
