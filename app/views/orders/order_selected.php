<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5 mb-5 bg-light p-4 rounded-4 shadow-lg">
        <h2 class="text-center mb-4 fs-3 fw-bold">🧾 Xác nhận đơn hàng</h2>

        <form action="/check_out_selected_process" method="post">
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped align-middle text-center fs-5">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($selectedItems as $item): ?>
                            <?php
                            $itemTotal = $item['accessory_price'] * $item['quantity'];
                            $total += $itemTotal;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($item['accessory_name']) ?></td>
                                <td class="text-primary"><?= number_format($item['accessory_price'], 0, ',', '.') ?> VNĐ</td>
                                <td>
                                    <input type="number"
                                        name="quantities[<?= $item['id'] ?>]"
                                        value="<?= $item['quantity'] ?>"
                                        min="1"
                                        class="form-control text-center fs-5"
                                        data-price="<?= $item['accessory_price'] ?>"
                                        disabled> <!-- Disabled input -->
                                    <input type="hidden" name="selected_ids[]" value="<?= $item['id'] ?>">
                                </td>
                                <td class="text-success fw-bold">
                                    <?= number_format($itemTotal, 0, ',', '.') ?> VNĐ
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end fs-5 mb-4">
                <strong>Tổng tiền:</strong>
                <span class="text-danger fw-bold fs-4" id="grand-total"><?= number_format($total, 0, ',', '.') ?> VNĐ</span>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label fw-semibold">Địa chỉ nhận hàng</label>
                    <input type="text" name="address" id="address" class="form-control fs-5" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="form-control fs-5" required>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/cart" class="btn btn-secondary fs-5"><i class="fas fa-arrow-left me-1"></i> Quay lại giỏ hàng</a>
                <button type="submit" class="btn btn-success fs-5">
                    <i class="fas fa-check-circle me-1"></i> Xác nhận đặt hàng
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>