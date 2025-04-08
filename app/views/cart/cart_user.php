<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5 mb-5 bg-light rounded-4 shadow-lg p-4">
        <h2 class="mb-4 text-center fs-3 fw-bold">🛒 Giỏ hàng</h2>

        <form method="post" action="">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center fs-5">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($carts)): ?>
                            <?php foreach ($carts as $item): ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo htmlspecialchars($item['accessory_name']); ?></td>
                                    <td class="text-primary"><?php echo number_format($item['accessory_price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                    <td style="max-width: 100px;">
                                        <input
                                            type="number"
                                            name="quantities[<?php echo $item['id']; ?>]"
                                            value="<?php echo $item['quantity']; ?>"
                                            min="1"
                                            class="form-control form-control-sm text-center fs-5 quantity-input"
                                            data-price="<?php echo $item['accessory_price']; ?>"
                                            data-id="<?php echo $item['id']; ?>">
                                    </td>
                                    <td class="total-price text-success fw-bold" id="total-<?php echo $item['id']; ?>">
                                        <?php echo number_format($item['accessory_price'] * $item['quantity'], 0, ',', '.') . ' VNĐ'; ?>
                                    </td>
                                    <td>
                                        <a href="/delete_cart/<?php echo $item['accessory_id']; ?>" class="btn btn-sm btn-danger btn-delete fs-6" data-id="<?php echo $item['id']; ?>">
                                            <i class="fas fa-trash me-1"></i> Xoá
                                        </a>
                                        <a href="/check_out" class="btn btn-sm btn-success fs-6 mt-1">
                                            <i class="fas fa-cart-plus me-1"></i> Đặt mua
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted fs-5">Không tìm thấy sản phẩm nào trong giỏ hàng.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if (!empty($carts)): ?>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="/delete_all" class="btn btn-danger btn-clear-cart fs-5">
                            <i class="fas fa-trash me-1"></i> Xoá tất cả
                        </a>
                        <a href="/check_out" class="btn btn-success fs-5">
                            <i class="fas fa-cart-plus me-1"></i> Đặt mua tất cả
                        </a>
                        <a href="/home" class="btn btn-danger   " style="align-content: center; margin-left: 10px;">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>