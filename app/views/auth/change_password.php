<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div id="bg" class="position-fixed top-0 start-0 w-100 h-100 z-n1"></div>

<div class="container d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg w-100" style="max-width: 500px;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">
                <i class="bi bi-shield-lock-fill me-2 text-primary"></i>Đổi mật khẩu
            </h4>

            <form action="" method="POST">
                <!-- Mật khẩu cũ -->
                <div class="mb-3">
                    <label for="old_password" class="form-label fw-semibold">
                        <i class="bi bi-lock-fill me-1 text-secondary"></i> Mật khẩu cũ
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                        <input type="password" name="old_password" id="old_password" class="form-control" required>
                    </div>
                </div>

                <!-- Mật khẩu mới -->
                <div class="mb-3">
                    <label for="new_password" class="form-label fw-semibold">
                        <i class="bi bi-lock-fill me-1 text-secondary"></i> Mật khẩu mới
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" class="form-control" id="new_password" name="new_password"
                            placeholder="Ít nhất 8 ký tự, chữ hoa/thường/số/ký tự đặc biệt" required
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
                            title="Mật khẩu phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt">
                    </div>
                </div>

                <!-- Nhập lại mật khẩu -->
                <div class="mb-4">
                    <label for="confirm_password" class="form-label fw-semibold">
                        <i class="bi bi-lock-fill me-1 text-secondary"></i> Nhập lại mật khẩu mới
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-check2-square"></i></span>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    </div>
                </div>

                <!-- Nút submit + Quay lại -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-arrow-repeat me-1"></i> Cập nhật mật khẩu
                    </button>
                    <a href="/profile" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Quay lại trang cá nhân
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Kiểm tra xác nhận mật khẩu -->
<script>
     VANTA.NET({
      el: "#bg",
      mouseControls: true,
      touchControls: true,
      minHeight: 200,
      minWidth: 200,
      scale: 1.0,
      scaleMobile: 1.0,
      color: 0x00aaff,
      backgroundColor: 0x0d0d0d
    });
    
    document.querySelector("form").addEventListener("submit", function (e) {
        const newPass = document.getElementById("new_password").value;
        const confirm = document.getElementById("confirm_password").value;
        if (newPass !== confirm) {
            alert("❌ Mật khẩu nhập lại không khớp.");
            e.preventDefault();
        }
    });
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
