<div class="d-flex justify-content-between mb-3">
    <h2>Manage Orders</h2>
</div>
<div class="table-responsive mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-striped table-bordered align-middle bg-dark">
        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
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
        <tbody class="text-light">
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['car_name'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($order['quantity'] ?? '-'); ?></td>
                    <td>
                        <?php echo isset($order['price']) ? number_format($order['price']) . ' VND' : '-'; ?>
                    </td>
                    <td><?php echo htmlspecialchars($order['accessory_name'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($order['accessory_quantity'] ?? '-'); ?></td>
                    <td>
                        <?php echo isset($order['accessory_price']) ? number_format($order['accessory_price']) . ' VND' : '-'; ?>
                    </td>
                    <td><?php echo $order['total_price'] ?> VND</td>
                    <td><?php echo ($order['address']); ?></td>
                    <td class="text-center">
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
                        <span class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                    </td>
                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    <td class="text-center">
                        <a href="/order_edit/<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="/order_delete/<?php echo htmlspecialchars($order['id']); ?>"
                            onclick="return confirm('Are you sure you want to delete this order?');"
                            class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="/public/style.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>