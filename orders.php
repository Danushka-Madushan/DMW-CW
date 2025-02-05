<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'models/header.php';
include 'models/db.php';

if (!isset($_SESSION['user_id'])) {
    die('<script>location.replace("login.php");</script>');
}
?>
<link rel="stylesheet" href="./public/css/order.css">
<div class="container py-5">
    <?php
    $sql = "SELECT * FROM orders WHERE owner_id = '{$_SESSION['user_id']}';";
    $orders = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as $order) {
        $date_placed = new DateTime($order['placed_date']);
        $formattedPlacedDate = $date_placed->format("F j, Y");
        $date_estimate = new DateTime($order['estimate_delivery_date']);
        $formattedEstimateDate = $date_estimate->format("F j, Y");

        echo "<div class='card order-card mb-3'><div class='card-body p-4'>";
        echo "<div class='row align-items-center'><div class='col-auto'>";
        echo "<img src='https://api.iconify.design/material-symbols:package-2.svg?color=%23146eff' alt='Product' class='order-img'>";
        echo "</div><div class='col'><div class='d-flex justify-content-between align-items-center mb-3'>";
        echo "<h5 class='order-number mb-0'>ORDER #" . strtoupper(substr(hash('sha256', $order["placed_date"]), 0, 8)) . "</h5><span class='badge bg-success status-badge'>Delivered</span>";
        echo "</div></div></div><div class='order-details mt-4'><div class='row mt-3'>";
        echo "<div class='col-md-3 col-6 mb-3'><div class='detail-block'>";
        echo "<span class='label'>Order Date</span><span class='value'>{$formattedPlacedDate}</span></div></div>";
        echo "<div class='col-md-3 col-6 mb-3'><div class='detail-block'>";
        echo "<span class='label'>Total Amount</span><span class='value'>Rs {$order['order_total']}</span>";
        echo "</div></div><div class='col-md-3 col-6 mb-3'>";
        echo "<div class='detail-block'><span class='label'>Shipping Method</span>";
        echo "<span class='value'>Express Delivery</span>";
        echo "</div></div><div class='col-md-3 col-6 mb-3'><div class='detail-block'>";
        echo "<span class='label'>Delivery Estimate</span>";
        echo "<span class='value'>{$formattedEstimateDate}</span></div></div></div></div>";
        echo "<div class='order-actions mt-4 pt-3'>";
        echo "<button class='btn btn-primary me-2'>View Details</button>";
        echo "</div></div></div>";
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
