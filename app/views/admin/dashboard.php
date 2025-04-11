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
        <nav class="bg-dark text-white p-3 vh-100 sticky-top">
            <ul class="nav flex-column">
                <?php
                $tabs = [
                    'cars' => ['label' => 'Quản lý xe', 'icon' => 'bi-car-front'],
                    'brands' => ['label' => 'Hãng xe', 'icon' => 'bi-buildings'],
                    'categories' => ['label' => 'Danh mục', 'icon' => 'bi-tags'],
                    'accessories' => ['label' => 'Phụ kiện', 'icon' => 'bi-tools'],
                    'users' => ['label' => 'Người dùng', 'icon' => 'bi-people'],
                    'favorites' => ['label' => 'Yêu thích', 'icon' => 'bi-heart'],
                    'orders' => ['label' => 'Đơn hàng', 'icon' => 'bi-bag-check'],
                    'test_drives' => ['label' => 'Lái thử', 'icon' => 'bi-speedometer2'],
                    'banners' => ['label' => 'Banner', 'icon' => 'bi-image'],
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
        <main class="container mt-4 flex-grow-1">
            <section id="dashboard">
                <h2>Chào mừng bạn đến với Admin Dashboard</h2>
                <p>Bạn có thể quản lý xe, người dùng, banner và nhiều hơn nữa.</p>
            </section>

            <section id="cars" class="d-none"><?php require_once __DIR__ . '/car_manager.php'; ?></section>
            <section id="brands" class="d-none"><?php require_once __DIR__ . '/brands_manager.php'; ?></section>
            <section id="categories" class="d-none"><?php require_once __DIR__ . '/categories_manager.php'; ?></section>
            <section id="accessories" class="d-none"><?php require_once __DIR__ . '/accessories_manager.php'; ?></section>
            <section id="users" class="d-none"><?php require_once __DIR__ . '/users_manager.php'; ?></section>
            <section id="favorites" class="d-none"><?php require_once __DIR__ . '/favorites_manager.php'; ?></section>
            <section id="orders" class="d-none"><?php require_once __DIR__ . '/orders_manager.php'; ?></section>
            <section id="test_drives" class="d-none"><?php require_once __DIR__ . '/test_drives_manager.php'; ?></section>
            <section id="banners" class="d-none"><?php require_once __DIR__ . '/banners_manager.php'; ?></section>
        </main>
    </div>

    <script src="/scripts.js"></script>
    <script>
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
            document.querySelectorAll('.toggle-active').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const bannerId = this.getAttribute('data-id');
                    const isActive = this.checked ? 1 : 0;

                    fetch('/updateBannerStatus', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `banner_id=${bannerId}&is_active=${isActive}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Cập nhật trạng thái thành công');
                            } else {
                                alert('Cập nhật thất bại');
                                this.checked = !this.checked;
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            this.checked = !this.checked;
                        });
                });
            });
        });
    </script>

    <!-- Bootstrap JS (no jQuery needed in BS5) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>