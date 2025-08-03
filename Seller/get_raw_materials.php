<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $products = $_POST['products']; // Ensure this field is still used
    $materials_needed = $_POST['materials_needed'];

    // Updated SQL Query to insert into the correct columns
    $sql = "INSERT INTO raw_material_requests (user_id, name, age, contact, address, products, raw_materials_needed)
            VALUES ('$user_id', '$name', '$age', '$contact', '$address', '$products', '$materials_needed')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Raw material request submitted!'); window.location.href='help.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Get Raw Materials</title>
    <link rel="stylesheet" href="../Styles/get_raw_materials.css">
</head>
<body>

<form method="POST" action="get_raw_materials.php">
        <h2>Request Raw Materials</h2>

        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" required>

        <label for="age">Age</label>
        <input type="number" name="age" id="age" required>

        <label for="contact">Contact Number</label>
        <input type="text" name="contact" id="contact" required>

        <label for="address">Address</label>
        <textarea name="address" id="address" rows="3" required></textarea>

        <label for="products">Products You've Made</label>
        <textarea name="products" id="products" rows="3" required></textarea>

        <label for="materials_needed">Raw Materials Needed</label>
        <textarea name="materials_needed" id="materials_needed" rows="3" required></textarea>

        <button type="submit">Submit Request</button>
</form>

</body>
</html>
