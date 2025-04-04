<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-receipt me-2 text-primary"></i> Manage Orders
    </h2>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-striped table-bordered align-middle bg-white mb-0">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Xe</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Phụ kiện</th>
                <th>Số lượng</th>
                <th>Giá phụ kiện</th>
                <th>Tổng giá</th>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th>Thời gian</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['user_name']) ?></td>
                    <td><?= htmlspecialchars($order['car_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($order['quantity'] ?? '-') ?></td>
                    <td class="text-end"><?= isset($order['price']) ? number_format($order['price']) . ' VND' : '-' ?></td>
                    <td><?= htmlspecialchars($order['accessory_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($order['accessory_quantity'] ?? '-') ?></td>
                    <td class="text-end"><?= isset($order['accessory_price']) ? number_format($order['accessory_price']) . ' VND' : '-' ?></td>
                    <td class="text-end fw-bold text-success"><?= number_format($order['total_price']) ?> VND</td>
                    <td class="text-start"><?= htmlspecialchars($order['address']) ?></td>
                    <td>
                        <?php
                        $statusClass = '';
                        switch (strtolower($order['status'])) {
                            case 'pending':
                                $statusClass = 'badge bg-warning text-dark';
                                $statusText = 'Đang chờ xử lý';
                                break;
                            case 'confirmed':
                                $statusClass = 'badge bg-primary';
                                $statusText = 'Đã xác nhận';
                                break;
                            case 'shipped':
                                $statusClass = 'badge bg-info text-dark';
                                $statusText = 'Đang giao';
                                break;
                            case 'canceled':
                                $statusClass = 'badge bg-danger';
                                $statusText = 'Đã hủy';
                                break;
                            case 'completed':
                                $statusClass = 'badge bg-success';
                                $statusText = 'Đã hoàn thành';
                                break;
                            default:
                                $statusClass = 'badge bg-secondary';
                                $statusText = 'Không xác định';
                        }
                        ?>
                        <span class="<?= $statusClass ?>"><?= $statusText ?></span>
                    </td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($order['order_date'])) ?></td>
                    <td>
                        <a href="/order_edit/<?= htmlspecialchars($order['id']) ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="/order_delete/<?= htmlspecialchars($order['id']) ?>"
                           onclick="return confirm('Are you sure you want to delete this order?');"
                           class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
