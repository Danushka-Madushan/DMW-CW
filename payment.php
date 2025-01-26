<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) === 0 || !isset($_POST['delcharge'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        die('<script>location.replace("index.php");</script>');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/payment.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const newToast = () => {
        Swal.fire( {
            title: 'Success',
            text: "Payment Successful",
            icon: "success",
            confirmButtonText: 'OK'
        } ).then( () => {
            location.replace( "index.php" );
        } )
    }
</script>

<body>
    <main class="page payment-page">
        <section class="payment-form dark">
            <div class="container">
                <div class="d-flex justify-content-center mt-5 mb-3">
                    <h2 class="display-6">Payment</h2>
                </div>
                <form>
                    <div class="products">
                        <h3 class="title">Checkout</h3>
                        <?php
                        include 'models/db.php';
                        include 'models/utils.php';
                        include 'models/productfunc.php';
                        include 'models/orderfunc.php';

                        $delivery_charge = 300 * count($_SESSION['cart']);
                        $total_amount = 0;
                        $order_items = [];
                        
                        foreach ($_SESSION['cart'] as &$item) {
                            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
                            $stmt->execute([$item['product_id']]);

                            // Fetch the product data
                            $product = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($product) {
                                $price_ = (int) $item['amount'] * (int) $product['price'];
                                $total_amount += $price_;

                                echo "<div class='item'><span class='price'>Rs {$product['price']}</span> <p class='item-name'>{$product['name']}</p></div>";
                            }
                        }

                        echo "<div class='total'>Total (Rs 300 x " . count($_SESSION['cart']) . ")<span class='price'>Rs " . customFormatPrice((int) $delivery_charge + (int) $total_amount) . "</span></div>";
                        
                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
                            if (!isset($_SESSION['user_id'])) {
                                die('<script>location.replace("login.php");</script>');
                            }
                            foreach ($_SESSION['cart'] as &$item) {
                                reduceStock((int) $item['product_id'], (int) $item['amount'], $conn);
                                $new_item = ["product_id" => (int) $item['product_id'], "amount" => (int) $item['amount']];
                                $order_items[] = $new_item;
                            }
                            placeOrder($_SESSION['user_id'], $order_items, (int) $delivery_charge + (int) $total_amount);
                            $_SESSION['cart']= [];
                            echo "<script>newToast();</script>";
                        }
                        
                        ?>
                    </div>
                    <div class="card-details">
                        <form method="POST" class="form-group col-sm-12">
                            <button type="submit" name="checkout" class="btn btn-primary btn-block">Proceed</button>
                        </form>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
