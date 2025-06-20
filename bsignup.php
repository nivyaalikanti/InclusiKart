<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Check if email or username already exists using prepared statements
    $checkQuery = "SELECT * FROM buyers WHERE email = ? OR username = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('User already exists! Please login.'); window.location='blogin.php';</script>";
        exit();
    }

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data using prepared statement
    $sql = "INSERT INTO buyers (name, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script> window.location='blogin.php';</script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Signup - InclusiKart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Styles/bsignup.css">
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
            <a href="donation_requests.php">Help</a>

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
<!-- <header><a href="index.html">InclusiKart</a></header> -->

<div class="container">
    <h2>Buyer Signup</h2>
    <form id="signupForm" method="POST" action="bsignup.php">
        
        <input type="text" id="name" placeholder="Full Name"name="name" pattern="^[A-Za-z\s]{3,}$"
            title="Full name must contain at least 3 characters and should only include letters and spaces." required>
        <br>
        <input type="email" id="email" placeholder="Email Address"name="email" required>
        <br>
        
        <input type="text" id="username" placeholder="Username"name="username" pattern="^[A-Za-z0-9]{5,}$"
            title="Username must be at least 5 characters long and contain only letters and numbers." required>
        <br>
        
        <input type="password" id="password" placeholder="Password"name="password"pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one number, and one special character." required>
        <br>
        
        <input type="password" id="confirm_password" placeholder="Confirm Password"name="confirm_password" required>
        <br><br>
        <button type="submit">Sign Up</button>
    </form>
    <br>
    Already have an account?<a href="blogin.php"> Login</a>
</div>

<script>
    document.getElementById("signupForm").addEventListener("submit", function(event) {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&])[A-Za-z\d@$!%?&]{8,}$/;

    if (!password.match(passwordPattern)) {
        // alert("Password must be at least 8 characters long, include uppercase, lowercase, number, and special character.");
        event.preventDefault();
    } else if (password !== confirmPassword) {
        alert("Passwords do not match!");
        event.preventDefault();
    }
});

</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script>
    if (annyang) {
  // Let's define our first command. First the text we expect, and then the function it should call
  var commands = {
    'enter full name *tag': function(variable) {
      let fullname = document.getElementById("name");
      fullname.value = variable;
    },
    'enter email *tag': function(variable) {
      let email = document.getElementById("email");
      email.value = variable;
    },
    'enter username *tag': function(variable){
        let username = document.getElementById("username");
        username.value = variable;
    },
    'enter password *tag':function(variable){
        let password = document.getElementById("password");
        password.value = variable;
    },
    'enter confirm password *tag':function(variable){
        let confirm_password = document.getElementById("confirm_password");
        confirm_password.value = variable;
    }
    

  };

  // Add our commands to annyang
  annyang.addCommands(commands);

  // Start listening. You can call this here, or attach this call to an event, button, etc.
  annyang.start();
}
</script>
</body>
</html>