<?php
include 'db.php'; // Ensure $pdo is properly initialized

function placeOrder ($owner_id, $order_items, $order_total) {
    $estimate_delivery_date = date('Y-m-d H:i:s', strtotime('+5 days')); // +5 days
    global $conn;
    // Prepare MySQL INSERT statement
    $stmt = $conn->prepare("INSERT INTO orders (owner_id, estimate_delivery_date, order_total, order_items) VALUES (:owner_id, :estimate_delivery_date, :order_total, :order_items)");
    
    // Execute with bound parameters
    $stmt->execute([
        ':owner_id' => $owner_id,
        ':estimate_delivery_date' => $estimate_delivery_date,
        ':order_total' => $order_total,
        ':order_items' => json_encode($order_items),
    ]);
}
?>
