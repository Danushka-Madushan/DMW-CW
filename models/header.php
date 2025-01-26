<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple E-Commerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand text-primary" href="index.php">
                <h3>
                    <i class="bi bi-laptop">Trustcare </i> <small class="text-body-secondary">Computers</small>
                </h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php"
                            style="font-family: Roboto">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="font-family: Roboto">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="products.php">All Products</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="products.php?cat=Processors">Processors</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Motherboards">Motherboards</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Coolers">Coolers</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Memory">Memory</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=SSD">SSD</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Storage">Storage</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Graphics Cards">Graphics Cards</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Power Supply">Power Supply</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Mobiles">Mobiles</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=UPS">UPS</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Laptops">Laptops</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Chairs">Chairs</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Tables">Tables</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Keyboards">Keyboards</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Mouse">Mouse</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Speakers">Speakers</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Consoles">Consoles</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Apple Products">Apple Products</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Streaming Equipment">Streaming
                                    Equipment</a></li>
                            <li><a class="dropdown-item" href="products.php?cat=Adapters">Adapters</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="about.php"
                            style="font-family: Roboto">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="login.php"><span
                                class="badge text-bg-primary p-2" style="font-family: Roboto">Account</span></a></li>
                </ul>
                <div class="d-flex">
                    <a class="nav-link active" href="cart.php">
                        <button class="btn btn-outline-success">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </nav>
