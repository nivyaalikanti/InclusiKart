<?php
session_start();
include '../db.php'; // Include your database connection file

// Assuming you have the buyer_id and product_id from the form submission
$buyer_id = $_POST['buyer_id'];
$product_id = $_POST['product_id'];
$total = $_POST['total']; // Total price of the order

// Calculate the estimated delivery date
$date = new DateTime('now'); // Start from the current date
$date->modify('next Saturday 14:00');
$order_cutoff = new DateTime('now');
$order_cutoff->modify('next Saturday 13:45');

if ($date > $order_cutoff) {
    $date->modify('+1 weekday');
}

if ($date->format('N') >= 6) {
    $date->modify('next Monday');
}

$date->modify('+3 weekdays');
$estimated_delivery = $date->format('Y-m-d H:i:s'); // Format for MySQL DATETIME

// Insert the order into the database
$query = "INSERT INTO orders (buyer_id, total, created_at, estimated_delivery) VALUES (?, ?, NOW(), ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ids", $buyer_id, $total, $estimated_delivery);

if ($stmt->execute()) {
    echo "Order created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>