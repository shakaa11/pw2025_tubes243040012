<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$image_base_path = 'assets/images/destinations/';

// Ambil destinasi terbaru atau populer
$stmt = $pdo->query("SELECT * FROM destinations ORDER BY created_at DESC LIMIT 3");
$latestDestinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<header class="futuristic-hero">
    <div class="futuristic-hero-content">
        <h1>Discover the Unseen</h1>
        <p>Your journey to extraordinary destinations begins here. Explore wonders beyond imagination.</p>
        <a href="destinations.php" class="btn futuristic-button btn-lg">Explore Destinations</a>
    </div>
</header>

<main class="container my-5">
    <section class="mb-5">
        <h2 class="futuristic-section-title">Featured Destinations</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($latestDestinations as $destination): ?>
            <div class="col">
                <div class="card h-100 futuristic-card">
                    <img src="<?php echo htmlspecialchars($image_base_path . $destination['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($destination['name']); ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?php echo htmlspecialchars($destination['name']); ?></h5>
                        <p class="card-text text-white-50"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($destination['location']); ?></p>
                        <p class="card-text text-white"><?php echo htmlspecialchars(substr($destination['description'], 0, 100)); ?>...</p>
                        <a href="detail_destination.php?id=<?php echo $destination['id']; ?>" class="btn futuristic-button btn-sm">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="text-center my-5">
        <h2 class="futuristic-section-title">Why Choose Futuristic Travel?</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <i class="fas fa-rocket fa-4x text-info mb-3"></i>
                <h3 class="text-white">Cutting-Edge Technology</h3>
                <p class="text-white-50">Seamless booking, virtual tours, and AI-powered recommendations.</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-globe-americas fa-4x text-primary mb-3"></i>
                <h3 class="text-white">Unique Destinations</h3>
                <p class="text-white-50">Explore hidden gems and popular spots with a futuristic twist.</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-shield-alt fa-4x text-info mb-3"></i>
                <h3 class="text-white">Secure & Reliable</h3>
                <p class="text-white-50">Your safety and satisfaction are our top priorities, backed by robust systems.</p>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>