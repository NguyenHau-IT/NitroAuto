<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="container mt-5 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4 border">
    <h2 class="mb-4 text-center">Đăng kí láy thử xe</h2>

    <div class="mb-3 fs-4">
        <h4 class="mb-3">Thông tin người mua</h4>

        <div class="row mb-2">
            <div class="col-md-6"><strong>Tên:</strong> <?= htmlspecialchars($user['full_name']) ?></div>
            <div class="col-md-6"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6"><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></div>
            <div class="col-md-6"><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address'] ?? '-') ?></div>
        </div>
    </div>

    <form action="/register_test_drive" method="POST">
        <input type="hidden" name="user_id" value="<?= isset($user['id']) ? htmlspecialchars($user['id']) : '' ?>">

        <div class="form-group">
            <label for="car_id">Chọn xe:</label>
            <select class="form-control" id="car_id" name="car_id" onchange="updatePrice()">
                <option value="">Chọn xe</option>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= htmlspecialchars($car['id']) ?>" data-price="<?= htmlspecialchars($car['price']) ?>" data-name="<?= htmlspecialchars($car['name']) ?>"
                        <?= isset($_POST['car_id']) && $_POST['car_id'] == $car['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($car['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="preferred_date">Ngày lái thử:</label>
            <input type="date" class="form-control" id="preferred_date" name="preferred_date" required>
        </div>

        <div class="form-group">
            <label for="preferred_time">Giờ lái thử:</label>
            <input type="time" class="form-control" id="preferred_time" name="preferred_time" required>
        </div>

        <div class="form-group">
            <label for="location">Địa điểm lái thử:</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-car"></i> Đăng kí
            </button>
            <a href="/home" class="btn btn-danger" style="margin-left: 10px;">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>