<?php
include 'models/header.php';
include 'models/db.php';
?>

<body>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-5 fw-bolder">Dominate with the BEST</h1>
                <p class="lead fw-normal text-white-50 mb-0">Custom PCs with World-class Hadware</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="pb-5 pt-3">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            $sql = "SELECT * FROM products WHERE category IN ('Processors', 'Motherboards', 'Coolers', 'SSD', 'Graphics Cards', 'Monitors', 'Laptops', 'Apple Products') ORDER BY RAND() LIMIT 8;";
            $products = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $product) {
                echo "<div class='col mb-5'>";
                echo "<div class='card h-100'>";
                echo "<div class='badge bg-success rounded-pill text-white position-absolute' style='top: 0.5rem; right: 0.5rem'>New Arrival</div>";
                echo "<img class='card-img-top' src='{$product['image']}' alt='...' />";
                echo "<div class='card-body px-4 pt-2'>";
                echo "<div class='text-center'>";
                echo "<h5 class='fw-bolder'>{$product['name']}</h5>";

                echo "</div></div>";

                echo "<div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>";
                
                echo "<div class='d-flex justify-content-center small text-warning mb-2'>";
                /* Dynamic Rating Start based on product rating */
                for ($x = 0; $x < (int)$product['rating']; $x++) {
                    echo "<div class='bi-star-fill'></div>";
                }
                for ($x = 0; $x < (5 - (int)$product['rating']); $x++) {
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
</body>
<?php include 'models/footer.php'; ?>
