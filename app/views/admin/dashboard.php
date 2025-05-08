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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <header class="bg-dark text-white py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h5 mb-0 d-flex align-items-center">Admin Dashboard</h1>
            <div class="d-flex align-items-center gap-3">
                <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['full_name']) ?></strong></span>
                <a class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" href="/home">
                    <i class="bi bi-house-door"></i> Trang chủ
                </a>
                <a class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1" href="/logout">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </a>
            </div>
        </div>
    </header>


    <div class="d-flex">
        <nav class="bg-dark text-white p-3 vh-100 sticky-top flex-shrink-0" style="width: 220px;">
            <ul class="nav flex-column">
                <?php
                $tabs = [
                    'cars' => ['label' => 'Quản lý xe', 'icon' => 'bi-car-front'],
                    'used_cars' => ['label' => 'Bài đăng xe củ', 'icon' => 'bi-car-front-fill'],
                    'brands' => ['label' => 'Hãng xe', 'icon' => 'bi-buildings'],
                    'categories' => ['label' => 'Danh mục', 'icon' => 'bi-tags'],
                    'accessories' => ['label' => 'Phụ kiện', 'icon' => 'bi-tools'],
                    'users' => ['label' => 'Người dùng', 'icon' => 'bi-people'],
                    'orders' => ['label' => 'Đơn hàng', 'icon' => 'bi-bag-check'],
                    'test_drives' => ['label' => 'Lái thử', 'icon' => 'bi-speedometer2'],
                    'service_orders' => ['label' => 'Lịch hẹn dịch vụ', 'icon' => 'bi-calendar-check'],
                    'car_services' => ['label' => 'Dịch vụ xe', 'icon' => 'bi-tools'],
                    'promotions' => ['label' => 'Khuyến mãi', 'icon' => 'bi-stars'],
                    'banners' => ['label' => 'Banner', 'icon' => 'bi-image'],
                    'reviews' => ['label' => 'Đánh giá', 'icon' => 'bi-chat-square-text'],
                    'revenue' => ['label' => 'Thống kê', 'icon' => 'bi-bar-chart']
                ];
                //sắp xếp lại thứ tự các tab
                uasort($tabs, function ($a, $b) {
                    return $a['label'] <=> $b['label'];
                });

                foreach ($tabs as $id => $tab): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center gap-2" href="#<?= $id ?>">
                            <i class="bi <?= $tab['icon'] ?>"></i> <?= $tab['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <!-- Main content -->
        <main class="p-3 mt-4 flex-grow-1">
            <section id="dashboard">
                <h2>Chào mừng bạn đến với Admin Dashboard</h2>
                <p>Bạn có thể quản lý xe, người dùng, banner và nhiều hơn nữa.</p>
            </section>

            <section id="cars" class="d-none"><?php require_once __DIR__ . '/car_manager.php'; ?></section>
            <section id="brands" class="d-none"><?php require_once __DIR__ . '/brands_manager.php'; ?></section>
            <section id="categories" class="d-none"><?php require_once __DIR__ . '/categories_manager.php'; ?></section>
            <section id="accessories" class="d-none"><?php require_once __DIR__ . '/accessories_manager.php'; ?></section>
            <section id="users" class="d-none"><?php require_once __DIR__ . '/users_manager.php'; ?></section>
            <section id="orders" class="d-none"><?php require_once __DIR__ . '/orders_manager.php'; ?></section>
            <section id="test_drives" class="d-none"><?php require_once __DIR__ . '/test_drives_manager.php'; ?></section>
            <section id="banners" class="d-none"><?php require_once __DIR__ . '/banners_manager.php'; ?></section>
            <section id="used_cars" class="d-none"><?php require_once __DIR__ . '/used_cars_manager.php'; ?></section>
            <section id="car_services" class="d-none"><?php require_once __DIR__ . '/cars_services_manager.php'; ?></section>
            <section id="promotions" class="d-none"><?php require_once __DIR__ . '/promotions_manager.php'; ?></section>
            <section id="service_orders" class="d-none"><?php require_once __DIR__ . '/serviceOrder_manager.php'; ?></section>
            <section id="reviews" class="d-none"><?php require_once __DIR__ . '/reviews_manager.php'; ?></section>
            <section id="revenue" class="d-none"><?php require_once __DIR__ . '/revenue_manager.php'; ?></section>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script>
        const params = new URLSearchParams(window.location.search);
        const status = params.get("status");
        const message = params.get("message");

        if (status && message && typeof Swal !== 'undefined') {
            let icon = "info";
            let title = "Thông báo";

            if (status === "success") {
                icon = "success";
                title = "Thành công!";
            } else if (status === "error") {
                icon = "error";
                title = "Lỗi!";
            } else if (status === "warning") {
                icon = "warning";
                title = "Cảnh báo!";
            }

            Swal.fire({
                icon: icon,
                title: title,
                text: decodeURIComponent(message),
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            }).then(() => {
                history.replaceState(null, "", window.location.pathname);
            });
        }
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll("nav .nav-link");
            const sections = document.querySelectorAll("main section");

            function showSection(id) {
                sections.forEach(section => {
                    section.classList.add("d-none");
                    if (section.id === id) section.classList.remove("d-none");
                });

                navLinks.forEach(link => {
                    link.classList.remove("active");
                    if (link.getAttribute("href") === `#${id}`) {
                        link.classList.add("active");
                    }
                });
            }

            // Click tab: chuyển URL hash và hiện section
            navLinks.forEach(link => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute("href").substring(1);
                    history.pushState(null, "", `#${targetId}`);
                    showSection(targetId);
                });
            });

            // Load lại trang: hiện section theo hash nếu có
            const currentHash = window.location.hash.substring(1);
            if (currentHash && document.getElementById(currentHash)) {
                showSection(currentHash);
            } else {
                // Mặc định nếu không có hash
                showSection("dashboard");
            }

            // Bắt sự kiện back/forward của trình duyệt
            window.addEventListener("popstate", function() {
                const hash = window.location.hash.substring(1);
                if (hash && document.getElementById(hash)) {
                    showSection(hash);
                }
            });
        });
    </script>
</body>

</html>