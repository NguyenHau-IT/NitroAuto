<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container d-flex justify-content-center align-items-center py-5">
        <div class="bg-white text-dark shadow-lg rounded-4 p-4 w-100" style="max-width: 700px;">
            <div class="mb-4 border-bottom pb-2">
                <h2 class="mb-0"><i class="bi bi-person-circle me-2 text-primary"></i>Thông tin cá nhân</h2>
            </div>

            <div class="mb-4 fs-5">
                <p><strong>👤 Họ tên:</strong> <?= htmlspecialchars($user['full_name'] ?? '-') ?></p>
                <p><strong>📧 Email:</strong> <?= htmlspecialchars($user['email'] ?? '-') ?></p>
                <p><strong>📞 Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? '-') ?></p>
                <p><strong>🏠 Địa chỉ:</strong> <?= htmlspecialchars($user['address'] ?? '-') ?></p>
            </div>

            <div class="d-flex flex-wrap gap-3 justify-content-between">
                <a href="/edit_profile" class="btn btn-outline-primary flex-fill d-flex align-items-center justify-content-center">
                    <i class="bi bi-pencil-square me-2"></i> Cập nhật
                </a>

                <a href="/reset_password" class="btn btn-warning flex-fill d-flex align-items-center justify-content-center">
                    <i class="bi bi-shield-lock-fill me-2"></i> Đổi mật khẩu
                </a>

                <a href="/home" class="btn btn-secondary flex-fill d-flex align-items-center justify-content-center">
                    <i class="bi bi-house-door-fill me-2"></i> Trang chủ
                </a>

                <a href="#" id="logoutBtn" class="btn btn-danger flex-fill d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>