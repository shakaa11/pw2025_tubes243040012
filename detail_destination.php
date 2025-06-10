<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$image_base_path = 'assets/images/destinations/'; 
$destination = null;
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $pdo->prepare("SELECT * FROM destinations WHERE id = ?");
    $stmt->execute([$id]);
    $destination = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ambil ulasan untuk tujuan ini
    $stmtReviews = $pdo->prepare("SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.destination_id = ? ORDER BY r.created_at DESC");
    $stmtReviews->execute([$id]);
    $reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);
}

if (!$destination) {
    echo "<div class='container my-5'><div class='alert alert-danger'>Destination not found.</div></div>";
    include 'includes/footer.php';
    exit;
}

// Menangani pengiriman ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = 'Please login to submit a review.';
        $_SESSION['message_type'] = 'danger';
        header("Location: login.php");
        exit;
    }

    $userId = $_SESSION['user_id'];
    $rating = filter_var($_POST['rating'], FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_var($_POST['comment']);
    $destinationId = $destination['id'];

    if ($rating < 1 || $rating > 5) {
        $_SESSION['message'] = 'Rating must be between 1 and 5.';
        $_SESSION['message_type'] = 'danger';
    } else {
        try {
            $stmtInsertReview = $pdo->prepare("INSERT INTO reviews (destination_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
            $stmtInsertReview->execute([$destinationId, $userId, $rating, $comment]);
            $_SESSION['message'] = 'Review submitted successfully!';
            $_SESSION['message_type'] = 'success';
            header("Location: detail_destination.php?id=" . $destination['id']); 
            exit;
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Error submitting review: ' . $e->getMessage();
            $_SESSION['message_type'] = 'danger';
        }
    }
}
?>

<main class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="futuristic-section-title text-start mb-4"><?php echo htmlspecialchars($destination['name']); ?></h1>
           <img src="<?php echo htmlspecialchars($image_base_path . $destination['image']); ?>" class="img-fluid rounded futuristic-card mb-4" alt="<?php echo htmlspecialchars($destination['name']); ?>">
            <p class="lead text-white-50"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($destination['location']); ?></p>
            <p class="text-white-50"><strong>Price Estimate:</strong> <?php echo $destination['price_estimate'] ? 'Rp ' . number_format($destination['price_estimate'], 0, ',', '.') : 'N/A'; ?></p>
            <p class="text-white-50"><strong>Best Time to Visit:</strong> <?php echo htmlspecialchars($destination['best_time_to_visit'] ?: 'N/A'); ?></p>
            <p class="mt-4"><?php echo nl2br(htmlspecialchars($destination['description'])); ?></p>

            <h3 class="mt-5 text-primary">Reviews</h3>
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-" . $_SESSION['message_type'] . "'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="futuristic-card p-4 mb-4">
                    <h5>Submit Your Review</h5>
                    <form action="detail_destination.php?id=<?php echo $destination['id']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating (1-5)</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit_review" class="btn futuristic-button">Submit Review</button>
                    </form>
                </div>
            <?php else: ?>
                <p class="text-white-50">Please <a href="login.php" class="text-info">log in</a> to submit a review.</p>
            <?php endif; ?>

            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="futuristic-card p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-primary"><?php echo htmlspecialchars($review['username']); ?></h6>
                            <small class="text-white-50"><?php echo date('F j, Y', strtotime($review['created_at'])); ?></small>
                        </div>
                        <div class="rating-stars mb-2">
                            <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                <i class="fas fa-star text-warning"></i>
                            <?php endfor; ?>
                            <?php for ($i = $review['rating']; $i < 5; $i++): ?>
                                <i class="far fa-star text-warning"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="text-white-50"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-white-50">No reviews yet for this destination.</p>
            <?php endif; ?>

        </div>
        <div class="col-lg-4">
            <div class="futuristic-card p-4">
                <h5 class="text-primary">Quick Facts</h5>
                <ul class="list-unstyled text-white-50">
                    <li><i class="fas fa-info-circle me-2"></i> Population: Varies by location</li>
                    <li><i class="fas fa-temperature-low me-2"></i> Climate: Tropical</li>
                    <li><i class="fas fa-map-marked-alt me-2"></i> Best for: Adventure, Relaxation</li>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>