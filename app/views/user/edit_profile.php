<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5 text-dark fs-3 mb-4 bg-light shadow-lg rounded-4 p-4">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Chỉnh sửa thông tin khách hàng</h2>
            </div>
            <div class="card-body">
                <form action="/update_profile" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên:</label>
                        <input type="text" id="full_name" name="full_name" class="form-control fs-4" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control fs-4" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone" class="form-control fs-4" value="<?= htmlspecialchars($user['phone']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ:</label>
                        <input type="text" id="address" name="address" class="form-control fs-4" value="<?= htmlspecialchars($user['address']) ?>" required>
                    </div>

                    <div class="text-center d-flex justify-content-between">
                        <a href="/profile" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Cập nhật
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>