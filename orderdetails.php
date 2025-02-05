<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'models/header.php';
include 'models/db.php';
include 'models/utils.php';

if (!isset($_SESSION['user_id'])) {
    die('<script>location.replace("login.php");</script>');
}
?>
<link rel="stylesheet" href="./public/css/order.css">
<div class="container py-5">
    <div class="container px-4 px-lg-5">
        <?php
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $order_id = $_GET['id'];

            // Prepare and execute a secure query
            $stmt = $conn->prepare("SELECT * FROM `orders` WHERE `owner_id` = ? AND `order_id` = ?;");
            $stmt->execute([$_SESSION['user_id'], $order_id]);

            // Fetch the order data
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            $date_placed = new DateTime($order['placed_date']);
            $formattedPlacedDate = $date_placed->format("F j, Y");
            $date_estimate = new DateTime($order['estimate_delivery_date']);
            $formattedEstimateDate = $date_estimate->format("F j, Y");

            echo "<div class='card order-card mb-3 p-4'><div class='card-body'>";
            echo "<div class='row align-items-center'>";
            echo "<div class='col'><div class='d-flex justify-content-between align-items-center mb-3'>";
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
            echo "</div>";

            if ($order) {
                $total_amount = 0;
                $products = json_decode($order['order_items'], true); // true makes it an associative array
        
                // Loop through each product
                foreach ($products as $product) {
                    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
                    $stmt->execute([$product['product_id']]);

                    // Fetch the product data
                    $product_details = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($product_details) {
                        $price_ = (int) $product['amount'] * (int) $product_details['price'];
                        $total_amount += $price_;
                        echo "<div class='card rounded-3 mb-4'>";
                        echo "<div class='card-body px-4 py-2'>";
                        echo "<div class='row d-flex justify-content-between align-items-center'>";
                        echo "<div class='col-md-2 col-lg-2 col-xl-2'>";
                        echo "<img src='{$product_details['image']}' class='img-fluid rounded-3' alt='Cotton T-shirt'>";
                        echo "</div><div class='col-md-3 col-lg-3 col-xl-3'>";
                        echo "<p class='lead mb-2'>{$product_details['name']}</p>";
                        echo "<p><span class='text-muted'>Qty: </span>{$product['amount']} <span class='text-muted'>Item Price: </span>Rs " . (int) $product_details['price'];
                        echo "</p></div><div class='col-md-3 col-lg-3 col-xl-2 d-flex'>";
                        echo "<button data-mdb-button-init data-mdb-ripple-init class='btn btn-link px-2' onclick='this.parentNode.querySelector(\"input[type=number]\").stepDown()'>";
                        echo "<i class='fas fa-minus'></i></button>";
                        echo "<button data-mdb-button-init data-mdb-ripple-init class='btn btn-link px-2' onclick='this.parentNode.querySelector(\"input[type=number]\").stepUp()'>";
                        echo "<i class='fas fa-plus'></i></button>";
                        echo "</div><div class='col-md-3 col-lg-2 col-xl-2 offset-lg-1'>";
                        echo "<h5 class='mb-0'>Rs {$price_}.00</h5></div>";
                        echo "</div></div></div>";
                    }
                }
                $delivery_charge = 300 * count($products);

                echo "<div class='col-md-4'><div class='card mb-4'><div class='card-header py-3'>";
                echo "<h5 class='mb-0'>Summary</h5>";
                echo "</div><div class='card-body'><ul class='list-group list-group-flush'>";
                echo "<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0'>Products<span>Rs " . customFormatPrice($total_amount) . "</span>";
                echo "</li><li class='list-group-item d-flex justify-content-between align-items-center px-0'>Shipping";
                echo "<span>Rs {$delivery_charge}.00</span></li><li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3'>";
                echo "<div><h5 class='mb-0'>Total Amount</h5></div><h5 class='mb-0'>Rs " . customFormatPrice((int) $delivery_charge + (int) $total_amount) . "</h5></li></ul>";
                echo "</div></div></div></div>";
            } else {
                die('<script>location.replace("index.php");</script>');
            }
        } else {
            die('<script>location.replace("index.php");</script>');
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
