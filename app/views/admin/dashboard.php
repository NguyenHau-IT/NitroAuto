<?php
require '../config/database.php';
if (!isset($_SESSION['user'])) {
    header("Location: /home");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-dark text-white py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">Admin Dashboard</h1>
            <div class="d-flex align-items-center gap-3">
                <span class="me-3">Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['full_name']) ?></strong></span>
                <a class="btn btn-outline-light btn-sm" href="/home"><i class="fas fa-home"></i> Trang chủ</a>
                <a class="btn btn-outline-danger btn-sm" href="/logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
            </div>
        </div>
    </header>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="bg-dark text-white p-3" style="width: 250px; height: 100vh; position: sticky; top: 0;">
            <ul class="nav flex-column">
                <?php
                $tabs = [
                    'dashboard' => 'Dashboard',
                    'cars' => 'Manage Cars',
                    'brands' => 'Manage Brands',
                    'categories' => 'Manage Categories',
                    'accessories' => 'Manage Accessories',
                    'users' => 'Manage Users',
                    'favorites' => 'Manage Favorites',
                    'orders' => 'Manage Orders',
                    'test_drives' => 'Manage Test Drives',
                    'banners' => 'Manage Banners',
                ];

                // Sắp xếp theo bảng chữ cái dựa trên label
                asort($tabs);

                foreach ($tabs as $id => $label): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#<?= $id ?>">
                            <i class="fas fa-chevron-right me-2"></i> <?= $label ?>
                        </a>
                    </li>
                <?php endforeach; ?>

            </ul>
        </nav>

        <!-- Main content -->
        <main class="container mt-4 flex-grow-1">
            <section id="dashboard">
                <h2>Welcome to the Admin Dashboard</h2>
                <p>Here you can manage cars, users, banners and more.</p>
            </section>

            <section id="cars" style="display: none;"><?php require_once __DIR__ . '/car_manager.php'; ?></section>
            <section id="brands" style="display: none;"><?php require_once __DIR__ . '/brands_manager.php'; ?></section>
            <section id="categories" style="display: none;"><?php require_once __DIR__ . '/categories_manager.php'; ?></section>
            <section id="accessories" style="display: none;"><?php require_once __DIR__ . '/accessories_manager.php'; ?></section>
            <section id="users" style="display: none;"><?php require_once __DIR__ . '/users_manager.php'; ?></section>
            <section id="favorites" style="display: none;"><?php require_once __DIR__ . '/favorites_manager.php'; ?></section>
            <section id="orders" style="display: none;"><?php require_once __DIR__ . '/orders_manager.php'; ?></section>
            <section id="test_drives" style="display: none;"><?php require_once __DIR__ . '/test_drives_manager.php'; ?></section>
            <section id="banners" style="display: none;"><?php require_once __DIR__ . '/banners_manager.php'; ?></section>
        </main>
    </div>

    <style>
        nav .nav-link {
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            font-weight: 500;
        }

        nav .nav-link:hover,
        nav .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
        }

        main section {
            padding: 20px 0;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll("nav .nav-link");
            const sections = document.querySelectorAll("main section");

            navLinks.forEach(link => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute("href").substring(1);

                    sections.forEach(section => {
                        section.style.display = section.id === targetId ? "block" : "none";
                    });

                    navLinks.forEach(l => l.classList.remove("active"));
                    this.classList.add("active");
                });
            });

            if (sections.length > 0) {
                sections[0].style.display = "block";
                navLinks[0].classList.add("active");
            }
        });
    </script>

    <!-- Bootstrap JS (no jQuery needed in BS5) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>