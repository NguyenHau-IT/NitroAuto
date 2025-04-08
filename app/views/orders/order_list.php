<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="bg-light rounded-4 shadow p-3 container my-4" style="max-width: 1000px;">
        <h2 class="text-center mb-4">Danh sách đơn hàng</h2>

        <div class="btn-group mb-3 sticky-top bg-light py-2" role="group" style="z-index: 1020;">
            <button class="btn btn-secondary" onclick="filterOrders('all')">Tất cả</button>
            <button class="btn btn-warning" onclick="filterOrders('pending')">Đang chờ xử lý</button>
            <button class="btn btn-info" onclick="filterOrders('confirmed')">Đã xác nhận</button>
            <button class="btn btn-primary" onclick="filterOrders('shipped')">Đang giao</button>
            <button class="btn btn-success" onclick="filterOrders('completed')">Đã hoàn thành</button>
            <button class="btn btn-danger" onclick="filterOrders('canceled')">Đã hủy</button>
        </div>

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
            <?php if (empty($groupedOrders)): ?>
                <div class="alert alert-info text-center" role="alert">
                    Không có đơn hàng nào trong danh sách.
                </div>
            <?php endif; ?>

            <?php foreach ($groupedOrders as $order): ?>
                <div class="card mb-3 order-card <?= strtolower($order['status']) ?>"
                    data-date="<?= date('Y-m-d', strtotime($order['order_date'])) ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="card-title mb-0">Đơn hàng #<?= $order['order_id'] ?></h5>

                                <?php if ($order['status'] == 'pending' || $order['status'] == 'Pending'): ?>
                                    <span class="badge bg-warning text-dark">Đang chờ xử lý</span>
                                <?php elseif ($order['status'] == 'confirmed' || $order['status'] == 'Confirmed'): ?>
                                    <span class="badge bg-info text-dark">Đã xác nhận</span>
                                <?php elseif ($order['status'] == 'shipping' || $order['status'] == 'Shipping'): ?>
                                    <span class="badge bg-primary">Đang giao</span>
                                <?php elseif ($order['status'] == 'completed' || $order['status'] == 'Completed'): ?>
                                    <span class="badge bg-success">Đã hoàn thành</span>
                                <?php elseif ($order['status'] == 'cancelled' || $order['status'] == 'Cancelled'): ?>
                                    <span class="badge bg-danger">Đã huỷ</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Không xác định</span>
                                <?php endif; ?>
                            </div>

                            <a href="/order_detail/<?= $order['order_id'] ?>" class="btn btn-success btn-sm">Xem chi tiết</a>
                        </div>


                        <?php if (count($order['items']) === 1): ?>
                            <?php $item = $order['items'][0]; ?>
                            <div class="row mb-1 border-bottom pb-1">
                                <?php if (!empty($item['car_name'])): ?>
                                    <div class="col-sm-6">
                                        <strong>Xe:</strong> <?= htmlspecialchars($item['car_name']) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Số lượng:</strong> <?= htmlspecialchars($item['quantity']) ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($item['accessory_name'])): ?>
                                    <div class="col-sm-6">
                                        <strong>Phụ kiện:</strong> <?= htmlspecialchars($item['accessory_name']) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Số lượng:</strong> <?= htmlspecialchars($item['accessory_quantity']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="row mb-1 border-bottom pb-1">
                                    <?php if (!empty($item['car_name'])): ?>
                                        <div class="col-sm-6">
                                            <strong>Xe:</strong> <?= htmlspecialchars($item['car_name']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Số lượng:</strong> <?= htmlspecialchars($item['quantity']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($item['accessory_name'])): ?>
                                        <div class="col-sm-6">
                                            <strong>Phụ kiện:</strong> <?= htmlspecialchars($item['accessory_name']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Số lượng:</strong> <?= htmlspecialchars($item['accessory_quantity']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <strong>Tổng giá:</strong> <?= number_format($order['total_price']) ?> VNĐ
                            </div>
                            <div class="col-sm-6">
                                <strong>Ngày đặt:</strong> <?= date('d/m/Y - H:i:s', strtotime($order['order_date'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>