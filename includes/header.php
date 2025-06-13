<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futuristic Travel - Explore Beyond Limits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
    
    $base_project_path = '/tourism_website/'; 
    ?>
    <link rel="stylesheet" href="<?php echo $base_project_path; ?>css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <?php
    
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" style="background-color: #1a1a2e !important;">
        <div class="container">
            <a class="navbar-brand futuristic-logo" href="<?php echo $base_project_path; ?>index.php">
                <span class="text-primary">F</span>uturistic <span class="text-info">T</span>ravel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'index.php') ? 'active' : ''; ?>" aria-current="page" href="<?php echo $base_project_path; ?>index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'destinations.php') ? 'active' : ''; ?>" href="<?php echo $base_project_path; ?>destinations.php">Destinations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'about.php') ? 'active' : ''; ?>" href="<?php echo $base_project_path; ?>about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'contact.php') ? 'active' : ''; ?>" href="<?php echo $base_project_path; ?>contact.php">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <li>
                                        <a class="dropdown-item <?php echo ($currentPage === 'dashboard.php' || $currentPage === 'manage_destinations.php') ? 'active' : ''; ?>" href="<?php echo $base_project_path; ?>admin/dashboard.php">Admin Dashboard</a>
                                    </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo $base_project_path; ?>logout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary ms-2 <?php echo ($currentPage === 'login.php') ? 'active' : ''; ?>" href="<?php echo $base_project_path; ?>login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary ms-2 <?php echo ($currentPage === 'register.php') ? 'active' : ''; ?>" href="<?php echo $base_project_path; ?>register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>