<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="container mt-5 mb-5 bg-light rounded-4 shadow-lg p-4">
    <h2 class="mb-4 text-center fs-3 fw-bold">🚚 Thông tin giao hàng</h2>

    <form method="post" action="/check_out_process">
        <div class="mb-3">
            <label for="fullname" class="form-label fs-5">Họ và tên</label>
            <input type="text" class="form-control fs-5" id="fullname" name="fullname"
                value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label fs-5">Số điện thoại</label>
            <input type="text" class="form-control fs-5" id="phone" name="phone"
                value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required pattern="0\d{9,10}" placeholder="VD: 0901234567">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label fs-5">Địa chỉ giao hàng</label>
            <textarea class="form-control fs-5" id="address" name="address" rows="3" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
        </div>


        <!-- Danh sách sản phẩm trong giỏ -->
        <?php if (!empty($carts)): ?>
            <div class="mt-4">
                <h5 class="fw-bold mb-3">🛒 Sản phẩm trong đơn hàng:</h5>
                <ul class="list-group fs-5">
                    <?php
                    $totalAll = 0;
                    foreach ($carts as $item):
                        $accessoryName = htmlspecialchars($item['accessory_name']);
                        $price = $item['accessory_price'];
                        $quantity = $item['quantity'];
                        $total = $price * $quantity;
                        $totalAll += $total;
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold"><?php echo $accessoryName; ?></span>
                                <br>
                                <small class="text-muted">x<?php echo $quantity; ?></small>
                            </div>
                            <span class="text-primary fw-bold">
                                <?php echo number_format($total, 0, ',', '.') . ' VNĐ'; ?>
                            </span>
                        </li>

                        <!-- Truyền từng sản phẩm về server nếu cần -->
                        <input type="hidden" name="accessories[<?php echo $item['id']; ?>][id]" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="accessories[<?php echo $item['id']; ?>][quantity]" value="<?php echo $item['quantity']; ?>">
                        <input type="hidden" name="accessories[<?php echo $item['id']; ?>][price]" value="<?php echo $item['accessory_price']; ?>">

                    <?php endforeach; ?>

                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                        <span class="fw-bold">Tổng cộng:</span>
                        <span class="text-success fw-bold">
                            <?php echo number_format($totalAll, 0, ',', '.') . ' VNĐ'; ?>
                        </span>
                    </li>
                </ul>

                <!-- Gửi tổng tiền về server -->
                <input type="hidden" name="total_price" value="<?php echo $totalAll; ?>">
            </div>
        <?php else: ?>
            <p class="text-muted fs-5">Không có sản phẩm nào trong giỏ hàng.</p>
        <?php endif; ?>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success fs-5" <?php echo empty($carts) ? 'disabled' : ''; ?>>
                <i class="fas fa-cart-plus me-1"></i> Xác nhận đặt hàng
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>