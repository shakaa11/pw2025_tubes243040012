<?php
session_start();
include '../includes/db.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../includes/header.php'; 
?>

<main class="container my-5">
    <h1 class="futuristic-section-title">Admin Dashboard</h1>
    <p class="text-white">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="futuristic-card p-4 text-center">
                <i class="fas fa-map-marked-alt fa-3x text-primary mb-3"></i>
                <h5 class="text-white">Manage Destinations</h5>
                <p class="text-white-50">Add, edit, or delete travel destinations.</p>
                <a href="manage_destinations.php" class="btn futuristic-button btn-sm">Go to Destinations</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="futuristic-card p-4 text-center">
                <i class="fas fa-users fa-3x text-info mb-3"></i>
                <h5 class="text-white">Manage Users</h5>
                <p class="text-white-50">View and manage user accounts.</p>
                <a href="#" class="btn futuristic-button btn-sm disabled">Coming Soon</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="futuristic-card p-4 text-center">
                <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                <h5 class="text-white">Reports & Analytics</h5>
                <p class="text-white-50">View site statistics and reports.</p>
                <a href="#" class="btn futuristic-button btn-sm disabled">Coming Soon</a>
            </div>
        </div>
    </div>

    </main>

<?php include '../includes/footer.php'; ?>