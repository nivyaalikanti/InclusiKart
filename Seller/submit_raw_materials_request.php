<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $products = $_POST['products'];
    $raw_materials_needed = $_POST['raw_materials_needed'];

    $sql = "INSERT INTO raw_material_requests (user_id, name, age, contact, address, products, raw_materials_needed)
            VALUES ('$user_id', '$name', '$age', '$contact', '$address', '$products', '$raw_materials_needed')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Raw material request submitted successfully!'); window.location.href='help.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
