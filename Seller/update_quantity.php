<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the product variant ID and new quantity from the form
    $productVariantId = $_POST['product_variant_id'];
    $newQuantity = $_POST['quantity'];

    // Prepare the SQL statement to update the quantity
    $query = "UPDATE product_variants SET quantity = ? WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $newQuantity, $productVariantId);

    if ($stmt->execute()) {
        // Redirect back to My Products page with a success message
        $_SESSION['message'] = "Quantity updated successfully.";
    } else {
        // Redirect back to My Products page with an error message
        $_SESSION['message'] = "Error updating quantity. Please try again.";
    }

    $stmt->close();
    header("Location: myproducts.php");
    exit();
} else {
    // If the request method is not POST, redirect to My Products page
    header("Location: myproducts.php");
    exit();
}
?>