<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-road me-2 text-primary"></i> Manage Test Drives
    </h2>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-striped table-bordered align-middle bg-white mb-0">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Xe</th>
                <th>Ngày</th>
                <th>Giờ</th>
                <th>Địa điểm</th>
                <th>Trạng thái</th>
                <th>Thời gian đặt</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($test_drives as $test_drive): ?>
                <tr>
                    <td><?= htmlspecialchars($test_drive['id']) ?></td>
                    <td><?= htmlspecialchars($test_drive['user_name']) ?></td>
                    <td><?= htmlspecialchars($test_drive['car_name']) ?></td>
                    <td><?= htmlspecialchars($test_drive['preferred_date']) ?></td>
                    <td><?= date('H:i:s', strtotime($test_drive['preferred_time'])) ?></td>
                    <td class="text-start"><?= htmlspecialchars($test_drive['location']) ?></td>
                    <td>
                        <?php
                        $status = strtolower($test_drive['status']);
                        $statusClass = match ($status) {
                            'pending' => 'badge bg-warning text-dark',
                            'confirmed' => 'badge bg-primary',
                            'canceled' => 'badge bg-danger',
                            'completed' => 'badge bg-success',
                            default => 'badge bg-secondary'
                        };
                        $statusText = match ($status) {
                            'pending' => 'Đang chờ xử lý',
                            'confirmed' => 'Đã xác nhận',
                            'canceled' => 'Đã hủy',
                            'completed' => 'Đã hoàn thành',
                            default => 'Không xác định'
                        };
                        ?>
                        <span class="<?= $statusClass ?>"><?= $statusText ?></span>
                    </td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($test_drive['created_at'])) ?></td>
                    <td>
                        <a href="/test_drive_edit/<?= htmlspecialchars($test_drive['id']) ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="/test_drive_delete/<?= htmlspecialchars($test_drive['id']) ?>"
                           onclick="return confirm('Are you sure you want to delete this test drive?');"
                           class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
