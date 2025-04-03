<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5 rounded-4 bg-light shadow-lg p-4">
            <div class="card-header bg-primary text-white">
                <h3 class="m-3 p-2">Chỉnh sửa đơn hàng #<?= htmlspecialchars($order['order_id']) ?></h3>
            </div>
            <div class="card-body">
                <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['user_name']) ?: '-' ?></p>
                <p><strong>Sản phẩm:</strong> <?= htmlspecialchars($order['car_name']) ?: '-' ?></p>
                <p><strong>Số lượng:</strong> <?= htmlspecialchars($order['quantity']) ?: '-' ?></p>
                <p><strong>Giá sản phẩm:</strong> <?= isset($order['car_price']) ? number_format($order['car_price'], 0, ',', '.') . ' VND' : '-' ?></p>
                <p><strong>Phụ kiện:</strong> <?= !empty($order['accessory_name']) ? htmlspecialchars($order['accessory_name']) : '-' ?></p>
                <p><strong>Số lượng:</strong><?= !empty($order['accessory_quantity']) ? htmlspecialchars($order['accessory_quantity']) : '-' ?></p>
                <p><strong>Tiền phụ kiện:</strong><?= !empty($order['accessory_price']) ? number_format($order['accessory_price'], 0, ',', '.') . ' VND' : '-' ?></p>
                <p><strong>Tổng tiền sản phẩm:</strong> <?= !empty($order['total_price']) ? number_format($order['total_price'], 0, ',', '.') . ' VND' : '-' ?></p>
                <p><strong>Trạng thái hiện tại:</strong>
                    <span class="badge 
                    <?php
                    switch (strtolower($order['status'])) {
                        case 'pending':
                            echo 'bg-warning text-dark';
                            break;
                        case 'completed':
                            echo 'bg-success';
                            break;
                        case 'canceled':
                            echo 'bg-danger';
                            break;
                        case 'shipped':
                            echo 'bg-info text-dark';
                            break;
                        case 'confirmed':
                            echo 'bg-primary';
                            break;
                        default:
                            echo 'bg-secondary';
                    }
                    ?>">
                        <?= htmlspecialchars($order['status']) ?>
                    </span>
                </p>

                <form method="POST" action="/orderupdate/<?= htmlspecialchars($order['order_id']) ?>">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">

                    <div class="mb-3">
                        <label for="status" class="form-label">Cập nhật trạng thái:</label>
                        <select name="order_status" id="status" class="form-select">
                            <?php $statuses = ['Pending' => 'Đang chờ xử lý', 'Confirmed' => 'Đã xác nhận', 'Shipped' => 'Đang giao', 'Completed' => 'Đã hoàn thành', 'Canceled' => 'Đã hủy']; ?>
                            <?php foreach ($statuses as $key => $label): ?>
                                <option value="<?= strtolower($key) ?>" <?= strtolower($order['status']) === strtolower($key) ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/admin" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

<script src="/script.js"></script>
<link rel="stylesheet" href="/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>