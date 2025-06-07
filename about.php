<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';
?>

<main class="container my-5">
    <h1 class="futuristic-section-title">About Futuristic Travel</h1>

    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <img src="../tourism_website/assets/images/destinations/about_us.png" class="img-fluid rounded futuristic-card" alt="About Us">
        </div>
        <div class="col-md-6">
            <p class="lead mt-4 mt-md-0 text-white-50">
                At Futuristic Travel, we believe in pushing the boundaries of exploration.
                Established in 2025, our mission is to provide unparalleled travel experiences
                that blend cutting-edge technology with the raw beauty of the world's most
                extraordinary destinations.
            </p>
            <p class="text-white-50">
                We harness the power of AI for personalized recommendations, offer virtual reality previews,
                and ensure seamless, secure booking processes. Our team of passionate travel experts and
                tech innovators work tirelessly to curate unique itineraries that cater to every adventurer's dream.
            </p>
        </div>
    </div>

    <h2 class="futuristic-section-title mt-5">Our Vision</h2>
    <p class="text-center text-white-50 mb-5">
        To be the leading platform for future-forward tourism, inspiring a new generation
        of travelers to discover, experience, and preserve the wonders of our planet, and beyond.
    </p>

    <h2 class="futuristic-section-title mt-5">Our Team</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
        <div class="col">
            <div class="futuristic-card p-4">
                <img src="../tourism_website/assets/images/destinations/tim1.jpg" class="img-fluid rounded-circle mb-3" alt="Team Member 1" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="text-primary">Shaka</h5>
                <p class="text-white-50">CEO & Founder</p>
                <p class="small text-white-50">Visionary leader driving innovation in travel.</p>
            </div>
        </div>
        <div class="col">
            <div class="futuristic-card p-4">
                <img src="../tourism_website/assets/images/destinations/tim2.jpg" class="img-fluid rounded-circle mb-3" alt="Team Member 2" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="text-primary">Erik AM</h5>
                <p class="text-white-50">Head of Operations</p>
                <p class="small text-white-50">Ensuring smooth and unforgettable journeys.</p>
            </div>
        </div>
        <div class="col">
            <div class="futuristic-card p-4">
                <img src="../tourism_website/assets/images/destinations/tim.png" class="img-fluid rounded-circle mb-3" alt="Team Member 3" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="text-primary">Ardhi JM</h5>
                <p class="text-white-50">Chief Technology Officer</p>
                <p class="small text-white-50">Architect of our seamless digital experiences.</p>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>