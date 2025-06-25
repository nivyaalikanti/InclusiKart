<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: admin_dashboard.php"); // Redirect to the login page
exit();
?>