<?php
session_start();
include '../db.php';

// Check if the user is logged in as a buyer
$isBuyer = isset($_SESSION['buyer_id']);

if ($isBuyer) {
    $buyerId = $_SESSION['buyer_id'];

    // Fetch the latest status from the database for buyers
    $query = "SELECT username, email FROM buyers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $buyerId);
    $stmt->execute();
    $stmt->bind_result($username, $email);
    $stmt->fetch();
    $stmt->close();
} else {
    $username = "Guest";
    $email = "Not available";
    $status = "Pending";
}



// Check if buyer is logged in
if (!$isBuyer) {
    header("Location: blogin.php");
    exit();
}

$user_id = $_SESSION['buyer_id']; // Use buyer_id for cart operations

$total = 0;

// Handle Remove from Cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    $removeQuery = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $removeStmt = $conn->prepare($removeQuery);
    $removeStmt->bind_param("ii", $user_id, $product_id); // Ensure this uses buyer_id
    $removeStmt->execute();
    header("Location: cart.php"); // Redirect to the cart page after removal
    exit();
}

// Fetch cart items from the database, including product images
$cartQuery = "SELECT p.name, p.price, c.quantity, p.image, p.id AS product_id 
              FROM cart c 
              JOIN products p ON c.product_id = p.id 
              WHERE c.user_id = ?"; // Ensure this uses buyer_id
$stmt = $conn->prepare($cartQuery);
$stmt->bind_param("i", $user_id); // Ensure this uses buyer_id
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../Styles/cart.css">
<title>Your Cart</title>
</head>
<body>
<header>
    <a href="index.php">InclusiKart</a>
</header>
<nav>
    <div id="nav-links">
        <a href="../index.php">Home</a>
        <a href="../shop.php">Shop</a>
        <a href="cart.php">Cart</a>
        <a href="../stories.php">Stories</a>
        <a href="../donation_requests.php">Help</a>

        <?php if (isset($_SESSION['buyer_id'])): ?>
            <img src="../profile.png" alt="Profile" id="profile-btn" class="profile-icon">
        <?php else: ?>
            <select onchange="location = this.value;">
                <option disabled selected>Login</option>
                <option value="login.php">Seller Login</option>
                <option value="blogin.php">Buyer Login</option>
            </select>
            <select onchange="location = this.value;">
                <option disabled selected>Sign Up</option>
                <option value="signup.php">Seller</option>
                <option value="bsignup.php">Buyer</option>
            </select>
        <?php endif; ?>
    </div>
</nav>
<br>
<h2>Your Shopping Cart</h2>
<br>
<?php if ($result->num_rows === 0): ?>
    <p style="text-align:center;">Your cart is empty.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Price (₹)</th>
            <th>Quantity</th>
            <th>Subtotal (₹)</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): 
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        ?>
            <tr>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="../uploads_products/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image" class="product-image">
                    <?php else: ?>
                        <img src="default.jpg" alt="No Image" class="product-image">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $subtotal; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button type="submit" name="remove_from_cart" class="remove-button">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        <tr class="total">
            <td colspan="4">Total</td>
            <td>₹<?php echo $total; ?></td>
            <td></td>
        </tr>
    </table>
    <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
<?php endif; ?>
        <!-- Profile Popup -->
        <div class="overlay" id="overlay"></div>
    <div class="profile-popup" id="profile-popup">
    <h2>Your Profile</h2>
    <p><b>Username:</b> <?php echo htmlspecialchars($username); ?></p>
    <p><b>Email:</b> <?php echo htmlspecialchars($email); ?></p>
    <?php if ($isLoggedIn): ?>
        <p id="status-color"><b>Status:</b> <?php echo htmlspecialchars($status); ?></p>
        <?php echo $statusMessage; ?>

        <?php if ($status === "verified"): ?>
            <br>
            <button class="cta-button" onclick="window.location.href='sell.php'">Sell Products</button>
            <button class="cta-button" onclick="window.location.href='share_story.php'">Share My Story</button>
            <button class="cta-button" onclick="window.location.href='help.php'">Help</button><br><br>
            <button class="cta-button myproducts-btn" onclick="window.location.href='myproducts.php'">My Products</button>
            <button class="cta-button myproducts-btn" onclick="window.location.href='mystory.php'">My Story</button>
            <br><br>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($isBuyer): ?>
        <button class="cta-button myproducts-btn" onclick="window.location.href='order_history.php'">My Orders</button>
    <?php endif; ?>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    <button class="close-btn" id="close-popup">Close</button>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let profileBtn = document.getElementById("profile-btn");
            let profilePopup = document.getElementById("profile-popup");
            let overlay = document.getElementById("overlay");
            let closePopup = document.getElementById("close-popup");

            if (profileBtn) {
                profileBtn.addEventListener("click", function (event) {
                    event.preventDefault();
                    profilePopup.style.display = "block";
                    overlay.style.display = "block";
                });
            }

            closePopup.addEventListener("click", function () {
                profilePopup.style.display = "none";
                overlay.style.display = "none";
            });

            overlay.addEventListener("click", function () {
                profilePopup.style.display = "none";
                overlay.style.display = "none";
            });
        });
    </script>
</body>
</html>