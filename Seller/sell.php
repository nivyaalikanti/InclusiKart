<?php
session_start();
// var_dump($_SESSION);
include '../db.php';
// include 'config.php'

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

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $materialsused = $_POST['materialsused'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Handle File Upload
    $targetDir = "../uploads_products/";
    $fileName = basename($_FILES["product_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only image formats
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFilePath)) {
            // Insert product details into the products table
            $query = "INSERT INTO products (user_id, name, image, description, price, status, materials_used) VALUES (?, ?, ?, ?, ?, 'pending',?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isssss", $userId, $productName, $fileName, $description, $price,$materialsused);
            if ($stmt->execute()) {
                // Get the last inserted product ID
                $productId = $stmt->insert_id;

                // Now insert the quantity and price into the product_variants table
                $queryVariant = "INSERT INTO product_variants (product_id, quantity, price) VALUES (?, ?, ?)";
                $stmtVariant = $conn->prepare($queryVariant);
                $stmtVariant->bind_param("iid", $productId, $quantity, $price); // Assuming price is a decimal
                if ($stmtVariant->execute()) {
                    echo "<script>alert('Product submitted for verification and variant added.');</script>";
                    // "<p class='success'>Product submitted for verification and variant added.</p>";
                } else {
                    echo "<p class='error'>Failed to add product variant.</p>";
                }
                $stmtVariant->close();
            } else {
                echo "<p class='error'>Database error while inserting product.</p>";
            }
            $stmt->close();
        } else {
            echo "<p class='error'>File upload failed.</p>";
        }
    } else {
        echo "<p class='error'>Invalid file format.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Your Product</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../Styles/sell.css">
</head>
<body>
<header>
        <a href="index.php">InclusiKart</a>
        <!-- <span class="menu-icon" id="menu-toggle">&#9776;</span> -->
    </header>
    <nav>
        <div id="nav-links">
            <a href="../index.php" id="nav-home">Home</a>
            <a href="../shop.php" id="nav-shop">Shop</a>
            <a href="cart.php" id="nav-cart">Cart</a>
            <a href="../stories.php" id="nav-stories">Stories</a>
            <a href="../donation_requests.php" id="nav-donate">Help</a>

            <?php if (isset($_SESSION['buyer_id']) || isset($_SESSION['user_id'])): ?>
    <img src="../profile.png" alt="Profile" id="profile-btn" class="profile-icon">
<?php else: ?>


                <select onchange="location = this.value;">
                    <option disabled selected>Login</option>
                    <option value="login.php">Disabled Login</option>
                    <option value="blogin.php">User  Login</option>
                </select>
                <select onchange="location = this.value;">
                    <option disabled selected>Sign Up</option>
                    <option value="signup.php">Disabled</option>
                    <option value="bsignup.php">buyer</option>
                </select>
            <?php endif; ?>
        </div>
    </nav><br>
    <div class="sellp">
    <div class="form-container">
        <h2>Sell Your Product</h2>
        <form action="sell.php" method="post" enctype="multipart/form-data">
            <label>Product Name:</label>
            <input type="text" name="product_name" id="product-name"required>
            <br><br>
            <label>Upload Product Image:</label>
            <input type="file" name="product_image" class="upload" id="product-image"required>
            <br><br>
            <label>Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>
            <label>Materials used:</label>
            <textarea name="materialsused" id="materials-used" rows="4" required></textarea>
            <br><br>
            <label>Price:</label>
            <input type="text"id="price"  name="price" required>
            <label>Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>
            <br><br>
            <input type="submit" class="submit-btn"id="submit-product" value="Submit Product">
        </form>
    </div></div>
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
            <button id="my-products-btn"class="cta-button myproducts-btn" onclick="window.location.href='myproducts_details.php'">My Products Details</button>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script src="./VoiceNavigation/navbar.js"></script>
<script>
if (annyang) {
    console.log("Voice activated ✅");

    var commands = {
        // Set product name
        'product name *name': function(name) {
            document.getElementById('product-name').value = name;
        },

        // Set description
        'description *desc': function(desc) {
            document.getElementById('description').value = desc;
        },

        // Set materials
        'materials used *materials': function(materials) {
            document.getElementById('materials-used').value = materials;
        },

        // Set price
        'price *price': function(price) {
            document.getElementById('price').value = price;
        },

        // Set quantity
        'quantity *quantity': function(quantity) {
            document.getElementById('quantity').value = quantity;
        },

        // Upload image
        'upload image': function() {
            document.getElementById('product-image').click();
        },

        // Submit form
        'submit product': function() {
            document.getElementById('submit-product').click();
        }
    };

    annyang.addCommands(commands);
    annyang.start({ autoRestart: true, continuous: false });
}
</script>

</body>
</html>
