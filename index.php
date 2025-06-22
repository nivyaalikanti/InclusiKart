<?php
session_start();
include 'db.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isBuyer = isset($_SESSION['buyer_id']);

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];

    $query = "SELECT username, email, status FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username, $email, $status);
    $stmt->fetch();
    $stmt->close();
} elseif ($isBuyer) {
    $buyerId = $_SESSION['buyer_id'];

    $query = "SELECT username, email FROM buyers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $buyerId);
    $stmt->execute();
    $stmt->bind_result($username, $email);
    $stmt->fetch();
    $stmt->close();

    $status = "N/A"; 
} else {
    $username = "Guest";
    $email = "Not available";
    $status = "Pending";
}

if ($isLoggedIn) {
    if ($status === "pending") {
        $statusMessage = '<p style="color: red;">Please <a href="submit_verification.php">submit your details</a> for verification.</p>';
    } elseif ($status === "submitted") {
        $statusMessage = '<p style="color: orange;">Your details have been sent for verification. Please wait for our response.</p>';
    } elseif ($status === "verified") {
        $statusMessage = '<p style="color: green;">Your profile has been verified! You can now sell products and share stories.</p>';
    } else {
        $statusMessage = '<p style="color: gray;">Unknown status. Please contact support.</p>';
    }
} else {
    $statusMessage = ''; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InclusiKart - Empowering Talent</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header */
        header {
            background:rgba(179, 226, 226, 0.8);
            color:rgba(0, 0, 0, 0.8);
            padding: 15px 20px;
            display: flex;
            justify-content: center; 
            align-items: center;
        }

        header a {
            color: #00437a;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }

        .menu-icon {
            font-size: 24px;
            cursor: pointer;
            color: white;
        }

        /* Navbar */
        nav {
            background:  #00437a;
            padding: 10px 20px;
            display: flex;
            justify-content: center; 
            align-items: center;
            position: relative; 
        }

        #nav-links {
            position: absolute; 
            top: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        #nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 5px 10px;
            transition: 0.3s;
        }

        #nav-links a:hover {
            border-radius: 5px;
        }

        #nav-links select {
            background: white;
            border: 1px solid white;
            color: black;
            font-size: 16px;
            padding: 5px;
            cursor: pointer;
            border-radius: 5px;
        }

        #nav-links select:focus {
            outline: none;
        }

        /* Profile Icon */
        .profile-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid white;
            vertical-align: middle;
        }

        /* Profile Popup */
        .profile-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            z-index: 1000;
            width: 500px;
            line-height:2.0;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .close-btn, .logout-btn {
            background:  #00437a;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            margin-top: 10px;
            border:2px solid  #00437a;
            border-radius:5px;
            margin:10px;
        }

        .close-btn {
            background: white;
            color: #00437a;
        }

        
        header, nav {
            height: 60px;
            display: flex;
            align-items: center;
            padding:40px;
        }
        .myproducts-btn{
            background-color:white;
            color:#00437a;
            border:2px solid #00437a;
            padding:10px;
            font-weight:bold;
        }
        .myproducts-btn:hover{
            background-color:rgb(228, 239, 249);
        }
        
        .info-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
  }
  .info-box {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    align-items: center;
    background: #f5f5f5;
    border-radius: 10px;
    padding: 20px;
  }
  .info-box img {
    width: 250px;
    height: auto;
    border-radius: 10px;
    flex-shrink: 0;
    object-fit: cover;
  }
  .info-box > div {
    flex: 1;
    line-height: 1.6;
  }
  .info-box h2 {
    margin-bottom: 10px;
    color: #00437a;
  }
  .info-box p {
    color: #333;
    margin-bottom:20px;
  }
  
        /* Responsive Design */
        @media screen and (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: center;
            }

            #nav-links {
                flex-direction: column;
                width: 100%;
                text-align: center;
            }

            #nav-links a, #nav-links select {
                width: auto;
            }
        }
        @media screen and (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: center;
            }
            #nav-links {
                flex-direction: column;
                width: 100%;
                text-align: center;
            }
        }
        .container{
            line-height: 2.0;
        }

        .info-box{
            line-height:1.8;
            padding:40px;
        }
        .info-section a{
            text-decoration:none;
            color:white;
        }
        article{
            display:flex;
            flex-wrap: wrap;
            padding:20px;
            
        }
        @media screen and (max-width: 768px) {
    .menu-icon {
        display: block;
    }
    nav {
        flex-direction: column;
        align-items: flex-start;
    }
    #nav-links {
        left: 50%;
        transform: translateX(-50%);
        display: none;
        flex-direction: column;
        width: 100%;
        /* max-width: 300px; */
        background-color: #00437a;
    }
    #nav-links.active {
        display: flex;
        flex-direction: column;
    }
    #nav-links a {
        padding: 10px;
        width: 91%;
        text-align: center;
    }
    .info-box {
      flex-direction: column;
      padding: 15px;
      text-align: center;
    }
    .info-box img {
      width: 100%;
      max-width: 400px;
      margin-bottom: 15px;
      border-radius: 8px;
    }
    .info-box > div {
      flex: unset;
    }
    .welcome {
    font-size: 1.5rem; 
  }
  .container p {
    font-size: 0.9rem; 
  }
}
    </style>
</head>
<body>
    <button onclick="startListening()" style="position: fixed; bottom: 20px; right: 20px; padding: 10px 15px; background-color: #00437a; color: white; border: none; border-radius: 50%; font-size: 20px;">
    🎤
    </button>
    <div id="voice-feedback" aria-live="polite" style="position: absolute; left: -9999px; height: 1px; width: 1px; overflow: hidden;"></div>

    <header>
        <a href="index.php">InclusiKart</a>
        <span class="menu-icon" id="menu-toggle">&#9776;</span>
        
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
                    <option value="login.php">Seller Login</option>
                    <option value="Buyer/blogin.php">Buyer  Login</option>
                </select>
                <select onchange="location = this.value;">
                    <option disabled selected>Sign Up</option>
                    <option value="signup.php">Seller</option>
                    <option value="Buyer/bsignup.php">Buyer</option>
                </select>
            <?php endif; ?>
        </div>
    </nav>
    <!-- NAVBAR ENDED -->
    <div class="container">
        <h1 class="welcome">Where ability meets Opportunity</h1>
        <p class="wel-para">Shop handcrafted treasures made by skilled individuals with disabilities. Every purchase fuels their passion, fosters independence, and creates lasting impact.</p>
        <!-- <button class="cta-button">Explore Now</button> -->
    </div>
    <section class="info-section">
        <article class="info-box">
            <img src="images/Crafts.jpg" alt="Inspiring Stories" />
            <div>
                <h2>Sell Handmade Products</h2>
                
                <p>Discover beautifully handcrafted items made by talented artisans with disabilities. Fom intricate jewelry to unique home decor, each piece carries a story of resilience and creativity. Your purchase directly supports their journey toward financial independencce and self-reliance</p>
                <button class="cta-button" onclick="window.location.href='stories.php'">Read Inspiring Stories</button>
            </div>
        </article>
        <article class="info-box">
            <img src="images/inspiringStories.png" alt="Inspiring Stories" />
            <div>
                <h2>Inspiring Stories</h2>
                <h4>Stories That Inspire, Strength That Shines</h4>
                <p>Challenges don’t define a person—determination does. These powerful stories showcase individuals who turned obstacles into opportunities, proving that talent and perseverance can break any barrier. Be inspired by their journeys and celebrate the strength that knows no limits!</p>
                <button class="cta-button" onclick="window.location.href='stories.php'">Read Inspiring Stories</button>
            </div>
        </article>
    </section>

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
            <button id="my-products-btn" class="cta-button myproducts-btn" onclick="window.location.href='myproducts_details.php'">My Products Details</button>
            <button  class="cta-button myproducts-btn" onclick="window.location.href='mystory.php'">My Story</button>
            <br><br>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($isBuyer): ?>
        <button class="cta-button myproducts-btn" onclick="window.location.href='Buyer/order_history.php'">My Orders</button>
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
    document.addEventListener("DOMContentLoaded", function() {
        const menuToggle = document.getElementById("menu-toggle");
        const navLinks = document.getElementById("nav-links");
        
        menuToggle.addEventListener("click", function() {
            navLinks.classList.toggle("active");
        });
    });
</script>
<script>
        
        document.addEventListener("DOMContentLoaded", function() {
            const text = "Where Ability meets Opportunity";
            const element = document.querySelector(".welcome");
            let index = 0;

            function typeEffect() {
                if (index < text.length) {
                    element.textContent += text.charAt(index);
                    index++;
                    setTimeout(typeEffect, 50); 
                }
            }

            element.textContent = ""; 
            typeEffect();
        });
</script>
<!-- <script src="VoiceNavigation/index.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script src="./VoiceNavigation/navbar.js"></script>

</body>
</html>