<?php
session_start();
include 'db.php';
//navbar

$isLoggedIn = isset($_SESSION['user_id']);
$isBuyer = isset($_SESSION['buyer_id']);

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];

    // Fetch the latest status from the database for disabled users
    $query = "SELECT username, email, status FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username, $email, $status);
    $stmt->fetch();
    $stmt->close();
} elseif ($isBuyer) {
    $buyerId = $_SESSION['buyer_id'];

    // Fetch the latest status from the database for buyers
    $query = "SELECT username, email FROM buyers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $buyerId);
    $stmt->execute();
    $stmt->bind_result($username, $email);
    $stmt->fetch();
    $stmt->close();

    // Set a default status for buyers
    $status = "N/A"; // Buyers do not have a status in this context
} else {
    $username = "Guest";
    $email = "Not available";
    $status = "Pending";
}

// Set message based on status for disabled users
if ($isLoggedIn) {
    if ($status === "pending") {
        $statusMessage = '<p style="color: red;">Please <a href="submit_verification.php">submit your details</a> for verification.</p>';
    } elseif ($status === "submitted") {
        $statusMessage = '<p style="color: orange;">Your details have been sent. Please wait for verification.</p>';
    } elseif ($status === "verified") {
        $statusMessage = '<p style="color: green;">Your profile has been verified! You can now sell products and share stories.</p>';
    } else {
        $statusMessage = '<p style="color: gray;">Unknown status. Please contact support.</p>';
    }
} else {
    $statusMessage = ''; // No status message for buyers
}
//navbar ended
// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    // Check if user is logged in
    if (!isset($_SESSION['buyer_id'])) {
        header("Location: Buyer/blogin.php");
        exit();
    }

    $user_id = $_SESSION['buyer_id'];
    $product_id = $_POST['product_id'];
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

    header("Location: Buyer/cart.php");
    exit();
}

// ✅ Fetch all products to display
$productQuery = "SELECT * FROM products WHERE status = 'approved'";
$result = $conn->query($productQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shop</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Styles/shop.css">
</head>
<body>
<header>
        <a href="index.php">InclusiKart</a>
        <!-- <span class="menu-icon" id="menu-toggle">&#9776;</span> -->
    </header>
    <nav>
        <div id="nav-links">
            <a href="index.php" id="nav-home">Home</a>
            <a href="shop.php" id="nav-shop">Shop</a>
            <a href="Buyer/cart.php" id="nav-cart">Cart</a>
            <a href="stories.php" id="nav-stories">Stories</a>
            <a href="donation_requests.php" id="nav-donate">Donate</a>

            <?php if (isset($_SESSION['buyer_id']) || isset($_SESSION['user_id'])): ?>
    <img src="profile.png" alt="Profile" id="profile-btn" class="profile-icon">
<?php else: ?>


                <select onchange="location = this.value;">
                    <option disabled selected>Login</option>
                    <option value="Seller/login.php">Seller Login</option>
                    <option value="Buyer/blogin.php">Buyer  Login</option>
                </select>
                <select onchange="location = this.value;">
                    <option disabled selected>Sign Up</option>
                    <option value="Seller/signup.php">Seller</option>
                    <option value="Buyer/bsignup.php">Buyer</option>
                </select>
            <?php endif; ?>
        </div>
    </nav>
    <br>
    <!-- NAVBAR ENDED -->
     <br>
     <h3><i>Empowering individuals with special needs by creating meaningful employment through handcrafted products and inclusive workspaces that foster dignity and independence.</i></h3>

    <br>
    <div class="shop-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-container">
            <div class="product-card">
            <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="product-image" data-product-id="<?php echo $row['id']; ?>">
    <?php if (!empty($row['image'])): ?>
        <img src="uploads_products/<?php echo htmlspecialchars($row['image']); ?>" alt="Product" style="width:100%; height:auto;">
    <?php else: ?>
        <img src="default.jpg" alt="No Image">
    <?php endif; ?>
</a>
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p>Price: ₹<?php echo $row['price']; ?></p>
                <p>Description: <?php echo htmlspecialchars($row['description']); ?></p>
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            </div>
        <?php endwhile; ?>
    </div>
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
            <button class="cta-button" onclick="window.location.href='sell.php'">Register a Product</button>
            <button class="cta-button" onclick="window.location.href='share_story.php'">Share My Story</button>
            <button class="cta-button" onclick="window.location.href='help.php'">Help</button><br><br>
            <button id="my-products-btn"class="cta-button myproducts-btn" onclick="window.location.href='Seller/myproducts_details.php'">My Products Details</button>
            <button class="cta-button myproducts-btn" onclick="window.location.href='mystory.php'">My Story</button>
            <br><br>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($isBuyer): ?>
        <button class="cta-button myproducts-btn" onclick="window.location.href='Buyer/order_history.php'">My Orders</button>
    <?php endif; ?>
    <button class="logout-btn" onclick="window.location.href='Seller/logout.php'">Logout</button>
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
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.product-image').forEach(image => {
            image.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                const productId = this.dataset.productId; // Get the product ID

                // Increment views via AJAX
                fetch('Seller/increment_views.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: productId }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Views incremented:', data);
                    window.location.href = this.href; // Redirect to product detail page
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script src="./VoiceNavigation/navbar.js"></script>
</body>
</html>