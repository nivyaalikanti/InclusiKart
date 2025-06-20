<?php
session_start();
include 'db.php';

$message = "";

// Check if the user is already logged in
$isLoggedIn = isset($_SESSION['user_id']);
$isBuyer = isset($_SESSION['buyer_id']);

if ($isLoggedIn) {
    // Fetch user details if logged in
    $userId = $_SESSION['user_id'];
    $query = "SELECT username, email, status FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username, $email, $status);
    $stmt->fetch();
    $stmt->close();
} elseif ($isBuyer) {
    // Fetch buyer details if logged in
    $buyerId = $_SESSION['buyer_id'];
    $query = "SELECT username, email FROM buyers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $buyerId);
    $stmt->execute();
    $stmt->bind_result($username, $email);
    $stmt->fetch();
    $stmt->close();
    $status = "N/A"; // Default status for buyers
} else {
    $username = "Guest";
    $email = "Not available";
    $status = "Pending";
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameInput = trim($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT id, username, email, password, status FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usernameInput);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['status'] = $user['status'];

            // Redirect based on user status
            if ($user['status'] === 'Pending') {
                header("Location: verification_pending.php");
            } elseif ($user['status'] === 'Verified') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $message = "❌ Incorrect password. Please try again.";
        }
    } else {
        $message = "⚠️ Username not found. Please sign up.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InclusiKart - Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Styles/login.css">
</head>
<body>

    <header>
        <a href="index.php">InclusiKart</a>
        <span class="menu-icon" id="menu-toggle">&#9776;</span>
    </header>
    <nav>
        <div id="nav-links">
            <a href="index.php">Home</a>
            <a href="shop.php">Shop</a>
            <a href="cart.php">Cart</a>
            <a href="stories.php">Stories</a>
            <a href="donation_requests.php">Donate</a>

            <?php if (isset($_SESSION['buyer_id']) || isset($_SESSION['user_id'])): ?>
                <img src="profile.png" alt="Profile" id="profile-btn" class="profile-icon">
            <?php else: ?>
                <select onchange="location = this.value;">
                    <option disabled selected>Login</option>
                    <option value="login.php">Seller Login</option>
                    <option value="blogin.php">Buyer  Login</option>
                </select>
                <select onchange="location = this.value;">
                    <option disabled selected>Sign Up</option>
                    <option value="signup.php">Seller</option>
                    <option value="bsignup.php">Buyer</option>
                </select>
            <?php endif; ?>
        </div>
    </nav>
    <br><br><br><br>
    <div class="container">
        <h2>Seller Login</h2>
        <?php if (!empty($message)) { echo "<p class='error'>$message</p>"; } ?>
        <form method="POST" action="login.php">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit">Login</button>
        </form>
        <br>
        <h5>Don't have an account? <a href="signup.php">Sign up</a></h5>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script>
if(annyang){
var commands = {
    'enter user name *tag':function(variable){
        let username = document.getElementById("username");
        username.value = variable;
    },
    
    'enter password *tag':function(variable){
        let password = document.getElementById("password");
        let cleaned = variable.replace(/\s+/g, ''); // remove all spaces
        let capitalized = cleaned.charAt(0).toUpperCase() + cleaned.slice(1);
        password.value = capitalized;
    },
    
    'login': function() {
        document.querySelector('form').requestSubmit(); // submits the form with validation
    }
};
annyang.addCommands(commands);
annyang.start();
}
</script>
</body>
</html>