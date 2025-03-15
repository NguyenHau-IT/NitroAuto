<?php include '/ProjectCarSale/includes/header.php'; ?>
<style>
    body {
        background-image: url('/uploads/bg.webp');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: #fff;
        font-size: 18px;
    }

    .overlay {
        border-radius: 50px;
        background: rgba(0, 0, 0, 0.7);
        padding: 50px 20px;
        margin-top: 50px;
    }
</style>
<div class="container mt-4">
    <div class="overlay">
        <div class="card-header text-white">
            <h2 class="mb-0">Thông tin cá nhân</h2>
        </div>
        <div class="card-body text-white">
            <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id'] ?? '-'); ?></p>
            <p><strong>Tên:</strong> <?php echo htmlspecialchars($user['full_name'] ?? '-'); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? '-'); ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user['phone'] ?? '-'); ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['address'] ?? '-'); ?></p>
            <p><strong>Ngày tạo:</strong> <?php echo htmlspecialchars($user['created_at'] ?? '-'); ?></p>
        </div>
        <div class="d-flex justify-content-start mt-3">
            <div class="card-footer">
            <a href="home" class="btn btn-primary">Quay lại</a>
            </div>
            <div class="card-footer">
            <a href="logout" class="btn btn-danger">Đăng xuất</a>
            </div>
        </div>
    </div>
</div>

<?php include '/ProjectCarSale/includes/footer.php'; ?>