<footer class="bg-dark text-white py-4 mt-5 futuristic-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Futuristic Travel</h5>
                    <p>
                        Explore the world with us, where technology meets natural wonders. Your next adventure awaits beyond the horizon.
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <?php
                        // PENTING: Variabel $base_project_path harus sudah didefinisikan di header.php.
                        // Kode ini adalah fallback yang aman, tapi pastikan sudah benar di header.php Anda.
                        if (!isset($base_project_path)) {
                            // Jika Anda melihat pesan ini, kemungkinan besar $base_project_path belum didefinisikan.
                            // Sesuaikan ini dengan jalur dasar proyek Anda.
                            // Contoh: '/nama_folder_proyek/' atau '/' jika di root server web.
                            $base_project_path = '/your_project/'; // <--- PASTIKAN INI SESUAI DENGAN header.php!
                        }
                        ?>
                        <li><a href="<?php echo $base_project_path; ?>index.php" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="<?php echo $base_project_path; ?>destinations.php" class="text-white-50 text-decoration-none">Destinations</a></li>
                        <li><a href="<?php echo $base_project_path; ?>about.php" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li><a href="<?php echo $base_project_path; ?>contact.php" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Connect With Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fab fa-instagram"></i> Instagram</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-white-50">
                &copy; <?php echo date('Y'); ?> Futuristic Travel. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/your_font_awesome_kit_id.js" crossorigin="anonymous"></script>
    <script src="<?php echo $base_project_path; ?>js/main.js"></script> 
</body>
</html>