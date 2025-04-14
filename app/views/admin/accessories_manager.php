<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 text-primary d-flex align-items-center">
        <i class="bi bi-gear-fill me-2"></i> Quản lý phụ kiện
    </h2>
    <a href="/add_accessory" class="btn btn-success d-flex align-items-center shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Thêm phụ kiện
    </a>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Tên phụ kiện</th>
                <th>Giá</th>
                <th>Mô tả</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody class="text-dark">
            <?php foreach ($accessoires as $accessory): ?>
                <tr>
                    <td class="text-center"><?= $accessory['id'] ?></td>
                    <td><?= htmlspecialchars($accessory['name']) ?></td>
                    <td><?= number_format($accessory['price'], 0, ',', '.') ?> VND</td>
                    <td>
                        <div class="bg-light rounded p-2 overflow-auto" style="max-height: 120px; white-space: pre-wrap;">
                            <?= nl2br(htmlspecialchars($accessory['description'])) ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="admin/accessory/edit/<?= $accessory['id'] ?>" class="btn btn-sm btn-outline-primary me-1 d-inline-flex align-items-center">
                            <i class="bi bi-pencil-square me-1"></i> Sửa
                        </a>
                        <a href="admin/accessory/delete/<?= $accessory['id'] ?>"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa phụ kiện này?');"
                            class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                            <i class="bi bi-trash me-1"></i> Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>