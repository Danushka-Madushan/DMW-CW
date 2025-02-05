<?php
include 'models/db.php';
include 'models/utils.php';
include 'models/cartfunc.php';
include 'models/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    die('<script>location.replace("login.php");</script>');
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<section class="h-100">
    <div class="container h-100 py-3">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-10">

                <div class="d-flex justify-content-end align-items-center mb-3">
                    <h3 class="display-6">
                        Order
                        <small class="display-6">Details</small>
                    </h3>
                </div>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
                    removeFromCart($_POST['delete_id']);
                }

                if (count($_SESSION['cart']) === 0) {
                    echo "<div class='container d-flex flex-column align-items-center justify-content-center'>";
                    echo "<div class='card d-flex  text-center p-4 border-0 shadow-sm align-items-center justify-content-center'>";
                    echo "<img src='https://cdn-icons-png.flaticon.com/512/743/743131.png' alt='Empty Box' class='img-fluid mb-3' style='width: 150px;'>";
                    echo "<h5 class='fw-bold'>No Orders Yet</h5>";
                    echo "<p class='text-muted'>Looks like you haven't placed any orders yet. Start shopping now!</p>";
                    echo "<a href='./products.php' class='btn btn-primary'>Shop Now</a></div></div>";
                } else {
                    $total_amount = 0;

                    foreach ($_SESSION['cart'] as &$item) {
                        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
                        $stmt->execute([$item['product_id']]);

                        // Fetch the product data
                        $product = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($product) {
                            $price_ = (int) $item['amount'] * (int) $product['price'];
                            $total_amount += $price_;
                            echo "<div class='card rounded-3 mb-4'>";
                            echo "<div class='card-body px-4 py-2'>";
                            echo "<div class='row d-flex justify-content-between align-items-center'>";
                            echo "<div class='col-md-2 col-lg-2 col-xl-2'>";
                            echo "<img src='{$product['image']}' class='img-fluid rounded-3' alt='Cotton T-shirt'>";
                            echo "</div><div class='col-md-3 col-lg-3 col-xl-3'>";
                            echo "<p class='lead fw-normal mb-2'>{$product['name']}</p>";
                            echo "<p><span class='text-muted'>Qty: </span>{$item['amount']} <span class='text-muted'>Item Price: </span>Rs " . (int) $product['price'];
                            echo "</p></div><div class='col-md-3 col-lg-3 col-xl-2 d-flex'>";
                            echo "<button data-mdb-button-init data-mdb-ripple-init class='btn btn-link px-2' onclick='this.parentNode.querySelector(\"input[type=number]\").stepDown()'>";
                            echo "<i class='fas fa-minus'></i></button>";
                            echo "<button data-mdb-button-init data-mdb-ripple-init class='btn btn-link px-2' onclick='this.parentNode.querySelector(\"input[type=number]\").stepUp()'>";
                            echo "<i class='fas fa-plus'></i></button>";
                            echo "</div><div class='col-md-3 col-lg-2 col-xl-2 offset-lg-1'>";
                            echo "<h5 class='mb-0'>Rs {$price_}.00</h5></div>";
                            echo "<form method='POST' ty class='col-md-1 col-lg-1 col-xl-1 text-end' style='margin-right: 30px;'>";
                            echo "<input type='hidden' name='delete_id' value='{$item['product_id']}'>";
                            echo "<button type='submit' class='btn text-danger' style='font-size: 20px;'><i class='bi bi-trash-fill'></i></button>";
                            echo "</form></div></div></div>";
                        }
                    }

                    $delivery_charge = 300 * count($_SESSION['cart']);

                    echo "<div class='col-md-4'><div class='card mb-4'><div class='card-header py-3'>";
                    echo "<h5 class='mb-0'>Summary</h5>";
                    echo "</div><div class='card-body'><ul class='list-group list-group-flush'>";
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0'>Products<span>Rs " . customFormatPrice($total_amount) . "</span>";
                    echo "</li><li class='list-group-item d-flex justify-content-between align-items-center px-0'>Shipping";
                    echo "<span>Rs {$delivery_charge}.00</span></li><li class='list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3'>";
                    echo "<div><h5 class='mb-0'>Total Amount</h5></div><h5 class='mb-0'>Rs " . customFormatPrice((int) $delivery_charge + (int) $total_amount) . "</h5></li></ul>";
                    echo "<form action='payment.php' method='POST'>";
                    echo "<input type='hidden' name='delcharge' value='{$delivery_charge}'>";
                    echo "<button type='submit' data-mdb-button-init data-mdb-ripple-init class='btn btn-primary btn-md btn-block'>Proceed Payment</button></form>";
                    echo "</div></div></div>";
                }
                ?>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
