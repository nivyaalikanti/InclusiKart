<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$userId = $_SESSION['user_id'];

// Check if the product ID is provided
if (!isset($_GET['id'])) {
    die("Product ID is required.");
}

$productId = intval($_GET['id']);

// Fetch the product details
$query = "SELECT p.id, p.name, p.description, p.price, p.status, COALESCE(pv.quantity, 0) AS quantity 
          FROM products p 
          LEFT JOIN product_variants pv ON p.id = pv.product_id 
          WHERE p.id = ? AND p.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $productId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    // Check if the price has changed
    if ($price != $product['price']) {
        // Redirect to the product verifiers page
        $updateStatusQuery = "UPDATE products SET status = 'pending' WHERE id = ?";
        $updateStatusStmt = $conn->prepare($updateStatusQuery);
        $updateStatusStmt->bind_param("i", $productId);
        $updateStatusStmt->execute();
    } 
        // Update the product details
        $updateQuery = "UPDATE products SET description = ?, price = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sdi", $description, $price, $productId);
        $updateStmt->execute();

        // Update the quantity in product_variants if necessary
        $updateVariantQuery = "UPDATE product_variants SET quantity = ? WHERE product_id = ?";
        $updateVariantStmt = $conn->prepare($updateVariantQuery);
        $updateVariantStmt->bind_param("ii", $quantity, $productId);
        $updateVariantStmt->execute();

        // Redirect back to the product list or show a success message
        header("Location: myproducts.php");
        exit();
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="../Styles/edit_product.css">
</head>
<body>
<h2>Edit Product</h2>
    <div class="form-container">
        <form action="" method="post">
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($product['description']); ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" min="0" required>

            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
</html>