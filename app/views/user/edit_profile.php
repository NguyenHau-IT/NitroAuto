<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center">Chỉnh sửa thông tin khách hàng</h2>
            </div>
            <div class="card-body">
                <form action="/update_profile" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên:</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ:</label>
                        <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($user['address']) ?>" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

<script src="/script.js"></script>
<link rel="stylesheet" href="/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>