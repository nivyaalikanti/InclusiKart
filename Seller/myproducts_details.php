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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="../style.css">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../Styles/myproducts_details.css">
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
            <a href="../donation_requests.php" id="nav-donate">Donate</a>

            <?php if (isset($_SESSION['buyer_id']) || isset($_SESSION['user_id'])): ?>
    <img src="../profile.png" alt="Profile" id="profile-btn" class="profile-icon">
<?php else: ?>


                <select onchange="location = this.value;">
                    <option disabled selected>Login</option>
                    <option value="login.php">Seller Login</option>
                    <option value="../Buyer/blogin.php">Buyer  Login</option>
                </select>
                <select onchange="location = this.value;">
                    <option disabled selected>Sign Up</option>
                    <option value="signup.php">Seller</option>
                    <option value="../Buyer/bsignup.php">Buyer</option>
                </select>
            <?php endif; ?>
        </div>
    </nav>
    <div class="content">
  <div class="sidebar">
    <ul>
      <li id="my-products" onclick="loadPage('myproducts.php')">My Products</li>
      <li id="update-products" onclick="loadPage('update_product_quantity.php')">Update My Products</li>
      <li id="received-orders" onclick="loadPage('view_orders.php')">Received Orders</li>
      <li id="demand-requests" onclick="loadPage('gotdemand_requests.php')">Requests</li>
      <li id="seller-report" onclick="loadPage('seller_report.php')">Report</li>
    </ul>
  </div>

  <iframe id="content-frame" src="myproducts.php"></iframe></div>
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
            <button class="cta-button myproducts-btn" onclick="window.location.href='myproducts_details.php'">My Products Details</button>
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
  <script>
    function loadPage(page) {
      document.getElementById('content-frame').src = page;
    }
  </script>
<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script src="./VoiceNavigation/navbar.js"></script>
<script>
    if (annyang) {
  console.log("Voice activated ✅");

  var commands = {
  // For My Products
  'go to my products': () => document.getElementById('my-products').click(),
  'open my products': () => document.getElementById('my-products').click(),
  'show my products': () => document.getElementById('my-products').click(),
  'my products': () => document.getElementById('my-products').click(),

  // For Update Products
  'update my products': () => document.getElementById('update-products').click(),
  'show my products': () => document.getElementById('update-products').click(),
  'go to update my products': () => document.getElementById('update-products').click(),
  'change product quantity': () => document.getElementById('update-products').click(),

  // For Received Orders
  'show received orders': () => document.getElementById('received-orders').click(),
  'go to received orders': () => document.getElementById('received-orders').click(),
  'open my orders': () => document.getElementById('received-orders').click(),
  'received orders': () => document.getElementById('received-orders').click(),

  // For Requests
  'open request': () => document.getElementById('demand-requests').click(),
  'go to requests': () => document.getElementById('demand-requests').click(),
  'received requests': () => document.getElementById('demand-requests').click(),
  'requests': () => document.getElementById('demand-requests').click(),

  // For Report
  'show report': () => document.getElementById('seller-report').click(),
  'open report': () => document.getElementById('seller-report').click(),
  'go to report': () => document.getElementById('seller-report').click(),
  'report': () => document.getElementById('seller-report').click(),
};


  annyang.addCommands(commands);
  annyang.start();
}

</script>
</body>
</html>
