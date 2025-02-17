<?php
include 'models/header.php';
include 'models/db.php';

$allowed_categories = [
    "Processors",
    "Thermal Paste",
    "Motherboards",
    "Coolers",
    "Memory",
    "SSD",
    "Storage",
    "Graphics Cards",
    "Power Supply",
    "Mobiles",
    "Adapters",
    "Printers",
    "UPS",
    "Laptops",
    "Chairs",
    "Tables",
    "Keyboards",
    "Mouse",
    "Speakers",
    "Cables",
    "Consoles",
    "Apple Products",
    "Streaming Equipment"
];

// Get the category from the query parameter
$category = $_GET['cat'] ?? null;
$search = $_GET['search'] ?? null;
$sql;

// Validate if it's in the allowed list
if ($category && in_array($category, $allowed_categories)) {
    $sql = "SELECT * FROM products WHERE category = '" . htmlspecialchars($category) . "'";
    if ($search) {
        $sql .= " AND `name` LIKE '%{$search}%';";
    }
} else {
    $category = "All Products";
    $sql = "SELECT * FROM products";
    if ($search) {
        $sql .= " WHERE `name` LIKE '%{$search}%'";
    }
    $sql .= " ORDER BY FIELD(category, 'Processors', 'Graphics Cards', 'Motherboards') DESC, product_id DESC";
}

echo "<body> <header class='bg-dark py-1'> <div class='container-fluid bg-container-small text-center text-white d-flex align-items-center justify-content-center'><div class='text-center text-white'>";
echo "<h1 class='display-5 glow-text-blue' style='text-transform: uppercase;'>{$category}</h1></div></div></header>";
echo "<div class='container px-4 px-lg-5 mt-3'>";
echo "<div class='row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center'>";

echo "<form class='input-group mb-3'>";
echo "<input type='hidden' name='cat' value='{$category}'></input>";
echo "<input name='search' type='text' class='form-control' placeholder='Search' value='{$search}' aria-label='Search' aria-describedby='button-addon2'>";
echo "<button class='btn btn-primary' type='submit' id='button-addon2'>Search</button></form>";

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
</body>
<?php include 'models/footer.php'; ?>
