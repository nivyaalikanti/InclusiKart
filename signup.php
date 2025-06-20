<?php
include_once __DIR__ . '/db.php';

$message = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $message = "Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one number, and one special character.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        
        $check_query = "SELECT id FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "This email or username is already taken. Please try another.";
        } else {

            $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $message = "An error occurred. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="Styles/signup.css">
    
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
    <br><br><br>

<form method="POST" action="signup.php" onsubmit="return validatePassword()">
    <h2>Seller SignUp</h2>
    
    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <input type="text" name="username" id="username"placeholder="Username" required>
    <br>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <br>
    
    <div class="input-container">
        <input type="password" name="password" id="password" placeholder="Password"
               pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
               title="Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one number, and one special character."
               required>
               <i class="fa-solid fa-eye eye-icon" onclick="togglePassword('password', this)"></i>

    </div>
    
    <div class="input-container">
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
        <i class="fa-solid fa-eye eye-icon" onclick="togglePassword('password', this)"></i>

    </div>
    
    <p class="password-error" id="password-error">Passwords do not match.</p>
    <br>
    
    <button type="submit">Sign Up</button>
    <br><br>
    Already have an account?<a href="login.php">Login</a>
    <br>
</form>

<script>
    function validatePassword() {
        let password = document.getElementById("password").value;
        let confirm_password = document.getElementById("confirm_password").value;
        let errorMessage = document.getElementById("password-error");

        if (password !== confirm_password) {
            errorMessage.style.display = "block"; 
            return false;
        } else {
            errorMessage.style.display = "none"; 
            return true;
        }
    }

    function togglePassword(fieldId, eyeIcon) {
        let field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            field.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script>
if(annyang){
var commands = {
    'enter user name *tag':function(variable){
        let username = document.getElementById("username");
        username.value = variable;
    },
    'enter email *tag': function(variable){
        let email = document.getElementById("email");
        email.value = variable;
    },
    'enter password *tag':function(variable){
        let password = document.getElementById("password");
        let cleaned = variable.replace(/\s+/g, ''); // remove all spaces
        let capitalized = cleaned.charAt(0).toUpperCase() + cleaned.slice(1);
        password.value = capitalized;
    },
    'enter confirm password *tag':function(variable){
        let confirm_password = document.getElementById("confirm_password");
        let cleaned = variable.replace(/\s+/g, ''); // remove all spaces
        let capitalized = cleaned.charAt(0).toUpperCase() + cleaned.slice(1); // capitalize first letter
        confirm_password.value = capitalized;
    },
    'sign up': function() {
            document.querySelector('form').requestSubmit(); // submits the form with validation
    }
};
annyang.addCommands(commands);
annyang.start();
}
</script>
</body>
</html>
