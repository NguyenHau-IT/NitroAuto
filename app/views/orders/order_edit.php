<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Chỉnh sửa đơn hàng #<?php echo htmlspecialchars($order['order_id']); ?></h3>
        </div>
        <div class="card-body">
            <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['user_name']); ?></p>
            <p><strong>Sản phẩm:</strong> <?php echo htmlspecialchars($order['car_name']); ?></p>
            <p><strong>Số lượng:</strong> <?php echo htmlspecialchars($order['quantity']); ?></p>
            <p><strong>Trạng thái hiện tại:</strong> 
                <span class="badge 
                    <?php 
                        switch (strtolower($order['status'])) {
                            case 'pending': echo 'bg-warning text-dark'; break;
                            case 'completed': echo 'bg-success'; break;
                            case 'canceled': echo 'bg-danger'; break;
                            case 'shipped': echo 'bg-info text-dark'; break;
                            case 'confirmed': echo 'bg-primary'; break;
                            default: echo 'bg-secondary';
                        }
                    ?>">
                    <?php echo htmlspecialchars($order['status']); ?>
                </span>
            </p>

            <form method="POST" action="/orderupdate/<?= htmlspecialchars($order['order_id']) ?>">
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">

                <div class="mb-3">
                    <label for="status" class="form-label">Cập nhật trạng thái:</label>
                    <select name="order_status" id="status" class="form-select">
                        <option value="pending" <?php if ($order['status'] == 'Pending') echo 'selected'; ?>>Đang chờ xử lý</option>
                        <option value="completed" <?php if ($order['status'] == 'Completed') echo 'selected'; ?>>Đã hoàn thành</option>
                        <option value="canceled" <?php if ($order['status'] == 'Canceled') echo 'selected'; ?>>Đã hủy</option>
                        <option value="shipped" <?php if ($order['status'] == 'Shipped') echo 'selected'; ?>>Đang giao</option>
                        <option value="confirmed" <?php if ($order['status'] == 'Confirmed') echo 'selected'; ?>>Đã xác nhận</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/orders" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
