<div class="d-flex justify-content-between mb-3">
    <h2>Manage Cars</h2>
    <a href="/add_car" class="btn btn-primary">Add New Car</a>
</div>
<div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-striped table-bordered align-middle bg-dark">
        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Thương hiệu</th>
                <th>Danh mục</th>
                <th>Năm</th>
                <th>Màu sắc</th>
                <th>Giá</th>
                <th>Hộp số</th>
                <th>Số km</th>
                <th>Loại nhiên liệu</th>
                <th>Tồn kho</th>
                <th>Hình ảnh</th>
                <th>Hình ảnh 3D</th>
                <th style="width: 400px;">Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-light">
            <?php foreach ($cars as $car): ?>
                <tr>
                    <td class="text-center"><?= htmlspecialchars($car['id'] ?? 0) ?></td>
                    <td class="text-truncate" style="max-width: 300px;">
                        <?= htmlspecialchars($car['name'] ?? '') ?>
                    </td>
                    <td class="text-center"><?= htmlspecialchars($car['brand_name'] ?? 'N/A') ?></td>
                    <td class="text-center"><?= htmlspecialchars($car['category_name'] ?? 'N/A') ?></td>
                    <td class="text-center"><?= htmlspecialchars($car['year'] ?? 'N/A') ?></td>
                    <td class="text-center"><?= htmlspecialchars($car['color'] ?? 'N/A') ?></td>
                    <td class="text-end"><?= number_format($car['price'] ?? 0) ?> VND</td>
                    <td class="text-center"><?= htmlspecialchars($car['transmission'] ?? 'N/A') ?></td>
                    <td class="text-end"><?= number_format($car['mileage'] ?? 0) ?> km</td>
                    <td class="text-center"><?= htmlspecialchars($car['fuel_type'] ?? 'N/A') ?></td>
                    <td class="text-center"><?= htmlspecialchars($car['stock'] ?? 'N/A') ?></td>

                    <td class="text-center">
                        <?php if (!empty($car['image_url'])): ?>
                            <img src="<?= htmlspecialchars($car['image_url']) ?>" width="150" height="100">
                        <?php else: ?>
                            <span>No image</span>
                        <?php endif; ?>
                    </td>

                    <td class="text-center">
                        <?php if (!empty($car['image_3d_url'])): ?>
                            <iframe src="<?= htmlspecialchars($car['image_3d_url']) ?>" width="200" height="150" style="border: none;"></iframe>
                        <?php else: ?>
                            <span>No 3D image</span>
                        <?php endif; ?>
                    </td>

                    <td class="text-start" style="max-width: 400px; overflow: hidden; word-wrap: break-word; white-space: normal;">
                        <div style="max-height: 150px; overflow-y: auto;">
                            <?= nl2br(htmlspecialchars($car['description'] ?? '')) ?>
                        </div>
                    </td>

                    <td class="text-center">
                        <a href="/edit_car/<?= htmlspecialchars($car['id'] ?? 0) ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="/delete_car/<?= htmlspecialchars($car['id'] ?? 0) ?>" onclick="return confirm('Are you sure you want to delete this car?');" class="btn btn-danger btn-sm">Delete</a>
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