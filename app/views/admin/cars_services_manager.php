\    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary mb-0">🛠️ Quản lý Dịch vụ</h2>
        <a href="/add_service_form" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Thêm dịch vụ
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Tên dịch vụ</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td class="text-center"><?= $service['ServiceID'] ?></td>
                            <td><?= htmlspecialchars($service['ServiceName']) ?></td>
                            <td style="max-width: 250px;">
                                <span class="d-inline-block text-truncate" style="max-width: 240px;" title="<?= htmlspecialchars($service['Description']) ?>">
                                    <?= htmlspecialchars($service['Description']) ?>
                                </span>
                            </td>
                            <td class="text-end"><?= number_format($service['Price'], 0, ',', '.') ?>₫</td>
                            <td class="text-center"><?= $service['EstimatedTime'] ?> phút</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-<?= $service['Status'] == 1 ? 'success' : 'secondary' ?>">
                                    <?= $service['Status'] == 1 ? 'Hoạt động' : 'Không hoạt động' ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/edit_service/<?= $service['ServiceID'] ?>" class="btn btn-warning">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>
                                    <a href="/delete_service/<?= $service['ServiceID'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="bi bi-trash"></i> Xoá
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>