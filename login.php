<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    die('<script>location.replace("orders.php");</script>');
}
include 'models/header.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function SuccessToast (name) {
        Swal.fire({ title: `Welcome ${name}!`, icon: 'success', confirmButtonText: 'Login' }).then(() => {
            location.replace('./index.php')
        })
    };
    function ErrorToast (text) {
        Swal.fire({ title: 'Oops!', text, icon: 'error', confirmButtonText: 'OK' })
    };
    function unExpected () {
        Swal.fire({ title: 'Oops!', text: `Something Unexpected Happed, Try again!`, icon: 'error', confirmButtonText: 'OK' })
    };
</script>
<?php
include 'models/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pword = $_POST['password'] ?? '';

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($pword)) {
        
        // Prepare SQL statement using PDO
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->execute([$email]); 
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            switch ($pword) {
                case $user['password']:
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['name'];
                    $_SESSION['email'] = $email;

                    echo "<script>SuccessToast(\"{$user['name']}\");</script>";
                    return;
                default:
                    echo "<script>ErrorToast(\"Invalid username or password\");</script>";
                    break;
            }
        } else {
            echo "<script>ErrorToast(\"Invalid username or password\");</script>";
        }
    } else {
        echo "<script>unExpected(\"Invalid Input\");</script>";
    }
}
?>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="text-center mb-4 mt-2">
                    <h3 class="text-primary">
                        <i class="bi bi-person-badge" style="font-size: 60px"></i>
                    </h3>
                </div>
                <div class="card shadow-lg mx-3">
                    <div class="card-body px-5 pt-5 pb-3">
                    <h1 class="display-6 mb-4">Login</h1>
                        <form method="POST" class="needs-validation" autocomplete="off">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="" required
                                    autofocus>
                            </div>

                            <div class="mb-3">
                                <div class="mb-2 w-100">
                                    <label class="text-muted" for="password">Password</label>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>

                            <div class="d-flex align-items-center">                              
                                <button type="submit" class="btn btn-primary ms-auto">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer pb-5 border-0">
                        <div class="text-center">
                            Don't have an account? <a href="register.php" class="text-dark">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</footer>
