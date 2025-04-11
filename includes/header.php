<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;
$current_page = basename($_SERVER['PHP_SELF']);
$count_cart = Cart::getCartCount($_SESSION['user']['id'] ?? null);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NITRO AUTO</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <header class="text-center">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light py-3">
            <div class="container">
                <a class="navbar-brand" href="/home">
                    <img src="/uploads/logo.webp" alt="logo" width="50" height="50" style="border-radius: 10px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <!-- Menu bên trái -->
                    <ul class="navbar-nav d-flex gap-2">
                        <li class="nav-item <?= ($current_page == 'home') ? 'active' : '' ?>">
                            <a class="nav-link" href="/home"><i class="fas fa-home"></i> NitroAuto</a>
                        </li>
                        <li class="nav-item dropdown <?= ($current_page == 'product_list' || $current_page == 'accessories' || $current_page == 'services') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-list"></i> Danh mục sản phẩm
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productDropdown">
                                <li><a class="dropdown-item" href="/accessories">Phụ Kiện cho xe</a></li>
                                <li><a class="dropdown-item" href="/services">Dịch vụ</a></li>
                            </ul>
                        </li>
                        <li class="nav-item <?= ($current_page == 'showOrderForm') ? 'active' : '' ?>">
                            <a class="nav-link" href="/showOrderForm"><i class="fas fa-car"></i> Mua hàng</a>
                        </li>
                        <li class="nav-item <?= ($current_page == 'favorites') ? 'active' : '' ?>">
                            <a class="nav-link" href="/favorites"><i class="fas fa-heart"></i> Yêu thích</a>
                        </li>
                        <li class="nav-item <?= ($current_page == 'appointments') ? 'active' : '' ?>">
                            <a class="nav-link" href="/appointments"><i class="fas fa-calendar-alt"></i> Lịch hẹn</a>
                        </li>
                        <li class="nav-item <?= ($current_page == 'user_orders') ? 'active' : '' ?>">
                            <a class="nav-link" href="/user_orders"><i class="fas fa-history"></i> Lịch sử</a>
                        </li>
                    </ul>

                    <!-- Menu bên phải -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center gap-2">
                        <?php if ($user && $user['role'] === 'admin'): ?>
                            <li class="nav-item <?= ($current_page == 'admin') ? 'active' : '' ?>">
                                <a class="nav-link" href="/admin"><i class="fas fa-user-shield"></i> Admin</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($user): ?>
                            <li class="nav-item <?= ($current_page == 'cart') ? 'active' : '' ?>">
                                <a class="nav-link d-flex align-items-center gap-1" href="/cart">
                                    <div class="position-relative">
                                        <i class="fas fa-shopping-cart fa-lg"></i>
                                        <?php if ($count_cart > 0): ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                                                <?= $count_cart ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <span>Giỏ hàng</span>
                                </a>
                            </li>
                            <li class="nav-item <?= ($current_page == 'profile' || $current_page == 'edit_profile') ? 'active' : '' ?>">
                                <a class="nav-link" href="/profile">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($user['full_name']) ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item <?= ($current_page == 'auth') ? 'active' : '' ?>">
                                <a class="nav-link" href="/auth">
                                    <i class="fas fa-user-circle"></i> Đăng nhập / Đăng ký
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>