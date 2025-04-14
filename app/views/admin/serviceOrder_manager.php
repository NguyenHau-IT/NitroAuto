<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-receipt-cutoff me-2 text-primary fs-4"></i> Quản lý lịch hẹn
    </h2>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Dịch vụ</th>
                <th>Thời gian hẹn</th>
                <th>Trạng thái</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($servicesOrders as $order): ?>
                <tr>
                    <td><?= $order['ServiceOrderID'] ?></td>
                    <td><?= htmlspecialchars($order['UserFullName']) ?></td>
                    <td><?= htmlspecialchars($order['ServiceName']) ?></td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($order['OrderDate'])) ?></td>
                    <td>
                        <?php
                        switch ($order['Status']) {
                            case 'Cancelled':
                                echo 'Đã hủy';
                                break;
                            case 'Completed':
                                echo 'Hoàn thành';
                                break;
                            case 'Approved':
                                echo 'Đã duyệt';
                                break;
                            case 'Pending':
                                echo 'Đang chờ';
                                break;
                            default:
                                echo 'Không xác định';
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($order['Note']) ?: '-' ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/admin/service-order/edit/<?= $order['ServiceOrderID'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/admin/service-order/delete/<?= $order['ServiceOrderID'] ?>"
                                onclick="return confirm('Bạn có chắc muốn xóa lịch hẹn này?');"
                                class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                <i class="bi bi-trash3"></i> Xóa
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>