<?php
session_start();
include 'db.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isBuyer = isset($_SESSION['buyer_id']);
$product_id = $_GET['id'] ?? 0; // Get product ID from the query string

if ($product_id != 0) {
    // Fetch product details from the database
    $query = "SELECT p.name, p.price, p.description, p.image, pv.quantity 
              FROM products p 
              JOIN product_variants pv ON p.id = pv.product_id 
              WHERE p.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($name, $price, $description, $image, $quantity);
    $stmt->fetch();
    $stmt->close();
} else {
    // Handle case where product ID is not valid
    echo "Product not found.";
    exit();
}

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    // Check if user is logged in
    if (!isset($_SESSION['buyer_id'])) {
        header("Location: blogin.php");
        exit();
    }

    $user_id = $_SESSION['buyer_id'];
    $product_id = $_POST['product_id']; // Ensure this is set correctly
    $quantity = (int)$_POST['quantity'];

    // Check if product already exists in cart
    $checkQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $updateQuery = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("iii", $quantity, $user_id, $product_id);
        $updateStmt->execute();
    } else {
        $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("iii", $user_id, $product_id, $quantity);
        $insertStmt->execute();
    }

    header("Location: cart.php");
    exit();
}

// Handle Demand Request
if (isset($_POST['request_product'])) {
    // Check if user is logged in
    if (!isset($_SESSION['buyer_id'])) {
        header("Location: blogin.php");
        exit();
    }

    $buyer_id = $_SESSION['buyer_id'];
    $quantity = (int)$_POST['request_quantity'];

    // Insert request into the database
    $requestQuery = "INSERT INTO demand_requests (buyer_id, product_id, quantity) VALUES (?, ?, ?)";
    $requestStmt = $conn->prepare($requestQuery);
    $requestStmt->bind_param("iii", $buyer_id, $product_id, $quantity);
    $requestStmt->execute();

    // Redirect or show a success message
    echo "<script>alert('Your request has been submitted!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($name); ?> - Product Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Styles/product_detail.css">
</head>
<body>
    <div class="productdetails">
        <h2>Product ID : IK<?php echo htmlspecialchars($product_id); ?></h2>
        <h1><?php echo htmlspecialchars($name); ?></h1>
        <h2>Price: ₹<?php echo htmlspecialchars($price); ?></h2>
        <p><?php echo htmlspecialchars($description); ?></p>
        <h2>Quantity Available: <?php echo htmlspecialchars($quantity); ?></h2>
        
        <?php if (!empty($image)): ?>
            <img src="uploads_products/<?php echo htmlspecialchars($image); ?>" alt="Product Image">
        <?php else: ?>
            <img src="default.jpg" alt="No Image">
        <?php endif; ?>
        <br><br>
        <form method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>"> <!-- Corrected to use $product_id -->
            Quantity : <input type="number" name="quantity" value="1" min="1">
            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
        <!-- Demand Request Form -->
        <form method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
            <label for="request_quantity">Request Quantity:</label>
            <input type="number" name="request_quantity" id="request_quantity" min="1" required>
            <button type="submit" name="request_product">Request Product</button>
        </form>
        <button><a href="shop.php">Back to Shop</a></button>
    </div>
</body>
</html>