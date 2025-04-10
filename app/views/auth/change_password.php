<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<form action="/change_password" method="POST" class="w-50 mx-auto mt-5">
    <h3>Đổi mật khẩu</h3>
    <div class="mb-3">
        <label for="old_password" class="form-label">Mật khẩu cũ</label>
        <input type="password" name="old_password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="new_password" class="form-label">Mật khẩu mới</label>
        <input type="password" class="form-control" id="new_password" name="new_password"
            placeholder="Mật khẩu" required
            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
            title="Mật khẩu phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt">
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Nhập lại mật khẩu mới</label>
        <input type="password" name="confirm_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
</form>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>