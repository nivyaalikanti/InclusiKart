<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Login</title>
  <link rel="stylesheet" href="../Styles/admin_dashboard.css">
</head>
<body>
  <h1>Admin Dashboard</h1>
<?php
session_start(); // Start the session

// Define users with their roles and credentials
$users = [
  'profile' => ['username' => 'profile1', 'password' => 'pass123'],
  'product' => ['username' => 'admin', 'password' => 'password123'],
  'story'   => ['username' => 'story1',   'password' => 'pass123']
];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $role = $_POST['role'] ?? '';
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validate user credentials
  if (isset($users[$role]) && $users[$role]['username'] === $username && $users[$role]['password'] === $password) {
    $_SESSION['loggedin'] = true; // Set loggedin session variable
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;

    // Redirect to respective verifier dashboard
    if ($role === 'profile') {
      header('Location: profile_verifiers.php');
      exit();
    } elseif ($role === 'product') {
      header('Location: verifier_login.php');
      exit();
    } elseif ($role === 'story') {
      header('Location: story_verifier.php');
      exit();
    }
  } else {
    $error = "Invalid credentials. Please try again."; // Set error message
  }
}
?>
<div class="login-container">
  <h2>Login</h2>
  <?php if (!empty($error)): ?>
    <p class="error-message"><?= htmlspecialchars($error) ?></p> <!-- Display error message -->
  <?php endif; ?>
  <form method="POST">
    <select name="role" required>
      <option value="">Select Role</option>
      <option value="profile">Profile Verifier</option>
      <option value="product">Product Verifier</option>
      <option value="story">Story Verifier</option>
    </select>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</div>
</body>
</html>