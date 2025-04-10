<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="container mt-5 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4">
    <h2 class="mb-4 text-center">Đặt Mua Xe</h2>

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

    <form action="/place_order" method="POST" id="orderForm">
        <div class="form-group">
            <label for="address">Địa chỉ nhận xe:</label>
            <input type="text" class="form-control fs-4" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại người nhận:</label>
            <input type="text" class="form-control fs-4" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        </div>

        <div class="form-group">
            <label for="car_id">Chọn xe:</label>
            <select class="form-control fs-4" id="car_id" name="car_id" onchange="updatePrice()">
                <option value="">Chọn xe</option>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= htmlspecialchars($car['id']) ?>"
                        data-price="<?= htmlspecialchars($car['price']) ?>"
                        data-name="<?= htmlspecialchars($car['name']) ?>"
                        <?= isset($_POST['car_id']) && $_POST['car_id'] == $car['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($car['name']) ?> - <?= number_format($car['price']) ?> VNĐ
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Số lượng xe:</label>
            <input type="number" class="form-control fs-4" id="quantity" name="quantity" min="1" onchange="updatePrice()">
        </div>

        <div class="form-group">
            <label for="accessory_id">Chọn phụ kiện:</label>
            <select class="form-control fs-4" id="accessory_id" name="accessory_id" onchange="updatePrice()">
                <option value="">Chọn phụ kiện</option>
                <?php foreach ($accessories as $accessory): ?>
                    <option value="<?= htmlspecialchars($accessory['id']) ?>"
                        data-accessosy-price="<?= htmlspecialchars($accessory['price']) ?>"
                        data-accessosy-name="<?= htmlspecialchars($accessory['name']) ?>">
                        <?= htmlspecialchars($accessory['name']) ?> - <?= number_format($accessory['price']) ?> VNĐ
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="accessory_quantity">Số lượng phụ kiện:</label>
            <input type="number" class="form-control fs-4" id="accessory_quantity" name="accessory_quantity" min="0" onchange="updatePrice()">
        </div>

        <div class="form-group">
            <label for="promotions">Mã khuyến mãi:</label>
            <input type="text" class="form-control fs-4" id="promotions" name="promotions" onblur="updatePrice()">
            </div>

        <div class="form-group fs-4">
            <label for="total_price">Thành tiền:</label>
            <input type="hidden" id="total_price" name="total_price">
            <input type="hidden" id="car_name" name="car_name">
            <div id="total_price_display"></div>
        </div>


        <div class="form-group d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Đặt hàng
            </button>
            <a href="/home" class="btn btn-danger">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>