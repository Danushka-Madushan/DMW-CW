<?php include 'models/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function SuccessToast (mail) {
        Swal.fire({ title: 'Successfully Registered!', text: `${mail} is registered!`, icon: 'success', confirmButtonText: 'Login' }).then(() => {
            location.replace('./login.php')
        })
    };
    function ErrorToast (mail) {
        Swal.fire({ title: 'Email in Use!', text: `${mail} is already registered!`, icon: 'error', confirmButtonText: 'OK' })
    };
    function unExpected () {
        Swal.fire({ title: 'Oops!', text: `Something Unexpected Happed, Try again!`, icon: 'error', confirmButtonText: 'OK' })
    };
</script>
<?php
include 'models/db.php'; // Ensure this file initializes a PDO connection ($pdo)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        try {
            // Hash the password before storing it (more secure)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare SQL query with placeholders
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

            // Bind parameters and execute the statement
            $stmt->execute([
                ':name' => $name,
                ':email' => strtolower($email),
                ':password' => $hashedPassword
            ]);

            echo "<script>SuccessToast(\"" . htmlspecialchars($email) . "\");</script>";
        } catch (PDOException $e) {
            switch ($e->getCode()) {
                case 23000:
                    echo "<script>ErrorToast(\"" . htmlspecialchars($email) . "\");</script>";
                    break;
                default:
                    echo "<script>unExpected();</script>";
                    break;
            }
        }
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
                        <h1 class="display-6 mb-4">Register</h1>
                        <form method="POST" class="needs-validation" autocomplete="off">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="name">Name</label>
                                <input id="name" type="text" class="form-control" name="name" value="" required
                                    autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="" required>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>

                            <p class="form-text text-muted mb-3">
                                By registering you agree with our terms and condition.
                            </p>

                            <div class="align-items-center d-flex">
                                <button type="submit" class="btn btn-primary ms-auto">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer pb-5 border-0">
                        <div class="text-center">
                            Already have an account? <a href="login.php" class="text-dark">Login</a>
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
