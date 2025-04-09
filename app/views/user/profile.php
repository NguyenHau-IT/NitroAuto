<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">

    <div class="container mt-4">
        <div class="card shadow-lg rounded-4 p-4 bg-light text-dark w-75 mx-auto">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Thông tin cá nhân</h2>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id'] ?? '-'); ?></p>
                <p><strong>Tên:</strong> <?php echo htmlspecialchars($user['full_name'] ?? '-'); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? '-'); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user['phone'] ?? '-'); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['address'] ?? '-'); ?></p>
                <p><strong>Ngày tạo:</strong> <?php echo htmlspecialchars($user['created_at'] ?? '-'); ?></p>
            </div>
            <div class="d-flex justify-content-between mt-3 flex-wrap gap-2">
                <a href="/edit_profile" class="btn btn-outline-primary btn-lg d-flex align-items-center">
                    <i class="fas fa-user-edit me-2"></i> Chỉnh sửa thông tin
                </a>

                <a href="/reset_password" class="btn btn-warning btn-lg d-flex align-items-center">
                    <i class="fas fa-key me-2"></i> Đổi mật khẩu
                </a>

                <a href="/home" class="btn btn-primary btn-lg d-flex align-items-center">
                    <i class="fas fa-home me-2"></i> Quay lại
                </a>

                <a href="#" id="logoutBtn" class="btn btn-danger btn-lg d-flex align-items-center">
                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>