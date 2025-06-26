<?php
include '../db.php';
session_start();


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
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM buyers WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['buyer_id'] = $row['id']; 
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Login</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../Styles/blogin.css">
    
</head>
<body>
<header>
    <a href="index.php">InclusiKart</a>
    <!-- <span class="menu-icon" id="menu-toggle">&#9776;</span> -->
</header>

<nav>
    <div id="nav-links">
        <a href="../index.php">Home</a>
        <a href="../shop.php">Shop</a>
        <a href="cart.php">Cart</a>
        <a href="../stories.php">Stories</a>
        <a href="../donation_requests.php">Donate</a>

        <?php if ($isLoggedIn || $isBuyer): ?>
            <img src="../profile.png" alt="Profile" id="profile-btn" class="profile-icon" onclick="showProfilePopup()">
        <?php else: ?>
            <select onchange="location = this.value;">
                <option "disabled selected>Login</option>
                <option value="../Seller/login.php">Seller Login</option>
                <option value="blogin.php">Buyer Login</option>
            </select>
            <select onchange="location = this.value;">
                <option disabled selected>Sign Up</option>
                <option value="../Seller/signup.php">Seller</option>
                <option value="bsignup.php">Buyer</option>
            </select>
        <?php endif; ?>
    </div>
</nav>

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

    <div class="container container1">
        <h2>Buyer Login</h2>
        <?php if ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="blogin.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button class="loginbtn" id="loginBtn"type="submit">Login</button>
        </form>
        <br>
        <p>New user? <a href="bsignup.php">Signup here</a></p>
    </div>
    <button type="button" onclick="startVoiceInput()">Fill by Voice</button>

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
    document.getElementById("menu-toggle").addEventListener("click", function () {
        var navLinks = document.getElementById("nav-links");
        navLinks.classList.toggle("active");
    });
</script>
<script src="VoiceNavigation/blogin.js">

</script>

</body>
</html>
