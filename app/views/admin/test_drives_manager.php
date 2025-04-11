<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-signpost-split-fill me-2 text-primary fs-4"></i> Quản lý Lái thử
    </h2>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
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
                        $statusMap = [
                            'pending' => ['Đang chờ xử lý', 'bg-warning text-dark'],
                            'confirmed' => ['Đã xác nhận', 'bg-primary'],
                            'canceled' => ['Đã hủy', 'bg-danger'],
                            'completed' => ['Đã hoàn thành', 'bg-success'],
                        ];
                        $statusText = $statusMap[$status][0] ?? 'Không xác định';
                        $statusClass = $statusMap[$status][1] ?? 'bg-secondary';
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                    </td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($test_drive['created_at'])) ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/test_drive_edit/<?= $test_drive['id'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/test_drive_delete/<?= $test_drive['id'] ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa lịch lái thử này?');"
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
