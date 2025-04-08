<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5 mb-5 bg-light rounded-4 shadow-lg p-4">
        <h2 class="mb-4 text-center fs-3 fw-bold">🛒 Giỏ hàng</h2>

        <form method="post" action="/checkout_selected">
            <?php if (!empty($carts)): ?>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="select-all">
                    <label class="form-check-label fs-5" for="select-all">
                        Chọn tất cả
                    </label>
                </div>

                <div class="row g-4">
                    <?php foreach ($carts as $item): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input select-item" type="checkbox" name="selected_items[]" value="<?= $item['id'] ?>">
                                        </div>
                                        <a href="/delete_cart/<?= $item['accessory_id'] ?>" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>

                                    <h5 class="card-title fw-bold"><?= htmlspecialchars($item['accessory_name']) ?></h5>
                                    <p class="card-text text-primary fs-5"><?= number_format($item['accessory_price'], 0, ',', '.') ?> VNĐ</p>

                                    <div class="mb-2">
                                        <label class="form-label">Số lượng:</label>
                                        <input type="number"
                                               name="quantities[<?= $item['id'] ?>]"
                                               value="<?= $item['quantity'] ?>"
                                               min="1"
                                               class="form-control text-center quantity-input"
                                               data-price="<?= $item['accessory_price'] ?>">
                                    </div>

                                    <p class="text-success fw-bold mb-0">
                                        Thành tiền:
                                        <span class="total-price" id="total-<?= $item['id'] ?>">
                                            <?= number_format($item['accessory_price'] * $item['quantity'], 0, ',', '.') ?> VNĐ
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                    <div>
                        <a href="/delete_all" class="btn btn-danger fs-5">
                            <i class="fas fa-trash me-1"></i> Xoá tất cả
                        </a>
                        <a href="/home" class="btn btn-secondary ms-2 fs-5">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                    <button type="submit" class="btn btn-success fs-5">
                        <i class="fas fa-cart-plus me-1"></i> Đặt mua sản phẩm đã chọn
                    </button>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center fs-5">
                    Không tìm thấy sản phẩm nào trong giỏ hàng.
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
