<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="futuristic-card p-4">
                <h2 class="text-center futuristic-section-title mb-4">Login</h2>
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-" . $_SESSION['message_type'] . "'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                }
                if ($error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                ?>
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn futuristic-button">Login</button>
                    </div>
                </form>
                <p class="text-center mt-3 text-white-50">Don't have an account? <a href="register.php" class="text-info">Register here</a></p>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>