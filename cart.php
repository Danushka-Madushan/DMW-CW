<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'models/header.php';
if (!isset($_SESSION['user_id'])) {
    die('<script>location.replace("login.php");</script>');
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

                <div class="card rounded-3 mb-4">
                    <div class="card-body px-4 py-2">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-md-2 col-lg-2 col-xl-2">
                                <img src="https://cdn.sanity.io/images/yqd1zell/production/9559d692d06ac1356e3eb54446c6ba858f156a90-512x512.png"
                                    class="img-fluid rounded-3" alt="Cotton T-shirt">
                            </div>
                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <p class="lead fw-normal mb-2">Asus Prime A520M-E DDR4 Motherboard</p>
                                <p><span class="text-muted">Qty: </span>1 <span class="text-muted">Item Price: </span>Rs 25000
                                </p>
                            </div>
                            <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2"
                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2"
                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                <h5 class="mb-0">Rs 25000.00</h5>
                            </div>
                            <div class="col-md-1 col-lg-1 col-xl-1 text-end" style="margin-right: 30px;">
                                <a href="#!" class="text-danger" style="font-size: 20px;"><i
                                        class="bi bi-trash-fill"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Products
                                    <span>$53.98</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Shipping
                                    <span>Rs 1500.00</span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <h5 class="mb-0">Total Amount</h5>
                                    </div>
                                    <h5 class="mb-0">$499.00</h5>
                                </li>
                            </ul>

                            <button type="button" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-lg btn-block">
                                Proceed Payment
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php include 'models/footer.php'; ?>
