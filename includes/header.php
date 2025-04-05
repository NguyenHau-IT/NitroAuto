<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;
$current_page = basename($_SERVER['PHP_SELF']); // Lấy tên file hiện tại
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Sale Project</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <header class="text-center">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light py-3">
            <div class="container">
                <a class="navbar-brand" href="home">
                    <img src="../uploads/logo.webp" alt="logo" width="50" height="50" style="border-radius: 10px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav d-flex justify-content-center">
                        <li class="nav-item <?= ($current_page == 'home') ? 'active' : '' ?>">
                            <a class="nav-link" href="/home"><i class="fas fa-home"></i> NitroAuto</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="contactDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope"></i> Contact
                            </a>
                            <div class="dropdown-menu" aria-labelledby="contactDropdown">
                                <a class="dropdown-item" href="email_support">Email Support</a>
                                <a class="dropdown-item" href="faq">FAQ</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown <?= ($current_page == 'product_list' || $current_page == 'accessories' || $current_page == 'services') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-list"></i>Danh mục sản phẩm
                            </a>
                            <div class="dropdown-menu" aria-labelledby="productDropdown">
                                <a class="dropdown-item" href="/accessories">Phụ Kiện cho xe</a>
                                <a class="dropdown-item" href="/services">Dịch vụ</a>
                            </div>
                        </li>
                        <li class="nav-item <?= ($current_page == 'showOrderForm') ? 'active' : '' ?>">
                            <a class="nav-link" href="/showOrderForm"><i class="fas fa-car"></i> Mua hàng</a>
                        </li>
                        <li class="nav-item <?= ($current_page == 'favorites') ? 'active' : '' ?>">
                            <a class="nav-link" href="/favorites"><i class="fas fa-heart"></i> Danh sách yêu thích</a>
                        </li>
                        <li class="nav-item <?= ($current_page == 'appointments') ? 'active' : '' ?>">
                            <a class="nav-link" href="/appointments"><i class="fas fa-calendar-alt"></i> Lịch hẹn</a>
                        </li>
                        <li class="nav-item <?= ($current_page == 'cart') ? 'active' : '' ?>">
                            <a class="nav-link" href="/cart"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto d-flex justify-content-end">
                        <?php if ($user && $user['role'] === 'admin'): ?>
                            <li class="nav-item <?= ($current_page == 'admin') ? 'active' : '' ?>">
                                <a class="nav-link" href="/admin"><i class="fas fa-user-shield"></i> Admin Dashboard</a>
                            </li>
                            <li class="nav-item <?= ($current_page == 'user_orders') ? 'active' : '' ?>">
                                <a class="nav-link" href="/user_orders"><i class="fas fa-history"></i> Lịch sử mua</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($user): ?>
                            <li class="nav-item <?= ($current_page == 'profile') ? 'active' : '' ?>">
                                <a class="nav-link" href="/profile">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($user['full_name']) ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item <?= ($current_page == 'login') ? 'active' : '' ?>">
                                <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                            </li>
                            <li class="nav-item <?= ($current_page == 'register') ? 'active' : '' ?>">
                                <a class="nav-link" href="/register"><i class="fas fa-user-plus"></i> Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>