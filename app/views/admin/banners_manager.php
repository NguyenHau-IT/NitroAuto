<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-images me-2 text-primary"></i> Manage Banners
    </h2>
    <a href="/add_banner" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus-circle me-1"></i> Thêm banner
    </a>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-striped table-bordered align-middle mb-0 bg-white">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
            <tr>
                <th style="min-width: 50px;">ID</th>
                <th style="min-width: 200px;">Url</th>
                <th style="min-width: 300px;">Hình ảnh</th>
                <th style="min-width: 120px;">Loại</th>
                <th style="min-width: 120px;">Trạng thái</th>
                <th style="min-width: 150px;">Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($banners as $banner): ?>
                <tr>
                    <td><?= $banner['id'] ?></td>
                    <td class="text-start"><?= htmlspecialchars($banner['image_url']) ?></td>
                    <td>
                        <?php if (!empty($banner['image_url'])): ?>
                            <img src="<?= htmlspecialchars($banner['image_url']) ?>"
                                alt="<?= htmlspecialchars($banner['name'] ?? 'Banner Image') ?>"
                                class="img-thumbnail"
                                style="max-height: 120px; max-width: 300px;">
                        <?php else: ?>
                            <span class="text-muted">No image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($banner['type']) ?></td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input toggle-active" type="checkbox"
                                data-id="<?= $banner['id'] ?>"
                                <?= $banner['is_active'] ? 'checked' : '' ?>>
                        </div>
                    </td>
                    <td>
                        <a href="/banner_edit/<?= htmlspecialchars($banner['id']) ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="/banner_delete/<?= htmlspecialchars($banner['id']) ?>"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa banner này?');"
                            class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>