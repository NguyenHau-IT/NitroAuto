<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<link rel="stylesheet" href="/style.css">
<div class="overlay ">
    <div class="bg-light rounded-4 shadow p-3 container my-4" style="max-width: 1000px;">
        <h2 class="text-center">Danh sách đơn hàng</h2>
        <div class="btn-group mb-3 sticky-top bg-light py-2" role="group" style="z-index: 1020;">
            <button class="btn btn-secondary" onclick="filterOrders('all')">Tất cả</button>
            <button class="btn btn-warning" onclick="filterOrders('pending')">Đang chờ xử lý</button>
            <button class="btn btn-info" onclick="filterOrders('confirmed')">Đã xác nhận</button>
            <button class="btn btn-primary" onclick="filterOrders('shipped')">Đang giao</button>
            <button class="btn btn-success" onclick="filterOrders('completed')">Đã hoàn thành</button>
            <button class="btn btn-danger" onclick="filterOrders('canceled')">Đã hủy</button>
        </div>
        <div id="order-list" style="max-height: 500px; overflow-y: auto;">
            <?php foreach ($orders as $order): ?>
                <div class="card mb-3 order-card <?= strtolower($order['status']) ?>">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Đơn hàng #<?= $order['order_id'] ?></h5>
                            <p class="mb-1"><strong>Xe:</strong> <?= htmlspecialchars($order['car_name']) ?></p>
                            <p class="mb-1"><strong>Số lượng:</strong> <?= htmlspecialchars($order['quantity']) ?></p>
                            <p class="mb-1"><strong>Tổng giá:</strong> <?= number_format($order['total_price']) ?> VNĐ</p>
                            <p class="mb-1"><strong>Ngày đặt:</strong> <?= date('d/m/Y - H:i:s', strtotime($order['order_date'])) ?></p>
                        </div>
                        <a href="/order_detail/<?= $order['order_id'] ?>" class="btn btn-success">Xem chi tiết</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

<!-- External styles and scripts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/script.js"></script>