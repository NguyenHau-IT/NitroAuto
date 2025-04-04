<div class="d-flex justify-content-between mb-3">
    <h2>Manage Banners</h2>
    <a href="/add_banner" class="btn btn-primary mb-3">Thêm banner</a>
</div>
<div class="table-responsive mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-striped table-bordered align-middle bg-dark">
        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
            <tr>
                <th>ID</th>
                <th>Url</th>
                <th>Hình ảnh</th>
                <th>Loại</th>
                <th>Trạng thái</th> <!-- ✅ Thêm cột mới -->
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-light">
            <?php foreach ($banners as $banner): ?>
                <tr>
                    <td><?php echo $banner['id']; ?></td>
                    <td><?php echo $banner['image_url']; ?></td>
                    <td>
                        <?php if (!empty($banner['image_url'])): ?>
                            <img src="<?= htmlspecialchars($banner['image_url']) ?>" alt="<?= htmlspecialchars($banner['name'] ?? 'Banner Image') ?>" class="img-fluid" width="300">
                        <?php else: ?>
                            <span>No image</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $banner['type']; ?></td>

                    <td class="text-center">
                        <span class="badge <?= $banner['is_active'] ? 'bg-success' : 'bg-secondary' ?>" id="badge-<?= $banner['id'] ?>">
                            <?= $banner['is_active'] ? 'Hiển thị' : 'Đã ẩn' ?>
                        </span>
                    </td>

                    <td class="text-center">
                        <a href="/banner_edit/<?php echo htmlspecialchars($banner['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="/banner_delete/<?= htmlspecialchars($banner['id']) ?? 0 ?>" onclick="return confirm('Are you sure you want to delete this test drive?');" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>