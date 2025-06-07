<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Define the base path for images (relative to destinations.php)
$image_base_path = 'assets/images/destinations/';

$stmt = $pdo->query("SELECT * FROM destinations ORDER BY name ASC");
$allDestinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container my-5">
    <h1 class="futuristic-section-title">All Destinations</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($allDestinations)): ?>
            <?php foreach ($allDestinations as $destination): ?>
                <div class="col">
                    <div class="card h-100 futuristic-card">
                        <img src="<?php echo htmlspecialchars($image_base_path . $destination['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($destination['name']); ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo htmlspecialchars($destination['name']); ?></h5>
                            <p class="card-text text-white-50"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($destination['location']); ?></p>
                            <p class="card-text text-white"><?php echo htmlspecialchars(substr($destination['description'], 0, 120)); ?>...</p>
                            <a href="detail_destination.php?id=<?php echo $destination['id']; ?>" class="btn futuristic-button btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-white-50">No destinations found.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>