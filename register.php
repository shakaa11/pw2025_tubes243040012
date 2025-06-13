<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->execute([$username, $email, $hashed_password]);
            $success = 'Registration successful! You can now login.';
            header ("refresh:2;url=login.php");
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') { 
                $error = 'Username or email already exists.';
            } else {
                $error = 'Error registering user: ' . $e->getMessage();
            }
        }
    }
}
?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="futuristic-card p-4">
                <h2 class="text-center futuristic-section-title mb-4">Register</h2>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn futuristic-button">Register</button>
                    </div>
                </form>
                <p class="text-center mt-3 text-white-50">Already have an account? <a href="login.php" class="text-info">Login here</a></p>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>