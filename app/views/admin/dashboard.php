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
            <section id="orders" class="d-none"><?php require_once __DIR__ . '/orders_manager.php'; ?></section>
            <section id="test_drives" class="d-none"><?php require_once __DIR__ . '/test_drives_manager.php'; ?></section>
            <section id="banners" class="d-none"><?php require_once __DIR__ . '/banners_manager.php'; ?></section>
            <section id="used_cars" class="d-none"><?php require_once __DIR__ . '/used_cars_manager.php'; ?></section>
            <section id="car_services" class="d-none"><?php require_once __DIR__ . '/cars_services_manager.php'; ?></section>
            <section id="promotions" class="d-none"><?php require_once __DIR__ . '/promotions_manager.php'; ?></section>
            <section id="service_orders" class="d-none"><?php require_once __DIR__ . '/serviceOrder_manager.php'; ?></section>
            <section id="reviews" class="d-none"><?php require_once __DIR__ . '/reviews_manager.php' ?></section>
            <section id="revenue" class="d-none">
                <h2 class="mb-4"><i class="bi bi-bar-chart-fill"></i> Thống kê tổng quan</h2>

                <!-- Bộ lọc thời gian -->
                <form method="get" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="yearFilter" class="form-label">Năm</label>
                            <select class="form-select" id="yearFilter" name="year">
                                <?php for ($y = date('Y'); $y >= 2025; $y--): ?>
                                    <option value="<?= $y ?>" <?= isset($_GET['year']) && $_GET['year'] == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-filter-circle me-1"></i>Lọc dữ liệu</button>
                        </div>
                    </div>
                </form>

                <!-- Tổng quan -->
                <div class="container mt-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card text-bg-primary shadow-sm h-100" style="min-height: 140px;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title"><i class="bi bi-people-fill me-2"></i>Người dùng</h5>
                                    <p class="fs-3 fw-bold mb-0"><?= $totalUsers ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-bg-info shadow-sm h-100" style="min-height: 140px;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title"><i class="bi bi-car-front-fill me-2"></i>Tổng xe</h5>
                                    <p class="fs-3 fw-bold mb-0"><?= $totalCars ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card text-bg-success shadow-sm h-100" style="min-height: 140px;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title"><i class="bi bi-bag-check-fill me-2"></i>Đơn hàng</h5>
                                    <p class="fs-3 fw-bold mb-0"><?= $totalOrders ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-bg-warning shadow-sm h-100" style="min-height: 140px;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title text-dark"><i class="bi bi-cash-coin me-2"></i>Doanh thu</h5>
                                    <p class="fs-5 fw-bold text-dark mb-0"><?= number_format($totalRevenue, 0) ?> đ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dòng thứ 2 -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card shadow-sm border-start border-4 border-danger h-100" style="min-height: 140px;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h6 class="card-title"><i class="bi bi-x-octagon-fill me-2 text-danger"></i>Tỷ lệ huỷ đơn</h6>
                                    <p class="fs-3 fw-bold text-danger mb-0"><?= $cancelRate ?>%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm border-start border-4 border-primary h-100" style="min-height: 140px;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h6 class="card-title"><i class="bi bi-star-fill me-2 text-primary"></i>Đánh giá trung bình</h6>
                                    <p class="fs-3 fw-bold text-primary mb-0"><?= round($avgRating, 1) ?> ★</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ -->
                <div class="row g-4 mt-3">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-graph-up me-2"></i>Doanh thu theo tháng</h5>
                                <canvas id="revenueChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-speedometer2 me-2"></i>Top xe bán chạy</h5>
                                <canvas id="topSellingChart" height="250"></canvas>
                                <ul class="mt-3">
                                    <?php foreach ($topSellingCars as $car): ?>
                                        <li><i class="bi bi-dot"></i> <?= $car['name'] ?> (<?= $car['sold'] ?> đơn)</li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-tools me-2"></i>Top phụ kiện bán chạy</h5>
                                <canvas id="topAccessoriesChart" height="250"></canvas>
                                <ul class="mt-3">
                                    <?php foreach ($topSellingAccessories as $item): ?>
                                        <li><i class="bi bi-dot"></i> <?= $item['name'] ?> (<?= $item['sold'] ?> đơn)</li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-pie-chart-fill me-2"></i>Tỷ lệ trạng thái đơn hàng</h5>
                                <canvas id="orderStatusChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($revenueByMonth, 'month_name')) ?>,
                datasets: [{
                    label: 'Doanh thu theo tháng',
                    data: <?= json_encode(array_column($revenueByMonth, 'revenue')) ?>,
                    tension: 0.3,
                    fill: true,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Doanh thu theo từng tháng',
                        font: {
                            size: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                return 'Doanh thu: ' + value.toLocaleString('vi-VN') + '₫';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return (value / 1_000_000) + ' triệu';
                            }
                        }
                    }
                }
            }
        });

        const topSellingCtx = document.getElementById('topSellingChart').getContext('2d');
        const topSellingChart = new Chart(topSellingCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($topSellingCars, 'name')) ?>,
                datasets: [{
                    label: 'Số đơn đặt',
                    data: <?= json_encode(array_column($topSellingCars, 'sold')) ?>,
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Top 5 xe bán chạy nhất',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });

        const accessoriesCtx = document.getElementById('topAccessoriesChart').getContext('2d');
        new Chart(accessoriesCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($topSellingAccessories, 'name')) ?>,
                datasets: [{
                    label: 'Số đơn',
                    data: <?= json_encode(array_column($topSellingAccessories, 'sold')) ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 5 phụ kiện bán chạy',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });

        const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Đã xác nhận', 'Chờ xử lý', 'Đã hủy'],
                datasets: [{
                    data: [
                        <?= $orderStatusStats['confirmed'] ?>,
                        <?= $orderStatusStats['pending'] ?>,
                        <?= $orderStatusStats['cancelled'] ?>
                    ],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Phân bổ trạng thái đơn hàng',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });

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
</body>

</html>