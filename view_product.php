<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'models/header.php';
include 'models/db.php'; // Ensure this file correctly sets up a PDO connection
include 'models/utils.php';
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const newToast = ( content, amount, id ) => {
        Swal.fire( {
            title: 'Success',
            text: content + " X " + amount,
            icon: "success",
            confirmButtonText: 'OK'
        } ).then(() => {
            location.replace("view_product.php?id=" + id);
        })
    }
    function ErrorToast (id) {
        Swal.fire({ title: 'Oops!', text: `Requested amount of stock not available!`, icon: 'error', confirmButtonText: 'OK' }).then(() => {
            location.replace("view_product.php?id=" + id);
        })
    };
</script>
<section>
    <div class="container px-4 px-lg-5">
        <?php
        include 'models/cartfunc.php';
        include 'models/productfunc.php';

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $product_id = $_GET['id'];

            // Prepare and execute a secure query
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt->execute([$product_id]);

            // Fetch the product data
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['amount'])) {
                    if (!isset($_SESSION['user_id'])) {
                        die('<script>location.replace("login.php");</script>');
                    }
                    $available_amount = getAvailableStock($product_id, $conn);
                    if ($available_amount < (int)$_POST['amount']) {
                        echo "<script>ErrorToast({$product_id});</script>";
                    } else {
                        addToCart((int)$product_id,  (int)$_POST['amount']);
                        echo "<script>newToast(\"" . $product['name'] . "\", {$_POST['amount']}, {$product_id});</script>";
                    }
                }

                echo "<div class='row gx-4 gx-lg-5 align-items-center'>";
                echo "<div class='col-md-6'>";
                echo "<img class='card-img-top mb-5 mb-md-0' src='{$product['image']}' alt='...' />";
                echo "</div><div class='col-md-6'>";
                echo "<div class='small mb-1'>SKU: BST-498";
                echo "<div class='d-flex justify-content-start medium text-warning'>";
                /* Dynamic Rating Start based on product rating */
                for ($x = 0; $x < (int) $product['rating']; $x++) {
                    echo "<div class='bi-star-fill'></div>";
                }
                for ($x = 0; $x < (5 - (int) $product['rating']); $x++) {
                    echo "<div class='bi-star'></div>";
                }
                echo "</div></div>";
                echo "<h1 class='display-6 fw-bolder'>{$product['name']}</h1>";

                $stock = (int) $product['stock'];
                $can_buy = true;

                if ($stock == 0) {
                    echo "<span class='badge text-bg-danger' style='font-size: 13px'>Out of Stock</span>";
                    $can_buy = false;
                } elseif ($stock < 10) {
                    echo "<span class='badge text-bg-warning' style='font-size: 13px; bg-color: red;'>{$stock} Low Stock</span>";
                } else {
                    echo "<span class='badge text-bg-success' style='font-size: 13px'>{$stock} In Stock</span>";
                }

                echo "<div class='fs-5 mb-4 mt-1'>";
                echo "<span class='lead badge text-bg-primary' style='font-family: Roboto; font-size: 20px'>Rs " . customFormatPrice((int) $product['price']) . "</span>";
                echo "</div>";

                echo "<form class='d-flex' method='POST'>";
                echo "<input name='amount' class='form-control text-center me-3' id='inputQuantity' type='num' value='1' min='1' style='max-width: 3rem' />";
                echo "<button class='btn btn-outline-dark flex-shrink-0' type='submit' " . (!$can_buy ? "disabled" : "") . ">";
                echo "<i class='bi-cart-fill me-1'></i>Add to cart</button>";
                echo "</form>";
                echo "</div></div>";

                echo "<h2 class='mt-3'>Product Specifications</h2>";
                echo "<p class='lead'>" . nl2br(htmlspecialchars($product['description'])) . "</p>";
            } else {
                die('<script>location.replace("index.php");</script>');
            }
        } else {
            die('<script>location.replace("index.php");</script>');
        }
        ?>
    </div>
</section>
<!-- Related items section-->
<section class="py-2 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            include 'models/db.php';
            $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 4;";
            $products = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $product) {
                echo "<div class='col mb-5'>";
                echo "<div class='card h-100'>";
                echo "<img class='card-img-top' src='{$product['image']}' alt='...' />";
                echo "<div class='card-body px-4 pt-2'>";
                echo "<div class='text-center'>";
                echo "<h5 class='fw-bolder'>{$product['name']}</h5>";

                echo "</div></div>";

                echo "<div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>";

                echo "<div class='d-flex justify-content-center small text-warning mb-2'>";
                /* Dynamic Rating Start based on product rating */
                for ($x = 0; $x < (int) $product['rating']; $x++) {
                    echo "<div class='bi-star-fill'></div>";
                }
                for ($x = 0; $x < (5 - (int) $product['rating']); $x++) {
                    echo "<div class='bi-star'></div>";
                }
                echo "</div>";
                echo "<div class='text-center mb-2 lead' style='font-family: Roboto'>Rs {$product['price']}</div>";

                echo "<div class='text-center'><a class='btn btn-outline-primary mt-auto' href='./view_product.php?id={$product['product_id']}'>View</a>";
                echo "</div></div></div></div>";
            }
            ?>
        </div>
    </div>
</section>
<?php include 'models/footer.php'; ?>
