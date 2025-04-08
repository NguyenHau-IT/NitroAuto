<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="bg-light rounded-4 shadow p-4 container my-4" style="max-width: 900px;">
        <h2 class="text-center mb-4">Danh sách lịch hẹn</h2>

        <!-- Bộ lọc trạng thái -->
        <div class="btn-group mb-3 sticky-top bg-light py-2" role="group" style="z-index: 1020;">
            <button class="btn btn-secondary" onclick="filterOrders('all')">Tất cả</button>
            <button class="btn btn-warning" onclick="filterOrders('pending')">Đang chờ xử lý</button>
            <button class="btn btn-info" onclick="filterOrders('confirmed')">Đã xác nhận</button>
            <button class="btn btn-primary" onclick="filterOrders('shipped')">Đang giao</button>
            <button class="btn btn-success" onclick="filterOrders('completed')">Đã hoàn thành</button>
            <button class="btn btn-danger" onclick="filterOrders('canceled')">Đã hủy</button>
        </div>

        <!-- Bộ lọc thời gian -->
        <div class="mb-3">
            <label for="date-range" class="form-label">Chọn khoảng thời gian:</label>
            <select id="date-range" class="form-control">
                <option value="none" selected>-- Lọc theo ngày --</option>
                <option value="today">Hôm nay</option>
                <option value="last_week">Tuần này</option>
                <option value="this_month">Tháng này</option>
                <option value="last_5_days">5 ngày qua</option>
                <option value="custom">Tùy chỉnh</option>
            </select>
        </div>

        <!-- Ngày bắt đầu và kết thúc nếu chọn "Tùy chỉnh" -->
        <div id="custom-date-range" style="display: none;">
            <div class="row mb-3">
                <div class="col">
                    <label for="start-date" class="form-label">Ngày bắt đầu:</label>
                    <input type="date" id="start-date" class="form-control">
                </div>
                <div class="col">
                    <label for="end-date" class="form-label">Ngày kết thúc:</label>
                    <input type="date" id="end-date" class="form-control">
                </div>
            </div>
        </div>


        <div id="order-list" style="max-height: 500px; overflow-y: auto;">
            <?php if (empty($orders)): ?>
                <div class="alert alert-info text-center" role="alert">
                    Không có đặt lịch nào trong danh sách.
                </div>
            <?php endif; ?>
            <?php foreach ($orders as $order): ?>
                <div class="card mb-3 order-card <?= strtolower($order['status']) ?>"
                    data-date="<?= date('Y-m-d', strtotime($order['order_date'])) ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title mb-0">Dịch vụ: <?= htmlspecialchars($order['car_name']) ?></h5>
                            
                        </div>

                        <p class="mb-1"><strong>Giá dịch vụ:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ</p>

                        <?php if (!empty($order['note'])): ?>
                            <p class="mb-1"><strong>Ghi chú:</strong> <?= htmlspecialchars($order['note']) ?></p>
                        <?php endif; ?>

                        <p class="mb-0"><strong>Ngày đặt:</strong> <?= date('d/m/Y - H:i', strtotime($order['order_date'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>