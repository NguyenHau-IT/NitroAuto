<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="container mt-5 overlay text-dark fs-5 mb-4 bg-light shadow rounded-4 p-4">
    <h2 class="mb-4 text-center">Đặt Mua Xe</h2>

    <div class="mb-3 fs-3">
        <h4>Thông tin người mua</h4>
        <p><strong>Tên:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['address'] ?? '-'); ?></p>
    </div>

    <form action="/place_order" method="POST" id="orderForm">
        <div class="form-group">
            <label for="address">Địa chỉ nhận xe:</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại ng nhận:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        </div>

        <div class="form-group">
            <label for="car_id">Chọn xe:</label>
            <select class="form-control" id="car_id" name="car_id" onchange="updatePrice()">
                <option value="">Chọn xe</option>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= htmlspecialchars($car['id']) ?>" data-price="<?= htmlspecialchars($car['price']) ?>" data-name="<?= htmlspecialchars($car['name']) ?>"
                        <?= isset($_POST['car_id']) && $_POST['car_id'] == $car['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($car['name']) ?> - <?= number_format($car['price']) ?> VNĐ
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Số lượng:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="1" onchange="updatePrice()">
        </div>

        <div class="form-group">
            <label for="total_price">Tổng tiền:</label>
            <input type="text" class="form-control" id="total_price" name="total_price" hidden>
            <strong><span id="total_price_display" style="font-size: 20px;"></span></strong>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Đặt hàng
            </button>
            <a href="/home" class="btn btn-secondary" style="align-content: center; margin-left: 10px;">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
<script src="/script.js"></script>
<link rel="stylesheet" href="/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
