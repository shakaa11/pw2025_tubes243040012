<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$search_term = isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; 

$image_base_path = 'assets/images/destinations/';

if (!empty($search_term)) {
    $stmt = $pdo->prepare("SELECT * FROM destinations WHERE name LIKE ? OR location LIKE ? ORDER BY name ASC");
    $stmt->execute(['%' . $search_term . '%', '%' . $search_term . '%']);
    $allDestinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT * FROM destinations ORDER BY name ASC");
    $allDestinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<main class="container my-5">
    <h1 class="futuristic-section-title">All Destinations</h1>

    <div class="mb-4">
        <form action="destinations.php" method="GET" class="d-flex">
            <input type="text" class="form-control me-2" placeholder="Search destinations..." name="search" value="<?php echo htmlspecialchars($search_term); ?>">
            <button class="btn futuristic-button" type="submit">Search</button>
        </form>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($allDestinations)): ?>
            <?php foreach ($allDestinations as $destination): ?>
                <div class="col">
                    <div class="card h-100 futuristic-card">
                        <img src="<?php echo htmlspecialchars($image_base_path . ($destination['image'] ?? 'default_placeholder.jpg')); ?>"
                             class="card-img-top"
                             alt="<?php echo htmlspecialchars($destination['name'] ?? 'Unnamed Destination'); ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo htmlspecialchars($destination['name'] ?? 'Unnamed Destination'); ?></h5>
                            <p class="card-text text-white-50"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($destination['location'] ?? 'Unknown Location'); ?></p>
                            <p class="card-text text-white"><?php echo htmlspecialchars(substr($destination['description'] ?? '', 0, 120)); ?>...</p>
                            <a href="detail_destination.php?id=<?php echo $destination['id']; ?>" class="btn futuristic-button btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <?php if (!empty($search_term)): ?>
                    <p class="text-white-50">No destinations found matching your search.</p>
                <?php else: ?>
                    <p class="text-white-50">No destinations found.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>