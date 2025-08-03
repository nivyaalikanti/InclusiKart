<?php
session_start();
header('Content-Type: application/json');

include '../db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized access.']);
    exit;
}

$user_id = $_SESSION['user_id']; // Corrected variable name

// Get product IDs for this seller
$productStmt = $conn->prepare("SELECT id FROM products WHERE user_id = ?");
$productStmt->bind_param("i", $user_id);
$productStmt->execute();
$productResult = $productStmt->get_result();
$productIds = [];
while ($row = $productResult->fetch_assoc()) {
    $productIds[] = $row['id'];
}

if (empty($productIds)) {
    echo json_encode([
        'total_sales' => 0,
        'number_of_orders' => 0,
        'average_order_value' => 0
    ]);
    exit;
}

// Create placeholders
$placeholders = implode(',', array_fill(0, count($productIds), '?'));

// Fetch total sales and order count
$query = "
    SELECT 
        SUM(oi.quantity * oi.price) AS total_sales,
        COUNT(DISTINCT oi.order_id) AS number_of_orders
    FROM order_items oi  -- Corrected table name
    WHERE oi.product_id IN ($placeholders)
";

$stmt = $conn->prepare($query);
$types = str_repeat('i', count($productIds)); // create type string for bind_param
$stmt->bind_param($types, ...$productIds);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$totalSales = $data['total_sales'] ?? 0;
$numOrders = $data['number_of_orders'] ?? 0;
$aov = $numOrders > 0 ? ($totalSales / $numOrders) : 0;

echo json_encode([
    'total_sales' => round($totalSales, 2),
    'number_of_orders' => $numOrders,
    'average_order_value' => round($aov, 2)
]);
?>