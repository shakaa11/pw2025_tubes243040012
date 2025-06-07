<?php
session_start();
include 'includes/db.php'; 
include 'includes/header.php';

$contact_message = '';
$contact_message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Sanitasi input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitasi email
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Sanitasi input
    $message_body = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Sanitasi input

    // Validasi dasar (opsional, tapi sangat disarankan)
    if (empty($name) || empty($email) || empty($subject) || empty($message_body)) {
        $contact_message = 'Please fill in all required fields.';
        $contact_message_type = 'danger';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $contact_message = 'Invalid email format.';
        $contact_message_type = 'danger';
    } else {
        try {
            // Persiapkan statement SQL untuk INSERT data
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message_body) VALUES (?, ?, ?, ?)");
            
            // Eksekusi statement dengan data yang disanitasi
            $stmt->execute([$name, $email, $subject, $message_body]);

            $contact_message = 'Your message has been sent successfully! We will get back to you soon.';
            $contact_message_type = 'success';
        } catch (PDOException $e) {
            // Tangani error jika terjadi masalah saat menyimpan ke database
            $contact_message = 'There was an error sending your message. Please try again later. Error: ' . $e->getMessage();
            $contact_message_type = 'danger';
            // Anda bisa log error $e->getMessage() untuk debugging lebih lanjut
        }
    }
}
?>

<main class="container my-5">
    <h1 class="futuristic-section-title">Contact Us</h1>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="futuristic-card p-4">
                <p class="lead text-white-50 text-center mb-4">
                    Have questions or need assistance? Reach out to us through the form below,
                    or find our contact details.
                </p>

                <?php if ($contact_message): ?>
                    <div class="alert alert-<?php echo $contact_message_type; ?>"><?php echo $contact_message; ?></div>
                <?php endif; ?>

                <form action="contact.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="send_message" class="btn futuristic-button">Send Message</button>
                    </div>
                </form>

                <hr class="my-5 border-secondary">

                <div class="text-center">
                    <h5 class="text-primary">Our Office</h5>
                    <p class="text-white-50">
                        Futuristic Travel Headquarters <br>
                        123 Quantum Leap Avenue, Cyber City <br>
                        Futureland, 12345
                    </p>
                    <p class="text-white-50">
                        <i class="fas fa-phone-alt me-2"></i> +62 812 3456 7890 <br>
                        <i class="fas fa-envelope me-2"></i> info@futuristictravel.com
                    </p>
                    <div class="mt-4">
                        <a href="#" class="btn btn-outline-primary rounded-circle mx-2"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="btn btn-outline-primary rounded-circle mx-2"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="btn btn-outline-primary rounded-circle mx-2"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="btn btn-outline-primary rounded-circle mx-2"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>