<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Help Options</title>
    <link rel="stylesheet" href="../Styles/help.css">
</head>
<body>
    <div class="container">
        <h1>How would you like to get help?</h1>
        <a href="receive_donations.php"><button class="btn">Request Donations</button></a>
        <a href="get_raw_materials.php"><button class="btn">Request Raw Materials</button></a>
    </div>
</body>
</html>
